const key = "PVnaB2n4TB2ydqw7gZL3pahJgWPp69xR"; 

const state = {
    currencies: [],
    filteredCurrencies: [],
    rates: {},
};

const ui = {
    currencyList: document.getElementById("currency-list"),
    loadingMessage: document.getElementById("loading-message"),
};

const fetchCurrencies = () => {
    fetch(`https://api.currencybeacon.com/v1/currencies?api_key=${key}`)
        .then((response) => response.json())
        .then(({ response }) => {
            state.currencies = Object.values(response);
            state.filteredCurrencies = state.currencies;
            fetchLatestRates(); 
        })
        .catch(error => {
            console.error(error);
            ui.loadingMessage.textContent = "Failed to load currencies.";
        });
};

const fetchLatestRates = async () => {
    const baseCurrency = document.getElementById('base-currency').value.toUpperCase();
    const url = `https://api.currencybeacon.com/v1/latest?base=${baseCurrency}&api_key=${key}`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        state.rates = data.rates; 
        displayCurrencies();
        ui.loadingMessage.style.display = 'none';
    } catch (error) {
        console.error('Error fetching currency data:', error);
        ui.loadingMessage.textContent = "Failed to load currency rates.";
    }
};

const getImageURL = (short_code) => {
    const flagURL = "https://wise.com/public-resources/assets/flags/rectangle/{short_code}.png";
    return flagURL.replace("{short_code}", short_code.toLowerCase());
};

const displayCurrencies = () => {
    ui.currencyList.innerHTML = state.filteredCurrencies
        .map(({ short_code, name }) => {
            const rate = state.rates[short_code] || 'N/A';
            const previousRate = getPreviousRate(short_code); 
            let changeIndicator = '—'; 

            if (previousRate !== undefined) {
                if (rate > previousRate) {
                    changeIndicator = '&#8593;';
                } else if (rate < previousRate) {
                    changeIndicator = '&#8595;'; 
                }
            }

            return `
                <tr data-code="${short_code}">
                    <td>
                        <img src="${getImageURL(short_code)}" alt="${name}" style="width: 20px; height: auto; margin-right: 5px;" />
                        ${short_code}
                    </td>
                    <td>${name}</td>
                    <td>${rate}</td>
                    <td class="${rate > previousRate ? 'trend-up' : (rate < previousRate ? 'trend-down' : '')}">${changeIndicator}</td>
                </tr>
            `;
        })
        .join("");
};

const getPreviousRate = (currency) => {
    // To be implemented, get previous currency rates
    const previousRates = {
        'EUR': 0.85, 
        'GBP': 0.75,
        'JPY': 110.00,
        'USD': 1.00
    };
    return previousRates[currency];
};

// Fetch currencies on page load
document.addEventListener("DOMContentLoaded", fetchCurrencies);