<?php
require "../db/connect.php"; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["username"])) {
        echo json_encode(["error" => "User not logged in."]);
        exit();
    }

    // Get the logged-in user's username
    $username = $_SESSION["username"];

    try {
        // Fetch the user ID from the users table
        $stmt_user = $conn->prepare("SELECT user_id FROM users WHERE user_username = :user_username");
        $stmt_user->bindParam(':user_username', $username);
        $stmt_user->execute();

        if ($stmt_user->rowCount() > 0) {
            $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
            $userId = $user['user_id'];

            // Fetch conversion history for the user
            $stmt_history = $conn->prepare(
                "SELECT FromCurrency, ToCurrency, ConversionRate, AmountConverted, ConvertedAmount, ConversionDate
                 FROM conversionhistory
                 WHERE user_id = :user_id
                 ORDER BY ConversionDate DESC"
            );
            $stmt_history->bindParam(':user_id', $userId);
            $stmt_history->execute();

            $history = $stmt_history->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($history); // Send the history as JSON
        } else {
            echo json_encode(["error" => "User not found."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
