<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login'); 
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
    header('Location: index');
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
        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h1 class="display-6 ">ผลการสอบ</h1>
                    </div>
                    <?php if(!empty($results)): ?>
                      
                        <?php foreach ($results as $result): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                     
                                    <h3 class="card-title mb-2 ">หัวข้อ: <?php echo $result['quiz_title']; ?></h3>
                                    <p class="card-text">คะแนนที่ได้: <span class="fw-bold <?php echo ($result['score'] < $result['question_limit'] / 2) ? 'text-danger' : 'text-success'; ?>"><?php echo $result['score']; ?></span></p>
                                    <p class="card-text">คะแนนเต็ม: <?php echo $result['question_limit']; ?></p>
                                    <p class="card-text">ส่งเมื่อ: <?php echo $result['timestamp']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!empty($student_answers)): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title">คำถามที่ตอบผิด</h2>
                                    <?php foreach ($student_answers as $answer): ?>
                                        <?php if ($answer['chosen_answer'] !== $answer['correct_answer']): ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h3 class="card-title text-danger">คำแนะนำ: <?php echo $answer['description']; ?></h3>
                                                    <h4 class="card-subtitle mb-2 text-muted">คำถาม: <?php echo $answer['question_text']; ?></h4>
                                                    <p class="card-text">คำตอบของนักเรียน: <?php echo $answer['chosen_answer']; ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">นักเรียนยังไม่ได้ทำแบบทดสอบนี้</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted">ไม่พบผลการสอบ</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include('footer.php');?>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <?php include('scripts.php');?>
</body>
</html>
