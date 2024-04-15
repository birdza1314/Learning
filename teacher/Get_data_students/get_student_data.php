<?php
// Include database connection
include('../../connections/connection.php');

// Check if the student ID is provided in the POST request
if(isset($_POST['student_id'])) {
    // Sanitize and get the student ID from the POST data
    $student_username = $_POST['student_id'];
    
    try {
        // Prepare SQL query to retrieve student data by username
        $stmt = $db->prepare("SELECT s_id, first_name, last_name, classes, classroom FROM students WHERE username = ?");
        $stmt->execute([$student_username]);
        
        // Fetch student data
        $student_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if student data exists
        if($student_data) {
            // Return student data as JSON response
            echo json_encode($student_data);
        } else {
            // If no student data found, return empty response
            echo json_encode(null);
        }
    } catch (PDOException $e) {
        // If any database error occurs, return error message
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If student ID is not provided in the POST request, return error message
    echo json_encode(['error' => 'Student ID not provided']);
}
?>
