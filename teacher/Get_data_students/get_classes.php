<?php
// Include database connection
include('../../connections/connection.php');

// Fetch distinct years from students table
$stmt = $db->query("SELECT DISTINCT classes FROM students");
$classes = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Return years as JSON
echo json_encode($classes);
?>
