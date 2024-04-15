<?php
include('../connections/connection.php');

// Check if group_id and class_id are set
if (isset($_POST['group_id']) && isset($_POST['class_id'])) {
    // Retrieve group_id and class_id from POST data
    $group_id = $_POST['group_id'];
    $class_id = $_POST['class_id'];

    try {
        // Prepare and execute SQL statement to retrieve courses filtered by group_id and class_id
        $stmt = $db->prepare("SELECT * FROM courses WHERE group_id = :group_id AND class_id = :class_id");
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display filtered courses
        foreach ($courses as $course) {
            // Your code to display course cards goes here
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="' . $course['c_img'] . '" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $course['course_name'] . '</h5>';
            echo '<p class="card-text">รหัสวิชา: ' . $course['course_code'] . '</p>';

            // Retrieve teacher information
            $teacher_id = $course['teacher_id'];
            $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
            $teacher_stmt->bindParam(':teacher_id', $teacher_id);
            $teacher_stmt->execute();
            $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);

            echo '<p class="card-text">ครูผู้สอน: ' . $teacher['first_name'] . ' ' . $teacher['last_name'] . '</p>';
            echo '<a href="course_details.php?course_id=' . $course['c_id'] . '" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>';
            echo '</div></div></div>';
        }
    } catch (PDOException $e) {
        // Display error if any
        echo "Error: " . $e->getMessage();
    }
} else {
    // If group_id and class_id are not set, return all courses
    // Your code to display all courses goes here
}
?>
