<?php
// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นหรือไม่
    if (
        isset($_POST['course_name']) && 
        isset($_POST['course_Code']) &&
        isset($_POST['course_description']) &&
        isset($_POST['group_id']) // เพิ่มตรงนี้
    ) {
        // เชื่อมต่อกับฐานข้อมูล
        include('../connections/connection.php');
        session_start();

        // กำหนดค่าตัวแปร
        $course_name = htmlspecialchars($_POST['course_name']);
        $course_code = htmlspecialchars($_POST['course_Code']);
        $course_description = htmlspecialchars($_POST['course_description']);
        $group_id = htmlspecialchars($_POST['group_id']); // เพิ่มตรงนี้

        // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
        if (isset($_FILES['c_img']) && $_FILES['c_img']['error'] == 0) {
            // รหัสเกิดข้อผิดพลาดเท่ากับ 0 หมายความว่ามีการอัปโหลดไฟล์ภาพ

            // ตรวจสอบประเภทของไฟล์ภาพและความสามารถในการอัปโหลด
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $_FILES['c_img']['tmp_name']);

            if (!in_array($file_type, $allowed_types) || !in_array($_FILES['c_img']['type'], $allowed_types)) {
                echo 'รูปภาพต้องเป็นไฟล์ประเภท JPEG, PNG, หรือ GIF เท่านั้น';
            } else {
                // ดำเนินการอัปโหลดไฟล์ภาพ
                $upload_dir = '../admin/teacher_process/img/';
                $uploaded_file = $upload_dir . basename($_FILES['c_img']['name']);

                if (move_uploaded_file($_FILES['c_img']['tmp_name'], $uploaded_file)) {
                    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                    $sql = "INSERT INTO courses (course_name, course_code, description, teacher_id, created_at, updated_at, group_id, c_img) 
                            VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$course_name, $course_code, $course_description, $user_id, $group_id, $uploaded_file]);
                    $db = null;
                    echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
                    echo "<script>window.history.back();</script>";
                } else {
                    echo 'ไม่สามารถอัปโหลดไฟล์รูปภาพได้';
                }
            }
        } else {
            // ไม่มีการอัปโหลดไฟล์รูปภาพ

            // กำหนดค่าว่างให้กับฟิลด์ c_img
            $uploaded_file = '';
            
            // ดำเนินการเพิ่มข้อมูลลงในฐานข้อมูล
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
            $sql = "INSERT INTO courses (course_name, course_code, description, teacher_id, created_at, updated_at, group_id, c_img) 
                    VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$course_name, $course_code, $course_description, $user_id, $group_id, $uploaded_file]);
            $db = null;
            echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
            echo "<script>window.history.back(-2);</script>";
        }
    } else {
        echo "Missing required fields.";
    }

}
?>
