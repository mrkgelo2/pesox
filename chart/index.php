<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>PesoX</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="css/main.css" />

        <script
            src="https://kit.fontawesome.com/b115137311.js"
            crossorigin="anonymous"
        ></script>
    </head>
    <body>
    <?php 
    include('../partials/navbar.php')
?>   
        

        <div class="main">
        <h1>
                <span class="from-label">Euro</span> to
                <span class="to-label">US</span> Exchange Rate Chart
            </h1>
            <div class="container">
            <div class="graph__container">
                <div class="grid graph__controls">
                    <h5 class="from-text">From</h5>
                    <div class="dropdown from">
                        <input id="fromInput" />
                        <div id="fromDropdownContent" class="dropdown__content">
                            <option>EUR</option>
                            <option>USD</option>
                            <option>JPY</option>
                            <option>BGN</option>
                            <option>CZK</option>
                            <option>DKK</option>
                            <option>GBP</option>
                            <option>HUF</option>
                            <option>PLN</option>
                            <option>RON</option>
                            <option>SEK</option>
                            <option>CHF</option>
                            <option>ISK</option>
                            <option>NOK</option>
                            <option>HRK</option>
                            <option>RUB</option>
                            <option>TRY</option>
                            <option>AUD</option>
                            <option>BRL</option>
                            <option>CAD</option>
                            <option>CNY</option>
                            <option>HKD</option>
                            <option>IDR</option>
                            <option>ILS</option>
                            <option>INR</option>
                            <option>KRW</option>
                            <option>MXN</option>
                            <option>MYR</option>
                            <option>NZD</option>
                            <option>PHP</option>
                            <option>SGD</option>
                            <option>THB</option>
                            <option>ZAR</option>
                        </div>
                    </div>
                    <button class="switch-btn" id="switchBtn">
                        <i class="fas fa-exchange-alt fa-lg"></i>
                    </button>
                    <h5 class="to-text">To</h5>
                    <div class="dropdown to">
                        <input id="toInput" />
                        <div id="toDropdownContent" class="dropdown__content">
                            <option>EUR</option>
                            <option>USD</option>
                            <option>JPY</option>
                            <option>BGN</option>
                            <option>CZK</option>
                            <option>DKK</option>
                            <option>GBP</option>
                            <option>HUF</option>
                            <option>PLN</option>
                            <option>RON</option>
                            <option>SEK</option>
                            <option>CHF</option>
                            <option>ISK</option>
                            <option>NOK</option>
                            <option>HRK</option>
                            <option>RUB</option>
                            <option>TRY</option>
                            <option>AUD</option>
                            <option>BRL</option>
                            <option>CAD</option>
                            <option>CNY</option>
                            <option>HKD</option>
                            <option>IDR</option>
                            <option>ILS</option>
                            <option>INR</option>
                            <option>KRW</option>
                            <option>MXN</option>
                            <option>MYR</option>
                            <option>NZD</option>
                            <option>PHP</option>
                            <option>SGD</option>
                            <option>THB</option>
                            <option>ZAR</option>
                        </div>
                    </div>
                </div>

                <div class="graph__info">
                    <div class="graph__label">
                        <h3>
                            <span class="from-label">EUR</span> to
                            <span class="to-label">USD</span> Chart
                        </h3>
                    </div>

                    <div>
                        <h3>
                            1 <span class="from-label">EUR</span> =
                            <span id="latestValue">1.17282</span>
                            <span class="to-label">USD</span>
                            <span id="latestDate">Aug 12, 2021, 14:53 UTC</span>
                        </h3>
                    </div>
                </div>

                <div class="graph__date-selection">
                    <button class="date-btn">1W</button>
                    <button class="date-btn selected">1M</button>
                    <button class="date-btn">1Y</button>
                    <button class="date-btn">2Y</button>
                    <button class="date-btn">5Y</button>
                    <button class="date-btn">10Y</button>
                </div>

                <div class="graph">
                    <canvas id="graph"></canvas>
                </div>
            </div>
        </div>
        </div>

        

        <script type="module" src="../chart/js/main.js"></script>

        <?php 
    include('../partials/footer.php')
?>
    </body>
</html>
