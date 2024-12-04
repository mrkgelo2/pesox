<?php 
require("../db/connect.php");


// Function to check for special characters
function containsSpecialCharacters($str) {
    // Pattern to match any character that is not alphanumeric or whitespace
    $pattern = '/[^\w\s]/';
    return preg_match($pattern, $str);
}
function noValue($str){
    $space ='/^\s*$/';
    return preg_match($space,$str);

}

if(noValue($_POST['user_name']) || noValue($_POST['user_password'])){
    echo "<script>alert('One or more fields are empty. Please remove them and try again.');</script>";
   exit(0);}
// Check for special characters in each input field
if (
    containsSpecialCharacters($_POST['user_name']) ||
    containsSpecialCharacters($_POST['user_password'])
) {
    // If any field contains special characters, display an alert and prevent adding the user
    echo "<script>alert('One or more fields contain special characters. Please remove them and try again.');</script>";
} else {
    // Proceed with adding the user to the database
    $save = 'INSERT INTO users (user_name,user_username,user_password)
    VALUES (:user_name,:user_username, :user_password)';

    $saveUser = $conn -> prepare($save);
    $saveUser->bindParam(':user_name', $_POST['user_name']);
    $saveUser->bindParam(':user_username', $_POST['user_username']);
    $saveUser->bindParam(':user_password', $_POST['user_password']);
    $saveUser->execute();

 header('location:../login.php');
}

?>