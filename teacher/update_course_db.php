<?php
include('../connections/connection.php');
session_start();

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php');
    exit();
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นหรือไม่
    if (
        isset($_POST['course_id']) &&
        isset($_POST['course_name']) &&
        isset($_POST['course_code']) &&
        isset($_POST['course_description']) &&
        isset($_POST['group_id']) &&
        isset($_POST['is_open']) &&
        isset($_POST['access_code']) &&
        isset($_POST['class']) 
    ) {
        // เชื่อมต่อกับฐานข้อมูล
        include('../connections/connection.php');

        // รับค่าจากฟอร์ม
        $course_id = $_POST['course_id'];
        $course_name = htmlspecialchars($_POST['course_name']); // ป้องกัน XSS
        $course_code = htmlspecialchars($_POST['course_code']); // ป้องกัน XSS
        $course_description = htmlspecialchars($_POST['course_description']); // ป้องกัน XSS
        $group_id = $_POST['group_id'];
        $class = $_POST['class'];

        // ทำการอัปเดตข้อมูลในตาราง courses
        try {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
            // ตรวจสอบการอัปโหลดไฟล์รูปภาพ
            if (isset($_FILES['c_img']) && $_FILES['c_img']['error'] == 0) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($file_info, $_FILES['c_img']['tmp_name']);

                if (!in_array($file_type, $allowed_types) || !in_array($_FILES['c_img']['type'], $allowed_types)) {
                    echo 'รูปภาพต้องเป็นไฟล์ประเภท JPEG, PNG, หรือ GIF เท่านั้น';
                    exit();
                }

                $upload_dir = '../admin/teacher_process/img/';
                $uploaded_file = $upload_dir . basename($_FILES['c_img']['name']);

                if (!move_uploaded_file($_FILES['c_img']['tmp_name'], $uploaded_file)) {
                    echo 'ไม่สามารถอัปโหลดไฟล์รูปภาพได้';
                    exit();
                }

                $sql = "UPDATE courses 
                        SET course_name = ?, course_code = ?, description = ?, teacher_id = ?, updated_at = NOW(), group_id = ?, c_img = ?, is_open = ?, access_code = ? 
                        WHERE c_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    $course_name,
                    $course_code,
                    $course_description,
                    $user_id,
                    $group_id,
                    $uploaded_file,
                    $_POST['is_open'],
                    $_POST['access_code'],
                    $course_id
                ]);
            } else {
                $sql = "UPDATE courses 
                        SET course_name = ?, course_code = ?, description = ?, teacher_id = ?, updated_at = NOW(), group_id = ?, is_open = ?, access_code = ? 
                        WHERE c_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    $course_name,
                    $course_code,
                    $course_description,
                    $user_id,
                    $group_id,
                    $_POST['is_open'],
                    $_POST['access_code'],
                    $course_id
                ]);
            }
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $e->getMessage();
            exit();
        }

        // ทำการเพิ่มข้อมูลลงในตาราง student_course_registration
        try {
            $sql = "INSERT INTO student_course_registration (student_id, class, course_id) 
            SELECT s_id, :class, :course_id 
            FROM students 
            WHERE class = :class";       
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':class', $class);
            $stmt->bindParam(':course_id', $course_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลลงในตาราง student_course_registration: " . $e->getMessage();
            exit();
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $db = null;

        // ทำสิ่งที่คุณต้องการหลังจากบันทึกข้อมูล
        echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location.href = 'course.php?success=true';</script>";
    } else {
        echo "Missing required fields.";
    }
}
?>
