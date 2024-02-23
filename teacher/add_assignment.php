<?php
include('../connections/connection.php');

// ตรวจสอบว่ามี Lesson ID และ Course ID ที่ถูกส่งมาหรือไม่
if (!isset($_GET['lesson_id']) || !isset($_GET['course_id'])) {
    echo "Lesson ID or Course ID not provided.";
    exit; // หยุดการทำงานของสคริปต์เพื่อป้องกันการดำเนินการต่อ
}

// ดึงข้อมูล Lesson จาก URL
$lesson_id = $_GET['lesson_id'];
$course_id = $_GET['course_id'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่ม Assignment</title>
</head>
<body>
  <h1>เพิ่ม Assignment</h1>
  <form action="save_assignment.php?lesson_id=<?php echo $lesson_id; ?>&course_id=<?php echo $course_id; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    <label for="title">หัวข้อ Assignment:</label>
    <input type="text" name="title" id="title" required>
    <br>
    <label for="description">รายละเอียด Assignment:</label>
    <textarea name="description" id="description" required></textarea>
    <br>
    <label for="file_path">ไฟล์ Assignment:</label>
    <input type="file" name="file_path" id="file_path">
    <br>
    <label for="weight">น้ำหนัก Assignment:</label>
    <input type="number" name="weight" id="weight" required>
    <br>
    <label for="open_time">เปิด Assignment เมื่อ:</label>
    <input type="datetime-local" name="open_time" id="open_time" required>
    <br>
    <label for="deadline">กำหนดส่ง Assignment (Due date):</label>
    <input type="datetime-local" name="deadline" id="deadline" required>
    <br>
    <label for="close_time">ปิด Assignment เมื่อ:</label>
    <input type="datetime-local" name="close_time" id="close_time" required>
    <br>
    <label for="status">สถานะ:</label>
    <select name="status" id="status" required>
        <option value="open">เปิด</option>
        <option value="closed">ปิด</option>
    </select>
    <br>
    <button type="submit" name="submit">เพิ่ม Assignment</button>
  </form>
</body>
</html>