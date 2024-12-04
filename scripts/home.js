const key = "PVnaB2n4TB2ydqw7gZL3pahJgWPp69xR"; // API key for the FreeCurrencyAPI

const state = {
  openedDrawer: null,
  currencies: [],
  filteredCurrencies: [],
  base: "PHP",
  target: "USD",
  rates: {},
  baseValue: 1,
};

const ui = {
  controls: document.getElementById("controls"),
  drawer: document.getElementById("drawer"),
  dismissBtn: document.getElementById("dismiss-btn"),
  currencyList: document.getElementById("currency-list"),
  searchInput: document.getElementById("search"),
  baseBtn: document.getElementById("base"),
  targetBtn: document.getElementById("target"),
  exchangeRate: document.getElementById("exchange-rate"),
  baseInput: document.getElementById("base-input"),
  targetInput: document.getElementById("target-input"),
  swapBtn: document.getElementById("swap-btn"),
  convertBtn: document.getElementById("convert-btn"), // Added reference to the "Convert" button
};

// Event Listeners
const setupEventListeners = () => {
  document.addEventListener("DOMContentLoaded", initApp);
  ui.baseBtn.addEventListener("click", () => showDrawer("base"));
  ui.targetBtn.addEventListener("click", () => showDrawer("target"));
  ui.dismissBtn.addEventListener("click", hideDrawer);
  ui.searchInput.addEventListener("input", filterCurrency);
  ui.currencyList.addEventListener("click", selectPair);
  ui.swapBtn.addEventListener("click", switchPair);
  ui.convertBtn.addEventListener("click", handleConversion); // Event listener for the "Convert" button
};

const initApp = async () => {
  await fetchCurrencies();
  await fetchExchangeRate();
};

const showDrawer = (drawerType) => {
  state.openedDrawer = drawerType;
  ui.drawer.classList.add("show");
};

const hideDrawer = () => {
  clearSearchInput();
  state.openedDrawer = null;
  ui.drawer.classList.remove("show");
};

const filterCurrency = () => {
  const keyword = ui.searchInput.value.trim().toLowerCase();
  state.filteredCurrencies = state.currencies.filter(({ short_code, name }) =>
    short_code.toLowerCase().includes(keyword) || name.toLowerCase().includes(keyword)
  );
  displayCurrencies();
};

const selectPair = async (e) => {
  if (e.target.closest("li") && e.target.closest("li").hasAttribute("data-code")) {
    const selectedCurrency = e.target.closest("li").dataset.code;
    if (state.openedDrawer === "base") {
      state.base = selectedCurrency;
    } else if (state.openedDrawer === "target") {
      state.target = selectedCurrency;
    }
    hideDrawer();
    await fetchExchangeRate(); 
  }
};

// Conversion logic triggered by the button click
const handleConversion = () => {
  const { rates, base, target } = state;
  state.baseValue = parseFloat(ui.baseInput.value) || 1;

  if (rates[base] && rates[base][target]) {
    const convertedValue = state.baseValue * rates[base][target];
    ui.targetInput.value = convertedValue.toFixed(4);

    // Save the conversion in the database
    saveConversion(base, target, state.baseValue, convertedValue, rates[base][target]);
  }
};

// Save conversion to the server
const saveConversion = async (base, target, baseValue, convertedValue, rate) => {
  try {
    const response = await fetch("../saves/historySave.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        base,
        target,
        baseValue,
        convertedValue,
        rate,
      }),
    });

    const result = await response.json();
    if (response.ok) {
      console.log("Conversion saved:", result);
    } else {
      console.error("Error saving conversion:", result.error);
    }
  } catch (error) {
    console.error("Network error:", error);
  }
};

const switchPair = async () => {
  [state.base, state.target] = [state.target, state.base];
  await fetchExchangeRate();
};

const displayCurrencies = () => {
  ui.currencyList.innerHTML = state.filteredCurrencies
    .map(({ short_code, name }) => `
      <li data-code="${short_code}">
        <img src="${getImageURL(short_code)}" alt="${name}" />
        <div>
          <h4>${short_code}</h4>
          <p>${name}</p>
        </div>
      </li>
    `)
    .join("");
};

const displayConversion = () => {
  updateButtons();
  updateExchangeRate();
};

const updateButtons = () => {
  ui.baseBtn.textContent = state.base;
  ui.baseBtn.style.setProperty("--image", `url(${getImageURL(state.base)})`);
  ui.targetBtn.textContent = state.target;
  ui.targetBtn.style.setProperty("--image", `url(${getImageURL(state.target)})`);
};

const updateExchangeRate = () => {
  const { rates, base, target } = state;
  if (rates[base] && rates[base][target]) {
    ui.exchangeRate.textContent = `1 ${base} = ${rates[base][target].toFixed(4)} ${target}`;
  }
};

const clearSearchInput = () => {
  ui.searchInput.value = "";
  state.filteredCurrencies = state.currencies;
  displayCurrencies();
};

const getImageURL = (short_code) => {
  const flagURL = "https://wise.com/public-resources/assets/flags/rectangle/{short_code}.png";
  return flagURL.replace("{short_code}", short_code.toLowerCase());
};

const fetchCurrencies = async () => {
  try {
    const response = await fetch(`https://api.currencybeacon.com/v1/currencies?api_key=${key}`);
    const { response: currencies } = await response.json();
    state.currencies = Object.values(currencies);
    state.filteredCurrencies = state.currencies;
    displayCurrencies();
  } catch (error) {
    console.error(error);
  }
};

const fetchExchangeRate = async () => {
  const { base } = state;
  if (!base) return;
  try {
    const response = await fetch(`https://api.currencybeacon.com/v1/latest?api_key=${key}&base=${base}`);
    const { rates } = await response.json();
    state.rates[base] = rates;
    displayConversion();
  } catch (error) {
    console.error(error);
  }
};


// function to Fetch Data from API
async function fetchExchangeRates() {
  //const apiUrl = `https://api.frankfurter.dev/v1/2024-01-01..?base=${base}&symbols={target}`;
  const apiUrl = `https://api.frankfurter.dev/v1/2024-01-01..?base=PHP&symbols=USD`;
  try {
      const response = await fetch(apiUrl);
      const jsonData = await response.json();
      return jsonData;
  } catch (error) {
      console.error('Error fetching data:', error);
      return null;
  }
}

// function to process json data 
function processData(jsonData) {
  const labels = Object.keys(jsonData.rates); 
  const data = labels.map(date => jsonData.rates[date].USD);

  return { labels, data };
}

// function to create the Chart using chat. js
async function createChart() {
  const jsonData = await fetchExchangeRates(); // Fetch JSON data from the API

  if (!jsonData) {
      console.error('No data available to create chart.');
      return;
  }

  const { labels, data } = processData(jsonData);


  //chart.js code to display graph of USD rates against PHP from jan 2024 to present
  const ctx = document.getElementById('myChart').getContext('2d');
  new Chart(ctx, {
      type: 'line',
      data: {
          labels: labels, 
          datasets: [{
              data: data, 
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: '#004d8f',
              borderWidth: 2,
              fill: false
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: {
                  display: false,
              },
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return `USD: ${tooltipItem.raw}`;
                      }
                  }
              }
          },
          scales: {
              x: {
                  ticks: {
                      display: true,
                      maxTicksLimit: 10 
                  },
                  grid: {
                      display: false,
                  },
                  title: {
                      display: true,
                      text: 'Date',
                  }
              },
              y: {
                  ticks: {
                      display: true,
                      maxTicksLimit: 10, 
                  },
                  grid: {
                      display: false, 
                  },
                  title: {
                      display: true,
                      text: 'Rate',
                  }
              }
          }
      }
  });
}

setupEventListeners();
createChart();

