<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Update</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/buyer_order_update.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>

<body>
<div class="order-status">

  <!-- Back Button -->
  <button class="back-btn" onclick="window.location.href='Seller_order_status.php'">
    <i class="fas fa-arrow-left"></i> Back
  </button>

  <h1>Order Update</h1>
  <p class="order-id"><strong>Order ID:</strong> #12345</p>

  <!-- Delivery Steps -->
  <div class="tracking">
    <div class="step" id="step-1">
      <span class="status-dot"></span>
      <p class="status-label">Order Placed</p>
      <p class="status-time" id="time-1">Completed</p>
    </div>
    <div class="step" id="step-2">
      <span class="status-dot"></span>
      <p class="status-label">Shipped</p>
      <p class="status-time" id="time-2">Processing...</p>
    </div>
    <div class="step" id="step-3">
      <span class="status-dot"></span>
      <p class="status-label">Out for Delivery</p>
      <p class="status-time" id="time-3"></p>
    </div>
    <div class="step" id="step-4">
      <span class="status-dot"></span>
      <p class="status-label">Delivery</p>
      <p class="status-time" id="time-4"></p>
    </div>
  </div>

  <!-- Current Location -->
  <div class="current-location">
    <h2>Current Location</h2>
    <p id="current-location">Warehouse</p>
  </div>

  <!-- Time Remaining -->
  <div class="time-remaining">
    <h2>Estimated Time Remaining</h2>
    <p id="remaining-time">Calculating...</p>
  </div>
</div>

<script>
  // Function to check if all steps are completed
  function checkAllStepsCompleted() {
    // Select all status-time elements
    const steps = document.querySelectorAll('.status-time');
    let allCompleted = true;

    // Iterate over the steps to check if all are completed
    steps.forEach(step => {
      console.log(step.textContent.trim()); // Debug: log status to see if it's being updated correctly
      if (step.textContent.trim() !== 'Completed' && step.textContent.trim() !== 'Delivered!') {
        allCompleted = false; // If any step is not completed, set allCompleted to false
      }
    });

    // Check if both the "Estimated Time Remaining" and "Delivery" statuses are "Delivered!"
    const estimatedTime = document.getElementById('remaining-time');
    const deliveryStatus = document.getElementById('time-4');
    
    if (estimatedTime && deliveryStatus && estimatedTime.textContent.trim() === "Delivered!" && deliveryStatus.textContent.trim() === "Delivered!") {
      allCompleted = true; // Consider all steps completed if both "Delivered!" statuses are set
    }

    // If all steps are completed, redirect to Seller_order_status_complete.php after 3 seconds
    if (allCompleted) {
      console.log("All steps are completed. Redirecting..."); // Debug: see if this is triggered
      // Clear any previous redirection (if any)
      clearTimeout(window.redirectTimeout);
      
      // Set a timeout to redirect after 3 seconds
      window.redirectTimeout = setTimeout(() => {
        window.location.href = 'Seller_order_status_complete.php'; // Trigger redirection
      }, 3000); // 3000 milliseconds = 3 seconds
    }
  }

  // Call the function initially to handle pre-existing statuses
  checkAllStepsCompleted();

  // Add event listeners to dynamically monitor status changes
  document.querySelectorAll('.status-time').forEach(step => {
    const observer = new MutationObserver(() => {
      console.log("Status changed. Rechecking steps..."); // Debug: log when status changes
      checkAllStepsCompleted(); // Recheck whenever the text changes
    });

    // Observe changes in the text content of each status-time element
    observer.observe(step, { childList: true, subtree: true });
  });
</script>






  <script src="js/Buyer_order_update.js"></script>
</body>
</html>
