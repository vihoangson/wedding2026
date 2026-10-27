<?php

namespace App\Services;

use Illuminate\Support\Carbon;

/**
 * "Add to calendar" data for the wedding party: a Google Calendar link and
 * an iCalendar (.ics) file for iPhone / Outlook / other calendar apps.
 * Times are converted from the venue's timezone to UTC.
 */
class WeddingCalendar
{
    public function start(): Carbon
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i',
            config('wedding.wedding_date').' '.config('wedding.wedding_time'),
            config('wedding.timezone', 'Asia/Ho_Chi_Minh')
        )->seconds(0)->utc();
    }

    public function end(): Carbon
    {
        return $this->start()->addMinutes((int) config('wedding.duration_minutes', 180));
    }

    public function title(): string
    {
        return 'Đám cưới '.config('wedding.groom_name').' & '.config('wedding.bride_name');
    }

    public function location(): string
    {
        return config('wedding.venue_full_name').', '.config('wedding.venue_location');
    }

    public function description(): string
    {
        return 'Trân trọng kính mời bạn đến dự lễ thành hôn của '
            .config('wedding.groom_name').' & '.config('wedding.bride_name').".\n"
            .config('wedding.wedding_time_label').': '.config('wedding.wedding_time')."\n"
            .'Chỉ đường: https://www.google.com/maps/search/?api=1&query='.urlencode(config('wedding.google_maps_query'));
    }

    public function googleUrl(): string
    {
        return 'https://calendar.google.com/calendar/render?'.http_build_query([
            'action' => 'TEMPLATE',
            'text' => $this->title(),
            'dates' => $this->start()->format('Ymd\THis\Z').'/'.$this->end()->format('Ymd\THis\Z'),
            'details' => $this->description(),
            'location' => $this->location(),
        ], '', '&', PHP_QUERY_RFC3986);
    }

    public function ics(): string
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//wedding//invite//VI',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            // Stable UID so re-importing updates the same event instead of duplicating it.
            'UID:wedding-'.config('wedding.wedding_date').'-'.md5(config('wedding.groom_name').config('wedding.bride_name')).'@invite',
            'DTSTAMP:'.now()->utc()->format('Ymd\THis\Z'),
            'DTSTART:'.$this->start()->format('Ymd\THis\Z'),
            'DTEND:'.$this->end()->format('Ymd\THis\Z'),
            'SUMMARY:'.self::escape($this->title()),
            'LOCATION:'.self::escape($this->location()),
            'DESCRIPTION:'.self::escape($this->description()),
            'BEGIN:VALARM',
            'ACTION:DISPLAY',
            'DESCRIPTION:'.self::escape('Ngày mai: '.$this->title()),
            'TRIGGER:-P1D',
            'END:VALARM',
            'BEGIN:VALARM',
            'ACTION:DISPLAY',
            'DESCRIPTION:'.self::escape($this->title()),
            'TRIGGER:-PT2H',
            'END:VALARM',
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return implode("\r\n", array_map([self::class, 'fold'], $lines))."\r\n";
    }

    private static function escape(string $text): string
    {
        return str_replace(['\\', ';', ',', "\r\n", "\n"], ['\\\\', '\;', '\,', '\n', '\n'], $text);
    }

    /**
     * Fold content lines longer than 75 octets (RFC 5545 §3.1) without
     * splitting a multi-byte UTF-8 character.
     */
    private static function fold(string $line): string
    {
        $out = '';
        $current = '';

        foreach (mb_str_split($line) as $char) {
            if (strlen($current) + strlen($char) > ($out === '' ? 75 : 74)) {
                $out .= ($out === '' ? '' : "\r\n ").$current;
                $current = '';
            }
            $current .= $char;
        }

        return $out === '' ? $current : $out."\r\n ".$current;
    }
}
