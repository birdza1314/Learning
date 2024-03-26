<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการส่งข้อมูลผ่านแบบฟอร์ม POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีการส่ง course_id มาหรือไม่
    if(isset($_POST['course_id'])) {
        $course_id = $_POST['course_id'];

        // ตรวจสอบว่ามีการส่ง lesson_id มาหรือไม่
        if(isset($_POST['lesson_id'])) {
            $lesson_id = $_POST['lesson_id'];

            // ตรวจสอบว่ามีการส่ง embed_code และ description มาหรือไม่
            if(isset($_POST['embed_code']) && isset($_POST['description'])) {
                $embed_code = $_POST['embed_code'];
                $description = $_POST['description'];

                // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลลงในตาราง videos_embed
                $stmt = $db->prepare("INSERT INTO videos_embed (lesson_id, embed_code, description) VALUES (:lesson_id, :embed_code, :description)");
                $stmt->bindParam(':lesson_id', $lesson_id);
                $stmt->bindParam(':embed_code', $embed_code);
                $stmt->bindParam(':description', $description);

                // บันทึกข้อมูล
                if ($stmt->execute()) {
                    // เก็บค่า ID ล่าสุดที่เพิ่มเข้าไปในตาราง videos_embed
                    $last_video_id = $db->lastInsertId();

                    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในตาราง add_topic
                    $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, video_embed_id,topic_type) VALUES (:lesson_id, :video_embed_id,:topic_type)");
                    $stmt_add_topic->bindParam(':lesson_id', $lesson_id);
                    $stmt_add_topic->bindParam(':video_embed_id', $last_video_id);
                    $stmt_add_topic->bindParam(':topic_type', $topic_type); // ประกาศ $topic_type ก่อนการใช้งานและกำหนดค่าของมัน

                    // ตรวจสอบว่า $topic_type ถูกกำหนดค่าไว้ก่อนการใช้งานหรือไม่
                    $topic_type = 'วิดีโอ';
                    
                    // Execute คำสั่ง SQL
          if ($stmt_add_topic->execute()) {
            echo "<script>alert('บันทึกข้อมูลเสร็จสิ้น');</script>";
            echo "<script>window.history.back();</script>";
          } else {
            echo "บันทึกข้อมูลลงในตาราง add_topic ล้มเหลว: " . $stmt_add_topic->errorInfo()[2];
            exit();
          }
        } else {
          echo "บันทึกข้อมูลลงในตาราง videos_" . $video_type . " ล้มเหลว: " . $stmt->errorInfo()[2];
          exit();
        }
      } else {
        echo "Invalid video type.";
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
