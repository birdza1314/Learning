<?php
// Include database connection
include('../../connections/connection.php');

// Check if classes is provided
if(isset($_GET['classes'])) {
    // Fetch distinct classrooms based on the provided classes
    $classes = $_GET['classes'];
    $stmt = $db->prepare("SELECT DISTINCT classroom FROM students WHERE classes = ?");
    $stmt->execute([$classes]);
    $classrooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return classrooms as JSON
    echo json_encode($classrooms);
} else {
    // Return empty array if classes is not provided
    echo json_encode([]);
}
?>
