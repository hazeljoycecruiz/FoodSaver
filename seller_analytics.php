<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Analytics Dashboard</title>

  <link href="img/favicon.ico" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="css/seller_analytics.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&family=Nunito:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome (for the back arrow icon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background: url("img/background.png") ;
    }
   /* Updated canvas styling */
canvas {
  max-width: 500px;  /* Adjusted for better visibility */
  max-height: 400px;
  min-width: 300px;  /* Prevent shrinking */
  min-height: 300px; /* Prevent shrinking */
  margin: 0 auto;    /* Center the canvas */
}

/* Updated chart container styling */
.chart {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px; /* Added spacing between charts */
}

/* Optional: Ensure charts section has adequate space */
.charts {
  padding: 20px;
  display: flex;
  flex-wrap: wrap; /* Handle responsiveness */
  justify-content: space-around; /* Align charts evenly */
  gap: 20px; /* Add spacing between charts */
}


    /* Styling for back button and title similar to order_status */
    .back-btn {
      font-size: 1.2rem;
      color: #FF6B6B;
      text-decoration: none;
      border: none;
      background: transparent;
      padding: 10px;
    }

    .back-btn:hover {
      color: #ff4949;
    }

    .title-container {
      margin: 20px 0;
      text-align: center;
    }

    .title-container input {
      background-color: white;
      color: black;
      font-family: 'Heebo', sans-serif;
      font-size: 1.25rem;
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
  </style>

</head>
<body>
  
  <div class="container py-4">
    <!-- Back Button aligned with title and content -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="back-btn" onclick="window.location.href='Seller_index.php'">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>
    <div class=" mb-4" style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <input class="form-control" type="text" value="        Data Analytics" 
        aria-label="Disabled input example" disabled readonly 
        style="background-color: white; color: black; border-radius: 8px;">
    </div>


    <div class="dashboard" style="width: 100000px; max-width: 100%;  background-color: #ffe6e2;">

      <!-- Stats Section -->
      <section class="stats mb-4">
        <div class="stat-box">
          <h2>Total Store</h2>
          <p>30</p>
        </div>
        <div class="stat-box">
          <h2>Total Menu</h2>
          <p>100</p>
        </div>
        <div class="stat-box">
          <h2>Total Users</h2>
          <p>56</p>
        </div>
        <div class="stat-box">
          <h2>Total Sales</h2>
          <p>956</p>
        </div>
      </section>

      <!-- Charts Section -->
      <section class="charts">
        <div class="top-charts">
            <!-- Existing Charts -->
            <div class="chart">
                <h3>Orders by Status</h3>
                <canvas id="pieChart"></canvas>
            </div>
            <div class="chart">
                <h3>Best Selling Product</h3>
                <canvas id="donutChart"></canvas>
            </div>
        </div>
        <div class="bottom-charts">
            <div class="chart full-width">
                <h3>Orders by Payment Type and Source</h3>
                <canvas id="barChart"></canvas>
            </div>
            <!-- New Pie Chart for Age Group -->
            <div class="chart">
                <h3>Buyers by Age Group</h3>
                <canvas id="ageGroupChart"></canvas>
            </div>
       
    
        </div>
      </section>
    </div>
  </div>
  </div>

  <script>
        // Pie Chart for Orders by Status
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
          type: 'pie',
          data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
              data: [10, 20, 5], // Example data, replace with actual data 721, 200, 35
              backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
          }
        });

        // Donut Chart for Best Selling Product
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutChart = new Chart(donutCtx, {
          type: 'doughnut',
          data: {
            labels: ['Product A', 'Product B', 'Product C'],
            datasets: [{
              data: [15, 30, 10], // Example data, replace with actual data example data 319, 250, 352   
              backgroundColor: ['#FF5733', '#33FF57', '#5733FF']
            }]
          }
        });

        // Bar Chart for Orders by Payment Type and Source
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
          type: 'bar',
          data: {
            labels: ['Credit Card', 'PayPal', 'Bank Transfer'],
            datasets: [{
              label: 'Orders',
              data: [10, 25, 15], // Example data, replace with actual data
              backgroundColor: '#FF5733'
            }]
          },
          options: {
            responsive: true,
            scales: {
              x: { beginAtZero: true },
              y: { beginAtZero: true }
            }
          }
        });

        // Pie Chart for Buyers by Age Group
        const ageGroupCtx = document.getElementById('ageGroupChart').getContext('2d');
        const ageGroupChart = new Chart(ageGroupCtx, {
          type: 'pie',
          data: {
            labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
            datasets: [{
              data: [25, 35, 20, 10, 5], // Example data, replace with actual data
              backgroundColor: ['#FF5733', '#33FF57', '#5733FF', '#FFBD33', '#FF66B2']
            }]
          }
        });

     

  </script>
</body>
</html>
