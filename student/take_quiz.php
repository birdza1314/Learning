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
            </div>
            <p><strong>รายละเอียด :</strong> <?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
            <p><strong>จํากัดเวลา :</strong> <?php echo htmlspecialchars($quiz['time_limit']); ?></p>
            <p><strong>แบบทดสอบทั้งหมด :</strong> <?php echo htmlspecialchars($quiz['question_limit']); ?></p>
            <p><strong>เวลาคงเหลือ :</strong> <span id="timeRemaining"></span></p>

            <form id="quizForm" action="submit_quiz.php" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">
            <?php $i = 1; foreach ($questions as $question): ?>
                <div class="question">
                    <h4><?php echo $i++; ?>.) <?php echo htmlspecialchars($question['question_text']); ?></h4>
                    <ul class="choices">
                        <li><input type="radio" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch1']); ?>"> A. <?php echo htmlspecialchars($question['choice_ch1']); ?></li>
                        <li><input type="radio" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch2']); ?>"> B. <?php echo htmlspecialchars($question['choice_ch2']); ?></li>
                        <li><input type="radio" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch3']); ?>"> C. <?php echo htmlspecialchars($question['choice_ch3']); ?></li>
                        <li><input type="radio" name="question_<?php echo htmlspecialchars($question['question_id']); ?>" value="<?php echo htmlspecialchars($question['choice_ch4']); ?>"> D. <?php echo htmlspecialchars($question['choice_ch4']); ?></li>
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
  var lastTime = localStorage.getItem(lastTimeKey);

  if (lastTime) {
    timeRemaining = parseInt(lastTime);
  } else {
    timeRemaining = <?php echo htmlspecialchars($timeLimit); ?>;
  }

  var timer = setInterval(function() {
    var minutes = Math.floor(timeRemaining / 60);
    var seconds = timeRemaining % 60;
    document.getElementById('timeRemaining').innerHTML = minutes + "m " + seconds + "s ";
    timeRemaining--;
    localStorage.setItem(lastTimeKey, timeRemaining);

    if (timeRemaining < 0) {
      clearInterval(timer);
      document.getElementById('timeRemaining').innerHTML = "Time's up!";

      alert('Time is up! Automatically submitting quiz...');
      window.location.href = "submit_quiz.php";
        document.getElementById('quizForm').submit();
    }
  }, 1000);
};

</script>

</body>
</html>
