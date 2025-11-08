<?php
session_start();

// File to store users
$userFile = __DIR__ . "/users.json";

// Load users
if (!file_exists($userFile)) {
    file_put_contents($userFile, json_encode([]));
}
$users = json_decode(file_get_contents($userFile), true);

// Handle signup
$signupMessage = "";
if (isset($_POST['signup'])) {
    $username = trim($_POST['signup_username']);
    $password = trim($_POST['signup_password']);
    if (isset($users[$username])) {
        $signupMessage = "Username already exists!";
    } else {
        $users[$username] = password_hash($password, PASSWORD_DEFAULT);
        file_put_contents($userFile, json_encode($users));
        $signupMessage = "Signup successful! You can log in now.";
    }
}

// Handle login
$loginMessage = "";
if (isset($_POST['login'])) {
    $username = trim($_POST['login_username']);
    $password = trim($_POST['login_password']);
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['username'] = $username;
        $loginMessage = "Login successful!";
    } else {
        $loginMessage = "Invalid username or password!";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SaturnComputing - Webserver</title>
  <style>
    /* keep your existing CSS here */
    body { font-family: 'Segoe UI', sans-serif; background-color: white; color: black; text-align: center; }
    header { padding: 40px 20px 10px; }
    header p { font-size: 24px; margin: 0; }
    h1 { font-size: 36px; margin-bottom: 40px; }
    nav button { margin: 0 10px; padding: 10px 20px; font-size: 16px; cursor: pointer; border: none; border-radius: 5px; background-color: #f0f0f0; }
    nav button:hover { background-color: #ddd; }
    section { display: none; flex-direction: column; align-items: center; width: 100%; max-width: 800px; }
    section.active { display: flex; }
    form { margin: 20px; display: flex; flex-direction: column; align-items: center; }
    input { padding: 8px; margin: 5px; width: 200px; }
    button.submit-btn { margin-top: 10px; }
  </style>
</head>
<body>

<header>
  <?php if (isset($_SESSION['username'])): ?>
      <p>Hello, <?=htmlspecialchars($_SESSION['username'])?>! <a href="?logout=1">Logout</a></p>
  <?php else: ?>
      <form method="post">
          <h3>Login</h3>
          <input type="text" name="login_username" placeholder="Username" required>
          <input type="password" name="login_password" placeholder="Password" required>
          <button type="submit" name="login" class="submit-btn">Login</button>
          <p style="color:red;"><?= $loginMessage ?></p>
      </form>
      <form method="post">
          <h3>Signup</h3>
          <input type="text" name="signup_username" placeholder="Username" required>
          <input type="password" name="signup_password" placeholder="Password" required>
          <button type="submit" name="signup" class="submit-btn">Signup</button>
          <p style="color:green;"><?= $signupMessage ?></p>
      </form>
  <?php endif; ?>
</header>

<script>
function showSection(id) {
  document.querySelectorAll("section").forEach(section => {
    section.classList.remove("active");
  });
  const target = document.getElementById(id);
  if (target) target.classList.add("active");
}
</script>

</body>
</html>
