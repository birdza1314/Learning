<?php
    // Include database connection
    include('../connections/connection.php');

    // Check if quiz_id is set in the URL
    if(isset($_GET['quiz_id'])) {
        // Retrieve quiz_id from the URL
        $quiz_id = $_GET['quiz_id'];
        
        // Prepare SQL statement to select quiz data based on quiz_id
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quiz_id);
        try {
    // Query to retrieve question count from the questions table
    $stmt_question_count = $db->prepare("SELECT COUNT(*) AS question_count FROM questions WHERE quiz_id = :quiz_id");
    $stmt_question_count->bindParam(':quiz_id', $quiz_id);
    $stmt_question_count->execute();
    $question_count_result = $stmt_question_count->fetch(PDO::FETCH_ASSOC);
    $question_count = $question_count_result['question_count'];

    // Query to retrieve question_limit from the quizzes table
    $stmt_question_limit = $db->prepare("SELECT question_limit FROM quizzes WHERE quiz_id = :quiz_id");
    $stmt_question_limit->bindParam(':quiz_id', $quiz_id);
    $stmt_question_limit->execute();
    $question_limit_result = $stmt_question_limit->fetch(PDO::FETCH_ASSOC);
    $question_limit = $question_limit_result['question_limit'];

    // Check if the question count is equal to or less than the question limit
    $show_button = ($question_count < $question_limit);
} catch (PDOException $e) {
    // Handle database errors
    echo "Database Error: " . $e->getMessage();
}
        try {
            // Execute the SQL statement
            $stmt->execute();
            
            // Fetch quiz data
            $quiz = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If an error occurs, display the error message
            echo "Error: " . $e->getMessage();
        }
    } else {
        // If quiz_id is not set in the URL, redirect back to the page with an error message
        echo "<script>window.location.href = 'add_lessons?error=Quiz ID not provided';</script>";
    }
?>
<?php include('session.php'); ?>
<!-- ======= Head ======= -->
<?php include('head.php'); ?>
<!-- ======= Head ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php'); ?>

  <main id="main" class="main">
        <div class="card overflow-auto">
            <div class="card-body">
                <div class="card-header">
                    <h2>เพิ่มคำถาม</h2>
                    <form action="save_question.php" method="post">
                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                        <div class="form-group">
                            <label for="questionText">คำถาม</label>
                            <textarea class="form-control" id="questionText" name="questionText" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="choice1">ตัวเลือก 1<span style="color: red;">*</span></label>
                            <input type="text" class="form-control choice-input" id="choice1" name="choice1" required>
                        </div>
                        <div class="form-group">
                            <label for="choice2">ตัวเลือก 2<span style="color: red;">*</span></label>
                            <input type="text" class="form-control choice-input" id="choice2" name="choice2" required>
                        </div>
                        <div class="form-group">
                            <label for="choice3">ตัวเลือก 3<span style="color: red;">*</span></label>
                            <input type="text" class="form-control choice-input" id="choice3" name="choice3" required>
                        </div>
                        <div class="form-group">
                            <label for="choice4">ตัวเลือก 4<span style="color: red;">*</span></label>
                            <input type="text" class="form-control choice-input" id="choice4" name="choice4" required>
                        </div>
                        <div class="form-group">
                            <label for="correctAnswerSelect">คำตอบที่ถูกต้อง (ตัวเลือก)<span style="color: red;">*</span></label>
                            <select class="form-control" id="correctAnswerSelect" name="correctAnswerSelect" onchange="updateCorrectAnswer(this)" required>
                                <option selected>เลือกตัวเลือก</option>
                                <option value="choice1">ตัวเลือก 1</option>
                                <option value="choice2">ตัวเลือก 2</option>
                                <option value="choice3">ตัวเลือก 3</option>
                                <option value="choice4">ตัวเลือก 4</option>
                            </select>
                            <input type="hidden" id="correctAnswer" name="correctAnswer" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="choice4">คำแนะนำ<span style="color: red;">*</span></label>
                            <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">ส่งคำตอบ</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
  <!-- ======= Footer ======= -->
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
  <?php include('scripts.php');?>
  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
        function updateCorrectAnswer(selectElement) {
            var selectedChoice = selectElement.value;
            var choiceInputElement = document.querySelector('.choice-input[name="' + selectedChoice + '"]');
            var choiceValue = choiceInputElement.value;
            document.getElementById('correctAnswer').value = choiceValue;
        }
    </script>
</body>
</html>

