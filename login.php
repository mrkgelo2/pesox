<?php 
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PesoX | Login</title>
  <link rel="stylesheet" href="./css/login-register.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="icon-container">
        <img src="https://via.placeholder.com/80" alt="User Icon" class="user-icon">
      </div>
      <h2>Log in</h2>
      <form action="saves/loginValidate.php" method="post">
        <div class="input-group">
          <input type="text" id="user_username" name="user_username" placeholder="Username" required>
        </div>
        <div class="input-group">
          <input type="password" id="user_password" name="user_password" placeholder="Password" required>
        </div>
        <input class="login-button" type="submit" value="Login"/>
        <div class="login-options">
          <p>Don't have an account? <a href="Register.php">Register here</a></p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
