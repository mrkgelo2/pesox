
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/history.css">
</head>
<body>
<?php 
    include('../partials/navbar.php')
?>
<div class="main">
<div id="history-container">
  <h1>CONVERSION HISTORY</h1>
  <table id="history-table">
    <thead>
      <tr>
        <th>From</th>
        <th>To</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>Converted Value</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
</div>
<?php 
    include('../partials/footer.php')
?>
<script src="../scripts/history.js"></script>

</body>
</html>