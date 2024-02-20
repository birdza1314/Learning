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
                            <label>Quiz Time Limit</label>
                            <select class="form-control" name="timeLimit" required>
                                <option value="10" <?php if($quiz['time_limit'] == 10) echo "selected"; ?>>10 Minutes</option>
                                <option value="20" <?php if($quiz['time_limit'] == 20) echo "selected"; ?>>20 Minutes</option>
                                <option value="30" <?php if($quiz['time_limit'] == 30) echo "selected"; ?>>30 Minutes</option>
                                <option value="40" <?php if($quiz['time_limit'] == 40) echo "selected"; ?>>40 Minutes</option>
                                <option value="50" <?php if($quiz['time_limit'] == 50) echo "selected"; ?>>50 Minutes</option>
                                <option value="60" <?php if($quiz['time_limit'] == 60) echo "selected"; ?>>60 Minutes</option>
                            </select>
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
            $selQuest = $db->query("SELECT * FROM questions WHERE quiz_id='$quiz_id' ORDER BY question_id DESC");
            ?>
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Exam Question's 
                    <span class="badge badge-pill badge-primary ml-2">
                        <?php echo ($selQuest ? $selQuest->rowCount() : 0); ?>
                    </span>
                    <div class="btn-actions-pane-right">
                        <button class="btn btn-sm btn-outline-primary" style="float: right;" data-toggle="modal" data-target="#modalForAddQuestion">Add Question</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="scroll-area-sm" style="min-height: 400px;">
                        <div class="scrollbar-container">
                            <?php 
                            if($selQuest->rowCount() > 0)
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
                                                if($selQuest->rowCount() > 0){ 
                                                    $i = 1;
                                                    while ($selQuestionRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $i++; ?> .) <?php echo $selQuestionRow['question_text']; ?></b><br>
                                                            <?php 
                                                            // Choice A
                                                            $choiceA = $selQuestionRow['choice_ch1'];
                                                            $isCorrectA = $selQuestionRow['choice_ch1'] == $selQuestionRow['correct_answer'];
                                                            ?>
                                                            <span class="pl-4 <?php echo $isCorrectA ? 'text-success' : ''; ?>">A - <?php echo $choiceA; ?></span><br>

                                                            <?php 
                                                            // Choice B
                                                            $choiceB = $selQuestionRow['choice_ch2'];
                                                            $isCorrectB = $selQuestionRow['choice_ch2'] == $selQuestionRow['correct_answer'];
                                                            ?>
                                                            <span class="pl-4 <?php echo $isCorrectB ? 'text-success' : ''; ?>">B - <?php echo $choiceB; ?></span><br>

                                                            <?php 
                                                            // Choice C
                                                            $choiceC = $selQuestionRow['choice_ch3'];
                                                            $isCorrectC = $selQuestionRow['choice_ch3'] == $selQuestionRow['correct_answer'];
                                                            ?>
                                                            <span class="pl-4 <?php echo $isCorrectC ? 'text-success' : ''; ?>">C - <?php echo $choiceC; ?></span><br>

                                                            <?php 
                                                            // Choice D
                                                            $choiceD = $selQuestionRow['choice_ch4'];
                                                            $isCorrectD = $selQuestionRow['choice_ch4'] == $selQuestionRow['correct_answer'];
                                                            ?>
                                                            <span class="pl-4 <?php echo $isCorrectD ? 'text-success' : ''; ?>">D - <?php echo $choiceD; ?></span><br>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="updateQuestion.php?id=<?php echo $selQuestionRow['quiz_id']; ?>" class="btn btn-sm btn-outline-primary">Update</a>
                                                            <button type="button" id="deleteQuestion" data-id='<?php echo $selQuestionRow['quiz_id']; ?>' class="btn btn-outline-danger btn-sm">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <?php }
                                                    }
                                                else
                                                {
                                            ?>
                                            <tr>
                                            <td colspan="2">
                                            <h3 class="p-3">No Course Found</h3>
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
                                 <?php
                               }
                             ?>
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
  <!-- Add Bootstrap script -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <?php include('scripts_topic.php');?>
  <?php include('Modal_scripts.php');?>
</body>
</html>