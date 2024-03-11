<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าผู้ใช้ไม่ได้เข้าสู่ระบบหรือไม่ใช่บทบาท 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    try {
        // Prepare SQL statement to select course details
        $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
    
        // Fetch course details
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // ถ้าไม่มีคอร์ส ID ที่ระบุ ให้เปลี่ยนเส้นทางไปที่หน้าหลักหรือหน้าที่คุณต้องการ
    header("Location: index.php");
    exit();
}
try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    
    <main id="main" class="main">
    <div class="card">
    <div class="card-body">
    <div class="card-title">
        <h1>ลงทะเบียนเรียน</h1>
    </div>
    <div class="card py-5">
        <div class="row">
            <div class="col-lg-4 ms-5">
                <h3>คอร์สที่คุณต้องการลงทะเบียน:</h3>
                <div class="card" style="width: 18rem;">
                    <img src="<?= $course['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $course['course_name']; ?></h5>
                        <p class="card-text">รหัสวิชา: <?= $course['course_code']; ?></p>
                        <?php
                        // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
                        $teacher_id = $course['teacher_id'];
                        $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                        $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                        $teacher_stmt->execute();
                        $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <p class="card-text">ครูผู้สอน: <?= $teacher['first_name']; ?> <?= $teacher['last_name']; ?></p>
                    </div>
                </div>
            </div>
            <?php if (empty($course['access_code'])): ?>
                <!-- ถ้าไม่มีการกำหนดรหัสลงทะเบียน -->
                <div class="col-lg-4 mt-5">
                <!-- แสดงเฉพาะปุ่มลงทะเบียน -->
                <h3>กดเพื่อลงทะเบียน</h3>
                <form action="registeration_course_no_pass.php?course_id=<?php echo $course_id; ?>" method="POST">
                    <button type="submit" class="btn btn-primary btn-lg">ลงทะเบียน</button>
                </form>
            </div>

            <?php else: ?>
                <!-- ถ้ามีการกำหนดรหัสลงทะเบียน -->
                <div class="col-lg-4">
                    <!-- แสดงฟอร์มกรอกรหัสลงทะเบียน -->
                    <h3>กรอกรหัสเพื่อลงทะเบียน</h3>
                    <form action="registeration_course.php?course_id=<?php echo $course_id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="access_code" class="form-label">รหัสลงทะเบียน<span style="color: red;">*</span></label>
                            <input type="password" class="form-control" id="access_code" name="access_code" required>
                        </div>
                        <input type="hidden" name="course_id" value="<?= $course_id; ?>">
                        <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
                    </form>
                </div>
            <?php endif; ?>
                    </div>
        </div>
    </div>
</div>

    </main>
    <!-- ======= Footer ======= -->
    <?php include('footer.php');?>
    <!-- ======= scripts ======= -->
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <?php include('scripts.php');?>
</body>
</html>
