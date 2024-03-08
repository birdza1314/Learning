<?php
include('../connections/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $new_status = $_POST['new_status'];
    $comment = $_POST['comment']; // เพิ่มการรับค่า comment จาก AJAX request

    // Retrieve current last_updated value from the database
    $stmt_last_updated = $db->prepare("SELECT last_updated FROM submitted_assignments WHERE id = :assignment_id");
    $stmt_last_updated->bindParam(':assignment_id', $assignment_id);
    $stmt_last_updated->execute();
    $current_last_updated = $stmt_last_updated->fetchColumn();

    // Update status and comment in the database
    $stmt = $db->prepare("UPDATE submitted_assignments SET status = :new_status, comment = :comment, last_updated = :current_last_updated WHERE id = :assignment_id");
    $stmt->bindParam(':new_status', $new_status);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':current_last_updated', $current_last_updated); // ใช้ค่า last_updated เดิม
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();

    // Return success message or any other relevant data
    echo "Status and comment updated successfully";
}
?>

