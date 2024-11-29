<?php
session_start();
include 'database/db_connection.php';

// Get the selected items from the request body
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['selectedItems'])) {
    $_SESSION['selected_items'] = $data['selectedItems']; // Store selected items in session
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No items selected']);
}
?>
