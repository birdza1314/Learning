<?php
session_start();
include('../connections/connection.php');

// คิวรี่สำหรับหาปีการศึกษาที่มากที่สุด
$sql = "SELECT MAX(year) AS max_year FROM students";
$stmt = $db->prepare($sql);
$stmt->execute();
$max_year_row = $stmt->fetch(PDO::FETCH_ASSOC);
$max_year = $max_year_row["max_year"];

// อัปเดตระดับชั้นสำหรับนักเรียนทั้งหมด
if(isset($_POST['update_levels'])){
    $new_level = 1;
    for($i = $max_year; $i >= $max_year - 5; $i--){
        if($new_level <= 6) {
            $update_sql = "UPDATE students SET classes = :new_level WHERE year = :year";
            $update_stmt = $db->prepare($update_sql);
            $update_stmt->bindParam(':new_level', $new_level);
            $update_stmt->bindParam(':year', $i);
            $update_stmt->execute();
        } 
        $new_level++;
    }
    // เมื่อมีค่ามากกว่า 6 จะทำการลบข้อมูล
    if($new_level > 6){
        $update_sql = "UPDATE students SET classes = 'จบการศึกษา' WHERE year = :year";
        $update_stmt = $db->prepare($update_sql);
        $update_stmt->bindParam(':year', $i);
        $update_stmt->execute();
    }

    // เพิ่มโค้ด JavaScript เพื่อแสดง Alert เมื่ออัปเดตเสร็จสิ้น และเปลี่ยนเส้นทาง URL กลับไปยังหน้าที่เดิม
    echo '<script type="text/javascript">';
    echo 'alert("อัปเดตระดับชั้นเรียบร้อยแล้ว");';
    echo 'window.location.href = document.referrer;'; // กลับไปยังหน้าเดิม
    echo '</script>';
}

$db = null; // ปิดการเชื่อมต่อฐานข้อมูล
?>

