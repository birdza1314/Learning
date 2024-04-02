<?php
// Include database connection
include('../connections/connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from POST request
    $year = $_POST['year'];
    $classroom = $_POST['classroom'];
    $course_id = $_POST['course_id'];

    // Perform the database operation to save registration
    // Example SQL query (replace with your actual query)
    $stmt = $db->prepare("INSERT INTO student_course_registration (student_id, course_id, registration_date, classroom, year) 
                          SELECT s_id, ?, CURRENT_TIMESTAMP(), ?, ? FROM students WHERE year = ? AND classroom = ?");
    $stmt->execute([$course_id, $classroom, $year, $year, $classroom]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        echo "ลงทะเบียนนักเรียนสำเร็จ !";   
    } else {
        echo "ลงทะเบียนไม่สำเร็จ! ";
    }
} else {
    // If the form is not submitted via POST, return an error message
    echo "Error: Form submission method is not POST. โปนดติดต่อผู้ดุแลระบบ!!!";
}
?>
