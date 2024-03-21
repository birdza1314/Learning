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

// ตรวจสอบว่ามีค่าของ Quiz_id ที่ส่งมาหรือไม่
if (!isset($_GET['quiz_id'])) {
    header('Location: index.php');
    exit();
}

$quiz_id = $_GET['quiz_id'];

try {
    $stmt = $db->prepare("SELECT qr.score, qr.timestamp, q.question_limit, q.quiz_title 
                          FROM quiz_results qr 
                          JOIN quizzes q ON qr.quiz_id = q.quiz_id 
                          WHERE qr.user_id = :user_id AND qr.quiz_id = :quiz_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
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
                    <h1>ผลการสอบ</h1>
                </div>
                <?php if(!empty($results)): ?>
                    <div class="card">
                        <div class="card-body">
                            <?php foreach ($results as $result): ?>
                                <p><strong>หัวข้อ:</strong> <?php echo $result['quiz_title']; ?></p>
                                <p><strong>คะแนน:</strong> <span style="<?php echo ($result['score'] < $result['question_limit'] / 2) ? 'color:red;' : 'color:green;'; ?>"><?php echo $result['score']; ?></span></p>
                                <p><strong>คะแนนเต็ม:</strong> <?php echo $result['question_limit']; ?></p>
                                <p><strong>ส่งเมื่อ:</strong> <?php echo $result['timestamp']; ?></p>
                                <hr>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>ไม่พบผลการสอบ</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include('footer.php');?>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <?php include('scripts.php');?>
</body>
</html>
