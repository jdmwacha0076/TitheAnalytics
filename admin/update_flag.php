<?php
include '../configurations.php';
include '../functions.php';

// Check if the required parameters are set
if (isset($_POST['phoneNumber']) && isset($_POST['flagValue'])) {
    $phoneNumber = $_POST['phoneNumber'];
    $flagValue = $_POST['flagValue'];

    // Update the flag in the database
    $updateSql = "UPDATE tithe_collection SET flag_value = ? WHERE member_id IN (SELECT member_id FROM all_members WHERE phoneNumber = ?)";
    
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('is', $flagValue, $phoneNumber);

    if ($stmt->execute()) {
        // The flag was successfully updated
        echo json_encode(['success' => true, 'message' => 'Flag updated successfully']);
    } else {
        // An error occurred during the update
        echo json_encode(['success' => false, 'message' => 'Error updating flag']);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Invalid parameters
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}

// Close the database connection
$conn->close();
?>
