<?php
session_start();
include('../connections/connection.php');

if(isset($_POST['group_id']) && isset($_POST['query'])) {
    $group_id = $_POST['group_id'];
    $query = $_POST['query'];

    try {
        // สร้าง query SQL โดยใช้ group_id และ query
        $sql = "SELECT * FROM courses WHERE group_id = :group_id AND (course_name LIKE :query OR course_code LIKE :query)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->execute();
        
        // เก็บผลลัพธ์ลงในตัวแปร courses
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลที่ตรงกับเงื่อนไขหรือไม่
        if(count($courses) > 0) {
            // แสดงผลลัพธ์ที่ได้จากการค้นหา
            foreach ($courses as $course) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card" style="width: 18rem;">';
                echo '<img src="' . $course['c_img'] . '" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $course['course_name'] . '</h5>';
                echo '<p class="card-text">รหัสวิชา: ' . $course['course_code'] . '</p>';
                
                // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
                $teacher_id = $course['teacher_id'];
                $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                $teacher_stmt->execute();
                $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                
                echo '<p class="card-text">ครูผู้สอน: ' . $teacher['first_name'] . ' ' . $teacher['last_name'] . '</p>';
                echo '<a href="course_details.php?course_id=' . $course['c_id'] . '" class="btn btn-outline-primary" style="float: right;">รายละเอียด</a>';
                echo '</div></div></div>';
            }
        } else {
            // ถ้าไม่มีข้อมูลที่ตรงกับเงื่อนไข
            echo "ไม่พบคอร์สที่ตรงกับเงื่อนไขที่คุณค้นหา";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "เกิดข้อผิดพลาดในการค้นหาคอร์ส: " . $e->getMessage();
    }
}
?>
