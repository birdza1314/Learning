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
        echo "<script>window.location.href = 'add_lessons.php?error=Quiz ID not provided';</script>";
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
<!-- HTML Form to Edit Quiz -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quiz Information</h2>
                </div>
                <div class="card-body">
                    <form action="update_quiz.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                        <div class="form-group">
                            <label>Quiz Title</label>
                            <input type="text" name="Quiz_Title" class="form-control" value="<?php echo $quiz['quiz_title']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Quiz Description</label>
                            <textarea name="QuizDesc" class="form-control" rows="4"><?php echo $quiz['quiz_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="timeLimit">Quiz Time Limit (Minutes)</label>
                            <input type="number" class="form-control" id="timeLimit" name="timeLimit" min="1" max="120" value="<?php echo $quiz['time_limit']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Question Limit to Display</label>
                            <input type="number" name="QuestDipLimit" class="form-control" value="<?php echo $quiz['question_limit']; ?>" required>
                        </div>
                        <button type="submit" style="float: right;" class="btn btn-outline-primary">Update Quiz</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php 
            $selQuest = $db->query("SELECT * FROM questions WHERE quiz_id='$quiz_id' ORDER BY question_id ASC");
            ?>
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Quiz Question's 
                    <span class="badge badge-pill badge-primary ml-2">
                        <?php echo ($selQuest ? $selQuest->rowCount() : 0); ?>
                    </span>
                    <div class="btn-actions-pane-right">
                        <button class="btn btn-sm btn-outline-primary" style="float: right;" data-toggle="modal" data-target="#modalForAddQuestion"><i class="bi bi-plus-circle-fill"></i><span> Add Question</span> </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="scroll-area-sm">
                        <div class="scrollbar-container">
                            <?php 
                            if($selQuest && $selQuest->rowCount() > 0)
                            { ?>
                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-1">Course Name</th>
                                                <th class="text-center" width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            while ($selQuestionRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <tr>
                                                    <td>
                                                        <b><?php echo $i++; ?> .) <?php echo $selQuestionRow['question_text']; ?></b><br>
                                                        <?php 
                                                        // Choices
                                                        $choices = ['choice_ch1', 'choice_ch2', 'choice_ch3', 'choice_ch4'];
                                                        foreach ($choices as $choiceKey) {
                                                            $choice = $selQuestionRow[$choiceKey];
                                                            $isCorrect = $selQuestionRow['correct_answer'] == $choice;
                                                        ?>
                                                        <span class="pl-4 <?php echo $isCorrect ? 'text-success' : ''; ?>"><?php echo substr($choiceKey, -1); ?> - <?php echo $choice; ?></span><br>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                         <button type="button" class="btn btn-outline-primary btn-sm" onclick="showUpdateQuestionModal(<?php echo $selQuestionRow['question_id']; ?>, '<?php echo $selQuestionRow['question_text']; ?>', '<?php echo $selQuestionRow['choice_ch1']; ?>', '<?php echo $selQuestionRow['choice_ch2']; ?>', '<?php echo $selQuestionRow['choice_ch3']; ?>', '<?php echo $selQuestionRow['choice_ch4']; ?>', '<?php echo $selQuestionRow['correct_answer']; ?>', '<?php echo $quiz_id; ?>')">
                                                         <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?php echo $selQuestionRow['question_id']; ?>)">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }
                            else
                            { ?>
                                <h4 class="text-primary">No question found...</h4>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('Modal.php');?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
  <?php include('scripts.php');?>

  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>
function showUpdateQuestionModal(question_id, question_text, choice1, choice2, choice3, choice4, correct_answer) {
    var modal = $('#updateQuestionModal');

    // กำหนดค่า question_id ให้กับฟิลด์แบบซ่อน
    modal.find('input[name="question_id"]').val(question_id);

    // กำหนดค่า question_text ให้กับ textarea ของคำถาม
    modal.find('#updatedQuestionText').val(question_text);

    // กำหนดค่า choices
    modal.find('#updatedChoice1').val(choice1);
    modal.find('#updatedChoice2').val(choice2);
    modal.find('#updatedChoice3').val(choice3);
    modal.find('#updatedChoice4').val(choice4);

    // กำหนดค่าของ correct_answer
    var correctAnswerSelect = modal.find('#updatedCorrectAnswer');
    correctAnswerSelect.val(correct_answer);

    // เปิด Modal
    modal.modal('show');
}

</script>




<script>
  function confirmDelete(questionId) {
    if (confirm("คุณแน่ใจหรือไม่ที่จะลบคำถามนี้?")) {
      deleteQuestion(questionId);
    }
  }

  function deleteQuestion(questionId) {
    $.ajax({
      url: 'deleteQuestion.php',
      method: 'POST',
      data: { question_id: questionId },
      success: function(response) {
        // รีเฟรชหน้า
        location.reload();
        // หรือแสดงข้อความว่าลบสำเร็จ
        alert('Deleted successfully');
      },
      error: function(xhr, status, error) {
        // การดำเนินการหลังจากเกิดข้อผิดพลาดในการลบคำถาม
        // เช่น แสดงข้อความแจ้งเตือนหรือบันทึกข้อผิดพลาดไว้ในไฟล์บันทึกข้อผิดพลาด
        alert('An error occurred while deleting');
      }
    });
  }
</script>
  <!-- Add Bootstrap script -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script>
        // Store the current URL in local storage when the page loads
        localStorage.setItem('previousPageUrl', window.location.href);
    </script>
  <?php include('scripts_topic.php');?>
  <?php include('Modal_scripts.php');?>
</body>
</html>