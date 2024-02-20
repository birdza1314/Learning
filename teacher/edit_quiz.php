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
    echo "<script>window.location.href = 'list_quiz.php?error=Quiz ID not provided';</script>";
}
?>

<!-- HTML Form to Edit Quiz -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Edit Quiz</h2>
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
                <button type="submit" class="btn btn-primary">Update Quiz</button>
            </form>
        </div>
    </div>
</div>
