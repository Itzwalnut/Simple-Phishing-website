<?php
session_start();

$DEFAULT_USER = 'Alex';
$DEFAULT_PASS = '1234';
$error = '';

// If a prefill was set by fake_web.php, copy into local vars for auto-submit
$prefill_user = '';
$prefill_pass = '';
if (!empty($_SESSION['prefill_username'])) {
    $prefill_user = $_SESSION['prefill_username'];
    $prefill_pass = isset($_SESSION['prefill_password']) ? $_SESSION['prefill_password'] : '';
}

// Handle POST login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  if ($username === $DEFAULT_USER && $password === $DEFAULT_PASS) {
    // login success - set session and clear any prefill
    $_SESSION['username'] = $username;
    unset($_SESSION['prefill_username'], $_SESSION['prefill_password']);
    header('Location: true_mainpage.php');
    exit;
  } else {
    $error = 'Invalid username or password.';
    // if we had a prefill attempt, clear it to avoid infinite auto-retry
    unset($_SESSION['prefill_username'], $_SESSION['prefill_password']);
  }
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
    <input type="text" id="username" name="username" required autofocus value="<?= htmlspecialchars($prefill_user ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required value="<?= htmlspecialchars($prefill_pass ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <input type="submit" value="Login">
  </form>

  <?php if (!empty($error)): ?>
    <script>
      // Show a popup alert when credentials are incorrect. Use a safe JSON-encoded string.
      window.addEventListener('load', function(){
        alert(<?= json_encode($error) ?>);
      });
    </script>
  <?php endif; ?>

  <?php if (!empty($prefill_user)): ?>
    <script>
      // If the page was reached with prefill credentials, auto-submit once.
      // Delay slightly so fields are populated and the browser can focus.
      window.addEventListener('load', function(){
        // Only auto-submit if no manual POST has happened yet
        var form = document.querySelector('form');
        if (form) {
          // submit the form automatically
          form.submit();
        }
      });
    </script>
  <?php endif; ?>


</body>
</html>