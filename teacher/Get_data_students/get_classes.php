<?php

// Include database connection
include('../../connections/connection.php');

// Define the classes you want to fetch
$selectedClasses = [1, 2, 3, 4, 5, 6];

// Prepare a parameterized query to select distinct classes from students table
$stmt = $db->prepare("SELECT DISTINCT classes FROM students WHERE classes IN (" . implode(',', array_fill(0, count($selectedClasses), '?')) . ")");

// Bind selected classes as parameters
foreach ($selectedClasses as $key => $class) {
    $stmt->bindValue(($key+1), $class, PDO::PARAM_INT);
}

// Execute the query
$stmt->execute();

// Fetch the results
$classes = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Return classes as JSON
echo json_encode($classes);

?>
