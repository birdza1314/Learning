<?php
// เชื่อมต่อฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบการล็อกอินและบทบาทของผู้ใช้
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login'); 
    exit();
}
try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
// ตรวจสอบว่ามีค่า course_id ที่ถูกส่งมาหรือไม่
if (!isset($_GET['course_id'])) {
    // ถ้าไม่มีให้กลับไปยังหน้าหลัก
    header('Location: index.php');
    exit();
}

// รับค่า course_id จาก URL
$course_id = $_GET['course_id'];
// ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
// Prepare SQL statement to select course details
$stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id");
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();

// Fetch course details
$course = $stmt->fetch(PDO::FETCH_ASSOC);
// คำสั่ง SQL สำหรับดึงข้อมูลการเข้าเรียนของนักเรียนในคอร์สนี้
$sql = "SELECT s.username, s.first_name, s.last_name, 
               MAX(m.mark_date) AS last_mark_date,
               COUNT(m.mark_date) AS total_attendance,
               (COUNT(m.mark_date) / (SELECT COUNT(*) FROM marks_as_done WHERE course_id = :course_id) * 100) AS attendance_percentage,
               c.course_name
        FROM marks_as_done m 
        INNER JOIN students s ON m.student_id = s.s_id 
        INNER JOIN courses c ON m.course_id = c.c_id
        WHERE m.course_id = :course_id
        GROUP BY s.s_id
        ORDER BY total_attendance DESC";

try {
    // เตรียมคำสั่ง SQL
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    // ประมวลผลคำสั่ง SQL
    $stmt->execute();
    // เก็บผลลัพธ์ไว้ในตัวแปร $attendances
    $attendances = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // กรณีเกิดข้อผิดพลาดในการดึงข้อมูล
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>

<?php include('head.php'); ?>

<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <main id="main" class="main">
        <div class="card overflow-auto">
            <div class="card-body">
                <div class="card-header">
                    <h1>รายละเอียดการเข้าเรียน</h1>
                    <h3>ชื่อคอร์ส: <?= $course['course_name']; ?></h3>
                </div>

                <table class="table table-borderless datatable table-format ">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสนักเรียน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>วันที่ทำเครื่องหมายเข้าเรียนล่าสุด</th>
                            <th>จำนวนการเข้าเรียน</th>
                            <th>เปอร์เซ็นต์การเข้าเรียน</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($attendances as $index => $attendance): ?>
        <tr>
            <td><?= $index + 1; ?></td>
            <td><?= $attendance['username']; ?></td>
            <td><?= $attendance['first_name'] . ' ' . $attendance['last_name']; ?></td>
            <td><?= date('d/m/Y H:i A', strtotime($attendance['last_mark_date'])); ?></td>
            <td><?= $attendance['total_attendance']; ?></td>
            <td>
                <?php
                // Convert attendance percentage to integer
                $attendance_percentage = intval($attendance['attendance_percentage']);
                ?>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= $attendance_percentage; ?>%; <?php
                        if ($attendance_percentage <= 25) {
                            echo 'background-color: red;';
                        } elseif ($attendance_percentage <= 50) {
                            echo 'background-color: orange;';
                        } elseif ($attendance_percentage <= 75) {
                            echo 'background-color: yellow;';
                        } else {
                            echo 'background-color: green;';
                        }
                    ?>" aria-valuenow="<?= $attendance_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?= $attendance_percentage; ?>%</div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>



                </table>
            </div>
        </div>
    </main><!-- End #main -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ======= Footer ======= -->
    <?php include('footer.php'); ?>
    <!-- ======= scripts ======= -->
    <?php include('scripts.php'); ?>
</body>

</html>
