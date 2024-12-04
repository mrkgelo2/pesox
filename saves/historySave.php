<?php
require "../db/connect.php"; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['base']) && isset($data['target']) && isset($data['baseValue']) && isset($data['convertedValue']) && isset($data['rate'])) {
        $base = $data['base'];
        $target = $data['target'];
        $baseValue = $data['baseValue'];
        $convertedValue = $data['convertedValue'];
        $rate = $data['rate'];

        // Start session and check if the user is logged in
        session_start();
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

                // Insert the conversion into the database
                $stmt_conversion = $conn->prepare(
                    "INSERT INTO conversionhistory (user_id, FromCurrency, ToCurrency, ConversionRate, AmountConverted, ConvertedAmount)
                     VALUES (:user_id, :base, :target, :rate, :baseValue, :convertedValue)"
                );
                $stmt_conversion->bindParam(':user_id', $userId);
                $stmt_conversion->bindParam(':base', $base);
                $stmt_conversion->bindParam(':target', $target);
                $stmt_conversion->bindParam(':rate', $rate);
                $stmt_conversion->bindParam(':baseValue', $baseValue);
                $stmt_conversion->bindParam(':convertedValue', $convertedValue);

                $stmt_conversion->execute();

                echo json_encode(["message" => "Conversion saved successfully."]);
            } else {
                echo json_encode(["error" => "User not found."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid data provided."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
