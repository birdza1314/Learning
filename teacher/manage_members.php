<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php'); 
    exit();
}

// ตรวจสอบว่ามีการส่งค่า course_id มาหรือไม่
if (!isset($_GET['course_id'])) {
    // หากไม่มี course_id ให้กลับไปยังหน้าหลัก
    header('Location: index.php');
    exit();
}

$course_id = $_GET['course_id'];

// ดึงข้อมูลของคอร์ส
$stmt = $db->prepare("SELECT * FROM courses WHERE c_id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

// ดึงรายชื่อสมาชิกของคอร์ส
$stmt = $db->prepare("SELECT scr.student_id, s.first_name
                      FROM student_course_registration scr
                      INNER JOIN students s ON scr.student_id = s.s_id
                      WHERE scr.course_id = ?");
$stmt->execute([$course_id]);
$members = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Course Members</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Register Students</h2>
    <form action="register_student.php" method="post">
        <div class="form-group">
            <label for="year">Select Academic Year:</label>
            <select class="form-control" id="year" name="year">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<div class="container">
    <h2>Manage Course Members</h2>
    <p>Course Name: <?= $course['course_name']; ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= $member['student_id']; ?></td>
                    <td><?= $member['first_name']; ?></td>
                    <td>
                        <!-- Add delete button here -->
                        <a href="remove_member.php?course_id=<?= $course_id; ?>&student_id=<?= $member['student_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this member?')">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
