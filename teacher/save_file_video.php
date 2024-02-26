<?php
// Include database connection
include('../connections/connection.php');

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if course_id is set
  if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Check if lesson_id is set
    if (isset($_POST['lesson_id'])) {
      $lesson_id = $_POST['lesson_id'];

      // Check if description_file is set
      if (isset($_POST['description_file'])) {
        $description_file = $_POST['description_file'];

        // Check if video_file is set
        if (isset($_FILES['video_file'])) {
          $video_file = $_FILES['video_file']['name'];
          $video_tmp = $_FILES['video_file']['tmp_name'];
          $file_path = "uploads/video_file/$video_file";

          // Check if video file is not empty
          if (!empty($video_file)) {
            // Check video file size
            if ($_FILES['video_file']['size'] > 10485760) {
              echo "ไฟล์มีขนาดใหญ่เกินไป";
              exit();
            }

            // Check allowed file types
            $allowed_file_types = array('mp4', 'mov', 'avi');
            $file_ext = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
            if (!in_array($file_ext, $allowed_file_types)) {
              echo "ไฟล์รูปแบบไม่รองรับ";
              exit();
            }

            // Move uploaded file to destination
            move_uploaded_file($video_tmp, $file_path);
          } else {
            echo "No video file uploaded.";
            exit();
          }
                // **เพิ่มการตรวจสอบว่า lesson_id มีอยู่ในตาราง lessons หรือไม่**
                $stmt_check_lesson = $db->prepare("SELECT * FROM lessons WHERE lesson_id = :lesson_id");
                $stmt_check_lesson->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
                $stmt_check_lesson->execute();

                if ($stmt_check_lesson->rowCount() === 0) {
                echo "<script>alert('Lesson ID ไม่ถูกต้อง');</script>";
                exit();
                }
          // Prepare SQL statement to insert video file data into database
          $stmt = $db->prepare("INSERT INTO videos_file (lesson_id, file_name, file_path, description_file) VALUES (:lesson_id, :file_name, :file_path, :description_file)");
          $stmt->bindParam(':lesson_id', $lesson_id);
          $stmt->bindParam(':file_name', $video_file);
          $stmt->bindParam(':file_path', $file_path);
          $stmt->bindParam(':description_file', $description_file);

          // Execute SQL statement to insert video file
          if ($stmt->execute()) {
            // Get the last inserted video ID
            $last_video_id = $db->lastInsertId();

            // Prepare SQL statement to insert data into add_topic table
            $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, video_file_id) VALUES (:lesson_id, :video_file_id)");
            $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
            $stmt_add_topic->bindParam(':video_file_id', $last_video_id);

            // Execute SQL statement to insert data into add_topic table
            if ($stmt_add_topic->execute()) {
              echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
              echo "<script>window.location.href = 'add_lessons.php?course_id=$course_id';</script>";
            } else {
              echo "บันทึกข้อมูลลงในตาราง add_topic ล้มเหลว: " . $stmt_add_topic->errorInfo()[2];
              exit();
            }
          } else {
            echo "Error: เกิดข้อผิดพลาดในการบันทึกข้อมูลไฟล์วิดีโอ";
            exit();
          }
        } else {
          echo "Video file is required.";
          exit();
        }
      } else {
        echo "Description is required.";
        exit();
      }
    } else {
      echo "Lesson ID is required.";
      exit();
    }
  } else {
    echo "Course ID is required.";
    exit();
  }
} else {
  echo "Invalid request method.";
  exit();
}
?>
