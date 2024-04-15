<?php
// Include database connection
include('../connections/connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from POST request
    $classes = $_POST['classes'];
    $classroom = $_POST['classroom'];
    $course_id = $_POST['course_id'];

    // Perform the database operation to save registration
    // Example SQL query (replace with your actual query)
    $stmt = $db->prepare("INSERT INTO student_course_registration (student_id, course_id, registration_date, classes, classroom) 
                          SELECT s_id, ?, CURRENT_TIMESTAMP(), ?, ? FROM students WHERE classes = ? AND classroom = ?");
    $stmt->execute([$course_id, $classes, $classroom, $classes, $classroom]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        echo "ลงทะเบียนนักเรียนสำเร็จ !";   
    } else {
        echo "ลงทะเบียนไม่สำเร็จ! ";
    }
} else {
    // If the form is not submitted via POST, return an error message
    echo "Error: Form submission method is not POST. โปรดติดต่อผู้ดูแลระบบ!!!";
}
?>
