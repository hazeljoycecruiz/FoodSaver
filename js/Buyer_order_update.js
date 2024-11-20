// Mock data for tracking updates
const steps = [
  { id: "step-1", status: "Order Placed", location: "Warehouse", time: "Completed" },
  { id: "step-2", status: "Shipped", location: "Distribution Center", time: "Processing..." },
  { id: "step-3", status: "Out for Delivery", location: "On the way", time: "30 minutes" },
  { id: "step-4", status: "Delivered", location: "Your Address", time: "Delivered!" },
];

let currentStep = 0;

// Function to update the status
function updateOrderStatus() {
  if (currentStep < steps.length) {
    const step = steps[currentStep];

    // Update status dot and text
    document.getElementById(step.id).querySelector(".status-dot").classList.add("active");
    document.getElementById(step.id).querySelector(".status-time").textContent = step.time;

    // Update location and time remaining
    document.getElementById("current-location").textContent = step.location;
    document.getElementById("remaining-time").textContent = step.time;

    currentStep++;
  }
}

// Simulate real-time updates every 5 seconds
setInterval(updateOrderStatus, 5000);
