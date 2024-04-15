<?php
include('../connections/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $course_id = $_POST['course_id'];
    $new_access_code = $_POST['new_access_code'];

    try {
        // ทำคำสั่ง SQL เพื่ออัปเดต access_code ในตาราง courses
        $stmt = $db->prepare("UPDATE courses SET access_code = :new_access_code WHERE c_id = :course_id");
        $stmt->bindParam(':new_access_code', $new_access_code);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // หลังจากอัปเดตสำเร็จ สามารถให้ปิด Modal ได้
        echo '<script>
              alert("Access Code updated successfully");
              window.location.href = "course"; // ให้กลับไปที่หน้าหลักหลังจากการอัปเดต
            </script>';
    } catch (PDOException $e) {
        // กรณีเกิดข้อผิดพลาด
        echo "Error: " . $e->getMessage();
    }
}
?>
