

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PesoX | Currency Converter</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>
    <link rel="stylesheet" href="../css/home.css" />
    <link rel="Icon" type="x-icon" href="../assets/PesoX Logo-mini.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
  <?php 
    include('../partials/navbar.php')
?>
    <div class="main">
    <h1>Currency Converter</h1>
        <main>
            <div class="controls" id="controls">
              <div class="control">
                <button id="base" data-drawer>PHP</button>
                <input type="number" id="base-input" value="0" min="0" step="0.01" />
              </div>
              <div class="control">
                <button id="target" data-drawer>USD</button>
                <input type="number" id="target-input" value="0" readonly />
              </div>
              <button class="swap-btn" id="swap-btn">
                <span class="material-symbols-outlined"> sync_alt </span>
              </button>
              <button id="convert-btn">Convert</button>
            </div>
      
            <div class="exchange-rate">
              <h5>Exchange Rate</h5>
              <span id="exchange-rate"></span>
            </div>
      
            <div class="drawer" id="drawer">
              <div class="title">
                <button id="dismiss-btn">
                  <span class="material-symbols-outlined"> west </span>
                </button>
                <h3>Select Currency</h3>
              </div>
              <div class="search">
                <input type="search" id="search" placeholder="Search" />
              </div>
              <ul class="currency-list" id="currency-list"></ul>
            </div>
          </main>
    </div>
    <div class="banner-section">
      <div class="banner">
        <div class="text-content">
          <h2>Convert to different currencies with PesoX</h2>
        </div>
      </div>
    </div>

<div class="chart-section">
  <div class="chart-container">
    <h1>Exchange Rate Chart</h1>
    <canvas id="myChart" width="900" height="400"></canvas>
</div>
</div>

    <div class="section">
        <h1>HOW TO CONVERT FOREIGN CURRENCIES</h1>
        <div class="steps">
          <div class="step">
            <h2>1</h2>
            <h3>Input your amount</h3>
            <p>Simply type in the box how much you want to convert.</p>
          </div>
          <div class="step">
            <h2>2</h2>
            <h3>Choose your currencies</h3>
            <p>Click on the drop-downs to select the currencies you want to convert between.</p>
          </div>
          <div class="step">
            <h2>3</h2>
            <h3>That's it</h3>
            <p>Our currency converter will show you the current rate and how it’s changed over the past day, week, or month.</p>
          </div>
        </div>
    </div>
    <script src="../scripts/home.js"></script>
<?php 
    include('../partials/footer.php')
?>
  </body>
</html>