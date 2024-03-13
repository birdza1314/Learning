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

try {
    // กำหนดค่า student_id
    $student_id = $_SESSION['user_id'];

    // ทำคำสั่ง SQL เพื่อดึงข้อมูลผลการสอบทั้งหมดของนักเรียน
    $stmt = $db->prepare("SELECT qr.quiz_id, qr.score, qr.timestamp, q.quiz_title 
                          FROM quiz_results qr 
                          JOIN quizzes q ON qr.quiz_id = q.quiz_id 
                          WHERE qr.user_id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    // ดึงข้อมูลผลการสอบจากผลลัพธ์ของคำสั่ง SQL
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ทำสิ่งที่ต้องการกับ $results ต่อไป เช่น แสดงผลหรือประมวลผลเพิ่มเติม
    // ...

} catch (PDOException $e) {
    // แสดงข้อผิดพลาดหากเกิดข้อผิดพลาดในการดึงข้อมูล
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
                <h1>Quiz Results</h1>
            </div>
            <?php if(!empty($results)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                            <th>Score</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $results[0]['quiz_title']; ?></td>
                            <td <?php echo (isset($results[0]['total_questions']) && $results[0]['score'] < $results[0]['total_questions'] / 2) ? 'style="color:red;"' : 'style="color:green;"'; ?>>
                                <?php echo $results[0]['score']; ?>
                            </td>
                            <td><?php echo $results[0]['timestamp']; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>ไม่พบผลการสอบ</p>
            <?php endif; ?>
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
