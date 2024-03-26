<?php


include('../connections/connection.php');


// ตรวจสอบว่ามีค่า $_GET['group_id'] ที่ถูกส่งมาหรือไม่
if (isset($_GET['group_id'])) {
    // รับค่า group_id จาก URL
    $group_id = $_GET['group_id'];

    // คำสั่ง SQL เพื่อดึงข้อมูลของกลุ่มสาระนั้น ๆ
    $sql = "SELECT * FROM courses WHERE group_id = :group_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $group_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // ถ้าไม่มีค่า $_GET['group_id'] ที่ถูกส่งมาใน URL
    // คุณสามารถทำการจัดการข้อผิดพลาดได้ตามต้องการ
    echo "ไม่พบรหัสกลุ่มสาระ";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Details</title>
    <!-- เรียกใช้ CSS หรือ Bootstrap ตามต้องการ -->
</head>
<body>
    <h1>รายละเอียดกลุ่มสาระ</h1>
    <h2>รายวิชาที่อยู่ในกลุ่มสาระนี้:</h2>
    <ul>
        <?php foreach ($group_courses as $course): ?>
            <li><?php echo $course['course_name']; ?></li>
        <?php endforeach; ?>
    </ul>
    <!-- สร้างเนื้อหาอื่น ๆ ตามต้องการ -->
</body>
</html>
