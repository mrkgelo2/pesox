<?php
require "../db/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['user_username']) && isset($_POST['user_password'])) {
        $username = $_POST['user_username'];
        $password = $_POST['user_password'];

        // Check if user exists in the user table
        $stmt_user = $conn->prepare("SELECT * FROM users WHERE user_username = :user_username AND user_password = :user_password");
        $stmt_user->bindParam(':user_username', $username);
        $stmt_user->bindParam(':user_password', $password);
        $stmt_user->execute();
        
        session_start();
        if ($stmt_user->rowCount() > 0) {
            $_SESSION["username"] = $username;
            header("Location: ../user/home.php");
            exit();
        }

        // // Check if user exists in the admin table
        // $stmt_admin = $conn->prepare("SELECT * FROM admin WHERE admin_username = :admin_username AND admin_password = :admin_password");
        // $stmt_admin->bindParam(':admin_username', $username);
        // $stmt_admin->bindParam(':admin_password', $password);
        // $stmt_admin->execute();

        // if ($stmt_admin->rowCount() > 0) {
        //     $_SESSION["username"] = $username;
        //     header("Location: ../home.php");
        //     exit();
        // }

        // If user doesn't exist in either table
        echo "Invalid username or password!";
    } else {
        echo "Username or password is not set!";
    }
}
?>