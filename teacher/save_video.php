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
      
      // ตรวจสอบว่ามีการส่ง video_type มาหรือไม่
      if(isset($_POST['video_type'])) {
        $video_type = $_POST['video_type'];

        // เตรียมตัวแปรสำหรับ storing ข้อมูล
        $embed_code = null;
        $file_name = null;
        $file_path = null;
        $description = null;
        $description_file = null;

        // ตรวจสอบประเภทวิดีโอ
        if ($video_type === 'embed') {
          // รับข้อมูลจากฟอร์ม
          $embed_code = $_POST['embed_code'];
          $description = $_POST['description'];
        } elseif ($video_type === 'file') {
          // ตรวจสอบว่ามีการอัปโหลดไฟล์มาหรือไม่
          if(isset($_FILES['video_file'])) {
            $video_file = $_FILES['video_file']['name'];
            $video_tmp = $_FILES['video_file']['tmp_name'];
            $file_path = "uploads/video_file/$video_file"; // กำหนดพาธของไฟล์
            $description_file = $_POST['description_file']; // รับค่า description_file จากฟอร์ม

            // ตรวจสอบว่ามีไฟล์วิดีโอที่ถูกอัปโหลดหรือไม่
            if(!empty($video_file)) {
              // ตรวจสอบขนาดและรูปแบบไฟล์
              if ($_FILES['video_file']['size'] > 10485760) { // 10MB
                echo "ไฟล์มีขนาดใหญ่เกินไป";
                exit();
              }

              $allowed_file_types = array('mp4', 'mov', 'avi');
              $file_ext = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
              if (!in_array($file_ext, $allowed_file_types)) {
                echo "ไฟล์รูปแบบไม่รองรับ";
                exit();
              }

              // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
              move_uploaded_file($video_tmp, $file_path);

              // เก็บชื่อไฟล์
              $file_name = $video_file;
            } else {
              echo "No video file uploaded.";
              exit();
            }
          } else {
            echo "Video file is required.";
            exit();
          }
        } else {
          echo "Video type is required.";
          exit();
        }

        // เตรียมคำสั่ง SQL
        $stmt = null;
        if ($video_type === 'embed') {
          $stmt = $db->prepare("INSERT INTO videos_embed (lesson_id, embed_code, description) VALUES (:lesson_id, :embed_code, :description)");
          $stmt->bindParam(':lesson_id', $lesson_id);
          $stmt->bindParam(':embed_code', $embed_code);
          $stmt->bindParam(':description', $description);
        } elseif ($video_type === 'file') {
          $stmt = $db->prepare("INSERT INTO videos_file (lesson_id, file_name, file_path, description_file) VALUES (:lesson_id, :file_name, :file_path, :description_file)");
          $stmt->bindParam(':lesson_id', $lesson_id);
          $stmt->bindParam(':file_name', $file_name);
          $stmt->bindParam(':file_path', $file_path);
          $stmt->bindParam(':description_file', $description_file);
        }

        // บันทึกข้อมูล
        if ($stmt->execute()) {
          // นำค่า ID ล่าสุดที่เพิ่มเข้าไปในตาราง videos_embed หรือ videos_
          // นำค่า ID ล่าสุดที่เพิ่มเข้าไปในตาราง videos_embed หรือ videos_file มาเก็บไว้
          if ($video_type === 'embed') {
            $last_video_id = $db->lastInsertId();
          } else {
            $last_video_id = $db->lastInsertId();
          }

          // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในตาราง add_topic
          $stmt_add_topic = $db->prepare("INSERT INTO add_topic (lesson_id, video_embed_id, video_file_id) VALUES (:lesson_id, :video_embed_id, :video_file_id)");

          // ผูกค่าตัวแปร
          $stmt_add_topic->bindParam(':lesson_id', $lesson_id);

          // ตรวจสอบประเภทวิดีโอ
          if ($video_type === 'embed') {
            $stmt_add_topic->bindValue(':video_embed_id', $last_video_id);
            $stmt_add_topic->bindValue(':video_file_id', null); // ตั้งค่า null สำหรับ video_file_id
          } else {
            $stmt_add_topic->bindValue(':video_embed_id', null); // ตั้งค่า null สำหรับ video_embed_id
            $stmt_add_topic->bindValue(':video_file_id', $last_video_id);
          }

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
