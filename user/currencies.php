<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Exchange Rates</title>
    <link rel="Icon" type="x-icon" href="../assets/Logo-mini.png">
    <link rel="stylesheet" href="../css/currencies.css">
</head>
<body>
<?php 
include('../partials/navbar.php')
?>    
    <div class="main">
        <main>
            <h1>Available Currencies</h1>
            <p id="loading-message">Loading currencies...</p>
            <div class="currency-input-container">
                <label for="base-currency">Base Currency:</label>
                <input type="text" id="base-currency" placeholder="e.g., USD" value="PHP" />
                <button onclick="fetchLatestRates()">Get Currency Rates</button>
            </div>
            <div class="table-container">
                <table id="currency-table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Name</th>
                            <th>Latest Rate</th>
                        </tr>
                    </thead>
                    <tbody id="currency-list">
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php 
include('../partials/footer.php')
?> 

<script src="../scripts/currencies.js">
</script>
</body>
</html>