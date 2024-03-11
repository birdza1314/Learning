<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือไม่ใช่บทบาท 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
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

    // เรียกข้อมูลคำถามจากฐานข้อมูล
    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    exit();
}
?>

<!-- แสดงแบบทดสอบ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $quiz['title']; ?></title>
</head>
<body>
    <h1><?php echo $quiz['title']; ?></h1>
    <form action="submit_quiz.php" method="post">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <?php foreach ($questions as $question): ?>
            <div>
                <p><?php echo $question['question_text']; ?></p>
                <?php foreach (json_decode($question['options'], true) as $option): ?>
                    <label>
                        <input type="radio" name="answers[<?php echo $question['question_id']; ?>]" value="<?php echo $option; ?>">
                        <?php echo $option; ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
