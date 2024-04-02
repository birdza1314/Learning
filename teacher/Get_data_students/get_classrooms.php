<?php
// Include database connection
include('../../connections/connection.php');

// Check if year is provided
if(isset($_GET['year'])) {
    // Fetch distinct classrooms based on the provided year
    $year = $_GET['year'];
    $stmt = $db->prepare("SELECT DISTINCT classroom FROM students WHERE year = ?");
    $stmt->execute([$year]);
    $classrooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return classrooms as JSON
    echo json_encode($classrooms);
} else {
    // Return empty array if year is not provided
    echo json_encode([]);
}
?>
