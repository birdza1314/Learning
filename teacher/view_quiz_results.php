<?php
session_start();
include('../connections/connection.php');

// ตรวจสอบว่าผู้ใช้เป็นครูหรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ใช่ครูให้เปลี่ยนเส้นทางไปที่หน้าที่คุณต้องการ
    header('Location: ../login.php'); 
    exit();
}
try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
try {
    // ดึงคะแนนของนักเรียนในแบบทดสอบนี้
    $quiz_id = $_GET['quiz_id'];
    $stmt = $db->prepare("SELECT qr.user_id, qr.score, qr.timestamp, qr.total_questions, s.first_name 
                          FROM quiz_results qr 
                          JOIN students s ON qr.user_id = s.s_id 
                          WHERE qr.quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();

    // ดึงข้อมูลผลการสอบจากผลลัพธ์ของคำสั่ง SQL
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // แสดงข้อผิดพลาดหากเกิดข้อผิดพลาดในการดึงข้อมูล
    echo "Error: " . $e->getMessage();
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
            
       <table class="table table-borderless datatable">
        <thead>
            <tr>
                <th>สอบครั้งที่</th>
                <th>ชื่อนักเรียน</th>
                <th>คะแนน</th>
                <th>คะแนนเต็ม</th>
                <th>สถานะ</th>
                <th>เวลาส่ง</th>
            </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
            <?php foreach ($results as $result): ?>
            <tr>
            <td><?php echo $counter++; ?></td>
                <td><?php echo $result['first_name']; ?></td>
                <td <?php echo ($result['score'] < $result['total_questions'] / 2) ? 'style="color:red;"' : 'style="color:green;"'; ?>>
                    <?php echo $result['score']; ?>
                </td>
                <td><?php echo $result['total_questions']; ?></td>
                <td style="color: <?php echo ($result['score'] < $result['total_questions'] / 2) ? 'red' : 'green'; ?>">
                    <?php echo ($result['score'] < $result['total_questions'] / 2) ? 'ไม่ผ่าน' : 'ผ่าน'; ?>
                </td>

                <td><?php echo $result['timestamp']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- ======= Footer ======= -->
    <?php include('footer.php');?>
    <!-- ======= scripts ======= -->
  
    <?php include('scripts.php');?>
</body>
</html>
