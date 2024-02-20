<?php
// Include database connection
include('../connections/connection.php');

// Check if form is submitted
if(isset($_POST['Quiz_Title'])) {
    // Retrieve data from the form
    $lesson_id = $_POST['lesson_id'];
    $course_id = $_POST['course_id'];
    $timeLimit = $_POST['timeLimit'];
    $QuestDipLimit = $_POST['QuestDipLimit'];
    $Quiz_Title = $_POST['Quiz_Title'];
    $QuizDesc = $_POST['QuizDesc'];

    // Prepare SQL statement to insert quiz data into the database
    $stmt = $db->prepare("INSERT INTO quizzes (lesson_id, c_id, time_limit, question_limit, quiz_title, quiz_description) VALUES (:lesson_id, :c_id, :timeLimit, :QuestDipLimit, :Quiz_Title, :QuizDesc)");
    $stmt->bindParam(':lesson_id', $lesson_id);
    $stmt->bindParam(':c_id', $course_id);
    $stmt->bindParam(':timeLimit', $timeLimit);
    $stmt->bindParam(':QuestDipLimit', $QuestDipLimit);
    $stmt->bindParam(':Quiz_Title', $Quiz_Title);
    $stmt->bindParam(':QuizDesc', $QuizDesc);

    if ($stmt->execute()) {
        // Get the image_id of the newly inserted image
        $quiz_id = $db->lastInsertId();

        // Insert into add_topic table
        $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, quiz_id) VALUES (:lesson_id, :quiz_id)");
        $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
        $stmt_add_topic->bindParam(':quiz_id', $quiz_id); // เปลี่ยน $image_id เป็น $quiz_id
        if ($stmt_add_topic->execute()) {
            echo "<script>alert('อัปโหลดรูปภาพและบันทึกข้อมูลสำเร็จ');</script>";
            echo "<script>window.location.href = 'add_lessons.php?course_id=" . (isset($course_id) ? $course_id : '') . "';</script>";
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง add_topic: " . $stmt_add_topic->errorInfo()[2];
        }
        
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงในตาราง images: " . $stmt->errorInfo()[2];
    }

} else {
    // If form is not submitted, redirect back to the page with an error message
    echo "<script>window.location.href = 'add_lessons.php?error=Form not submitted';</script>";
}
?>
