<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php'); 
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

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

    $stmt = $db->prepare("SELECT q.question_text, q.choice_ch1, q.choice_ch2, q.choice_ch3, q.choice_ch4,q.correct_answer, q.description, sa.chosen_answer 
                          FROM student_answers sa
                          JOIN questions q ON sa.question_id = q.question_id
                          WHERE sa.student_id = :user_id AND sa.quiz_id = :quiz_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $student_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <h1>ผลการทำแบบทดสอบ</h1>
                </div>
                <?php if(!empty($results)): ?>
                    <div class="card">
                        <div class="card-body">
                            <?php foreach ($results as $result): ?>
                                <p><strong>หัวข้อ:</strong> <?php echo $result['quiz_title']; ?></p>
                                <p><strong>คะแนนที่ได้:</strong> <span style="<?php echo ($result['score'] < $result['question_limit'] / 2) ? 'color:red;' : 'color:green;'; ?>"><?php echo $result['score']; ?></span></p>
                                <p><strong>คะแนนเต็ม:</strong> <?php echo $result['question_limit']; ?></p>
                                <p><strong>ส่งเมื่อ:</strong> <?php echo $result['timestamp']; ?></p>
                                <hr>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if (!empty($student_answers)): ?>
                        <div class="card">
                            <div class="card-body py-2">
                                <h2>คำถามที่นักเรียนตอบผิด</h2>
                                <?php foreach ($student_answers as $answer): ?>
                                    <?php if ($answer['chosen_answer'] !== $answer['correct_answer']): ?>
                                        <p><strong>คำถาม:</strong> <?php echo $answer['question_text']; ?></p>
                                        <p><strong>1:</strong> <?php echo $answer['choice_ch1']; ?></p>
                                        <p><strong>2:</strong> <?php echo $answer['choice_ch2']; ?></p>
                                        <p><strong>3:</strong> <?php echo $answer['choice_ch3']; ?></p>
                                        <p><strong>4:</strong> <?php echo $answer['choice_ch4']; ?></p>
                                        <p><strong>คำตอบของนักเรียน:</strong> <?php echo $answer['chosen_answer']; ?></p>
                                        <p><strong>คำแนะนำ:</strong> <?php echo $answer['description']; ?></p>
                                        <hr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>นักเรียนยังไม่ได้ทำแบบทดสอบนี้</p>
                    <?php endif; ?>
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
