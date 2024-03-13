<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือไม่ใช่บทบาท 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
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

if (!isset($_GET['quiz_id'])) {
    // ถ้าไม่มี quiz_id ให้เปลี่ยนเส้นทางไปที่หน้าหลักหรือหน้าที่คุณต้องการ
    header('Location: index.php');
    exit();
}

$quiz_id = $_GET['quiz_id'];

try {
    // เรียกข้อมูลแบบทดสอบจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่าผู้ใช้เคยทำแบบทดสอบนี้แล้วหรือไม่
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM quiz_results WHERE user_id = :user_id AND quiz_id = :quiz_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $quizTaken = ($result['count'] > 0);

} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    exit();
}
?>
<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    
    <main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <div class="card-title"> <h1 ><?php echo $quiz['quiz_title']; ?></h1> </div>
            <div class="row">
                <div class="col-sm-6">     
                    <h5>รายละเอียด: <?php echo $quiz['quiz_description']; ?></h5>
                    <h5>เวลาทำแบบทดสอบ: <?php echo $quiz['time_limit']; ?> น.</h5>
                    <h5>จำนวนข้อสอบ : <?php echo $quiz['question_limit']; ?> ข้อ</h5>
                </div> 
                <div class="col-sm-6 py-5">
                    <!-- เพิ่มลิงก์ที่นำไปยังหน้าทำแบบทดสอบ หรือ หน้าผลการสอบ ตามเงื่อนไข -->
                    <?php if ($quizTaken): ?>
                        <a class="btn btn-outline-primary" style="float: center;" href="quiz_results.php?quiz_id=<?php echo $quiz_id; ?>">ผลการสอบ</a>
                    <?php else: ?>
                        <a class="btn btn-outline-primary" style="float: center;" href="#" onclick="confirmStartQuiz()">ทำแบบทดสอบ</a>
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
<script>
    function confirmStartQuiz() {
        if (confirm("คุณต้องการเริ่มทำแบบทดสอบหรือไม่?")) {
            window.location.href = "take_quiz.php?quiz_id=<?php echo $quiz_id; ?>";
        }
    }
</script>

</body>
</html>

