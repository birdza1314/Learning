<?php
session_start();
include('../connections/connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php'); 
    exit();
}
try {
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
if (!isset($_GET['quiz_id'])) {
    header('Location: index.php');
    exit();
}

$quiz_id = $_GET['quiz_id'];

try {
    $stmt = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $timeLimit = $quiz['time_limit'] * 60;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
            <div class="card-title">
                <h1><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                <p  style="text-align: end;"><span id="timeRemaining"><i class="bi bi-hourglass-split"></i></span></p>
            </div>
            <p><strong>รายละเอียด :</strong> <?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
            <p><strong>จํากัดเวลา :</strong> <?php echo htmlspecialchars($quiz['time_limit']); ?> นาที</p>
            <p><strong>แบบทดสอบทั้งหมด :</strong> <?php echo htmlspecialchars($quiz['question_limit']); ?> ข้อ</p>
            

            <form id="quizForm" action="submit_quiz.php" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">
            <?php $i = 1; foreach ($questions as $question): ?>
            <div class="question">
                <h4><?php echo $i++; ?>.) <?php echo htmlspecialchars($question['question_text']); ?></h4>
                <ul class="choices">
                    <li><input type="radio" id="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch1" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch1']); ?>"><label for="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch1"> 1. <?php echo htmlspecialchars($question['choice_ch1']); ?></label></li>
                    <li><input type="radio" id="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch2" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch2']); ?>"><label for="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch2"> 2. <?php echo htmlspecialchars($question['choice_ch2']); ?></label></li>
                    <li><input type="radio" id="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch3" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch3']); ?>"><label for="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch3"> 3. <?php echo htmlspecialchars($question['choice_ch3']); ?></label></li>
                    <li><input type="radio" id="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch4" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch4']); ?>"><label for="question_<?php echo htmlspecialchars($question['question_id']); ?>_ch4"> 4. <?php echo htmlspecialchars($question['choice_ch4']); ?></label></li>
                </ul>
            </div>
        <?php endforeach; ?>

            <button type="submit" class="btn btn-primary">สงแบบทดสอบ</button>
        </form>

        </div>
    </div>
</main>

<?php include('footer.php');?>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>
<script>
    window.onload = function() {
        var quizId = <?php echo htmlspecialchars($quiz_id); ?>;
        var s_id = <?php echo htmlspecialchars($student['s_id']); ?>;
        var lastTimeKey = 'timeRemaining_' + quizId + '_' + s_id;
        var startTimeKey = 'startTime_' + quizId + '_' + s_id;

        var lastTime = localStorage.getItem(lastTimeKey);
        var startTime = localStorage.getItem(startTimeKey);

        var timeLimit = <?php echo htmlspecialchars($timeLimit); ?>;

        if (!startTime) {
            startTime = Date.now(); // เก็บเวลาเริ่มต้น
            localStorage.setItem(startTimeKey, startTime);
        }

        var elapsedTime = Math.floor((Date.now() - parseInt(startTime)) / 1000);
        var timeRemaining = timeLimit - elapsedTime;

        var timer = setInterval(function() {
            var minutes = Math.floor(timeRemaining / 60);
            var seconds = timeRemaining % 60;

            var displayMinutes = (minutes < 10) ? "0" + minutes : minutes;
            var displaySeconds = (seconds < 10) ? "0" + seconds : seconds;

            document.getElementById('timeRemaining').innerHTML = displayMinutes + "m " + displaySeconds + "s ";
            timeRemaining--;

            if (timeRemaining < 0) {
                clearInterval(timer);
                document.getElementById('timeRemaining').innerHTML = "Time's up!";
                alert('Time is up! Automatically submitting quiz...');
                window.location.href = "submit_quiz.php";
                document.getElementById('quizForm').submit();
            }
        }, 1000);

        // เมื่อผู้ใช้ออกหรือปิดหน้าเว็บ
        window.onbeforeunload = function() {
            localStorage.setItem(lastTimeKey, timeRemaining);
        };
    };
</script>





</body>
</html>
