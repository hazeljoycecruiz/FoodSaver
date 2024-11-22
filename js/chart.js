const defaultOptions = {
  responsive: true,
  animation: false, // Disable animations
  scales: {
    x: { beginAtZero: true },
    y: { beginAtZero: true }
  }
};

// Pie Chart for Orders by Status
const pieChart = new Chart(document.getElementById('pieChart').getContext('2d'), {
  type: 'pie',
  data: {
    labels: ['Completed', 'Pending', 'Cancelled'],
    datasets: [{
      data: [10, 20, 5],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
    }]
  },
  options: { responsive: true, animation: false } // Disable animation
});

// Repeat for other charts
const donutChart = new Chart(document.getElementById('donutChart').getContext('2d'), {
  type: 'doughnut',
  data: {
    labels: ['Product A', 'Product B', 'Product C'],
    datasets: [{
      data: [15, 30, 10],
      backgroundColor: ['#FF5733', '#33FF57', '#5733FF']
    }]
  },
  options: defaultOptions
});

// Add animation: false to other charts as well
