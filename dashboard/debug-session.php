<?php
// DEBUG SESSION
session_start();

echo "=== SESSION DEBUG ===<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . session_status() . "<br>";
echo "Session Data: <pre>" . json_encode($_SESSION, JSON_PRETTY_PRINT) . "</pre>";

// Test POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['test_login'] = true;
    $_SESSION['test_time'] = time();
    echo "Session set. Redirecting...<br>";
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

echo "Current logged in: " . (isset($_SESSION['test_login']) ? 'YES' : 'NO') . "<br>";
?>

<form method="POST">
    <button type="submit">Test Set Session</button>
</form>

<?php if (isset($_SESSION['test_login'])): ?>
    <p style="color: green; font-weight: bold;">SESSION WORKING! ✅</p>
<?php else: ?>
    <p style="color: red; font-weight: bold;">SESSION NOT WORKING ❌</p>
<?php endif; ?>

