<?php
// Include database connection
include('../../connections/connection.php');

// Fetch distinct years from students table
$stmt = $db->query("SELECT DISTINCT year FROM students");
$years = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Return years as JSON
echo json_encode($years);
?>
