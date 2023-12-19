<?php
include '../configurations.php';
include '../functions.php';

if (isset($_POST['phoneNumber']) && isset($_POST['flagValue'])) {
    $phoneNumber = $_POST['phoneNumber'];
    $flagValue = $_POST['flagValue'];

    $updateSql = "UPDATE tithe_collection SET flag_value = ? WHERE member_id IN (SELECT member_id FROM all_members WHERE phoneNumber = ?)";

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('is', $flagValue, $phoneNumber);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Flag updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating flag']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}
$conn->close();
