const fetchConversionHistory = async () => {
    try {
      const response = await fetch("../getters/getHistory.php");
      const data = await response.json();
  
      if (response.ok) {
        displayConversionHistory(data);
      } else {
        console.error("Error fetching history:", data.error);
      }
    } catch (error) {
      console.error("Network error:", error);
    }
  };
  
  const displayConversionHistory = (history) => {
    const historyTableBody = document.querySelector("#history-table tbody");
  
    // Clear existing rows
    historyTableBody.innerHTML = "";
  
    // Populate table rows
    history.forEach((record) => {
      const conversionRate = parseFloat(record.ConversionRate);
      const amountConverted = parseFloat(record.AmountConverted);
      const convertedAmount = parseFloat(record.ConvertedAmount);
  
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${record.FromCurrency}</td>
        <td>${record.ToCurrency}</td>
        <td>${conversionRate.toFixed(4)}</td>
        <td>${amountConverted.toFixed(2)}</td>
        <td>${convertedAmount.toFixed(2)}</td>
        <td>${new Date(record.ConversionDate).toLocaleString()}</td>
      `;
      historyTableBody.appendChild(row);
    });
  };
  
  
  // Call the function when the app is loaded
  document.addEventListener("DOMContentLoaded", fetchConversionHistory);
  