<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pesox"; 

try {
    // PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Connection Failed (┬┬﹏┬┬): " . $e->getMessage();
}
?>
