<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PesoX | Register</title>
  <link rel="stylesheet" href="./css/login-register.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="icon-container">
        <img src="https://via.placeholder.com/80" alt="User Icon" class="user-icon">
      </div>
      <h2>Register</h2>
      <form action="saves/registerSave.php" method="post">
        <div class="input-group">
          <input id="inputs" type="text" id="user_name" name="user_name" placeholder="Full Name" required>
        </div>
        <div class="input-group">
          <input id="inputs" type="text" id="user_username" name="user_username" placeholder="Username" required>
        </div>
        <div class="input-group">
          <input  id="inputs" type="password" id="user_password" name="user_password" placeholder="Password" required>
        </div>
         <input class="login-button" type="submit" value="Submit"/>
        <div class="login-options">
          <p>Already have an account? <a href="login.php">Sign In</a></p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
