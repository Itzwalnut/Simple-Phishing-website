<?php
$DEFAULT_USER = 'Alex';
$DEFAULT_PASS = '1234';
$error = '';

// Handle POST login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  if ($username === $DEFAULT_USER && $password === $DEFAULT_PASS) {
    header('Location: true_mainpage.php');
    exit;
  } else {
    $error = 'Invalid username or password.';
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
    <input type="text" id="username" name="username" required autofocus>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

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


</body>
</html>