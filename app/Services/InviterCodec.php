<?php

namespace App\Services;

/**
 * Encodes/decodes the guest name carried in personalized invite links
 * (e.g. /invite/<token>).
 *
 * This is a byte-for-byte port of the original encodeInviterName()/
 * decodeInviterName() functions from the legacy PHP site (config.php),
 * so that invite links generated before the Laravel migration keep working.
 *
 * Technique: attach an integrity checksum (truncated HMAC-SHA256) to the
 * plain text, XOR the payload with the secret key, then base64-url-encode
 * it (no padding). The checksum lets us detect tampered/forged links.
 */
class InviterCodec
{
    /**
     * Encode a guest name into an opaque, URL-safe token.
     */
    public static function encode(string $plainText, string $key): string
    {
        if ($plainText === '') {
            return '';
        }

        $checksum = substr(hash_hmac('sha256', $plainText, $key), 0, 10);
        $payload = $checksum.'|'.$plainText;

        $xored = self::xorWithKey($payload, $key);

        return rtrim(strtr(base64_encode($xored), '+/', '-_'), '=');
    }

    /**
     * Decode a token produced by encode().
     *
     * Returns:
     *  - the original guest name string if the token is valid and intact
     *  - '' (empty string) if the token itself is empty
     *  - false if the token is malformed, corrupted, or tampered with
     *
     * @return string|false
     */
    public static function decode(string $encodedText, string $key)
    {
        if ($encodedText === '') {
            return '';
        }

        $b64 = strtr($encodedText, '-_', '+/');
        $mod4 = strlen($b64) % 4;
        if ($mod4 !== 0) {
            $b64 .= str_repeat('=', 4 - $mod4);
        }

        $xored = base64_decode($b64, true);
        if ($xored === false || $xored === '') {
            return false;
        }

        $payload = self::xorWithKey($xored, $key);

        $separatorPos = strpos($payload, '|');
        if ($separatorPos === false) {
            return false;
        }

        $checksum = substr($payload, 0, $separatorPos);
        $plainText = substr($payload, $separatorPos + 1);

        if ($plainText === '') {
            return false;
        }

        $expectedChecksum = substr(hash_hmac('sha256', $plainText, $key), 0, 10);
        if (! hash_equals($expectedChecksum, $checksum)) {
            return false;
        }

        return $plainText;
    }

    private static function xorWithKey(string $data, string $key): string
    {
        $result = '';
        $keyLen = strlen($key);
        for ($i = 0; $i < strlen($data); $i++) {
            $result .= chr(ord($data[$i]) ^ ord($key[$i % $keyLen]));
        }

        return $result;
    }
}
