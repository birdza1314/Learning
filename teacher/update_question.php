<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// ตรวจสอบว่ามีการส่งค่า question_id มาหรือไม่
if (!isset($_GET['question_id'])) {
    echo "Question ID not provided.";
    exit;
}

// รับค่า question_id ที่ส่งมาจากหน้ารายการคำถาม
$question_id = $_GET['question_id'];

// ตรวจสอบว่ามีการ submit ฟอร์มหรือไม่
if (isset($_POST['submit'])) {
    // ดึงข้อมูลจากฟอร์ม
    $question_text = $_POST['question_text'];
    $choice_ch1 = $_POST['choice_ch1'];
    $choice_ch2 = $_POST['choice_ch2'];
    $choice_ch3 = $_POST['choice_ch3'];
    $choice_ch4 = $_POST['choice_ch4'];
    $correct_answer = $_POST['correct_answer'];
    $description = $_POST['description'];

    // เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
    $sql = "UPDATE questions SET question_text = :question_text, choice_ch1 = :choice_ch1, choice_ch2 = :choice_ch2, choice_ch3 = :choice_ch3, choice_ch4 = :choice_ch4, correct_answer = :correct_answer, description = :description WHERE question_id = :question_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':question_text', $question_text);
    $stmt->bindParam(':choice_ch1', $choice_ch1);
    $stmt->bindParam(':choice_ch2', $choice_ch2);
    $stmt->bindParam(':choice_ch3', $choice_ch3);
    $stmt->bindParam(':choice_ch4', $choice_ch4);
    $stmt->bindParam(':correct_answer', $correct_answer);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':question_id', $question_id);

    // ทำการ execute คำสั่ง SQL
    if ($stmt->execute()) {
        echo "<script>alert('Question updated successfully');</script>";
        echo "<script>window.history.back(-2);</script>";
    } else {
        echo "Failed to update question: " . $stmt->errorInfo()[2];
    }
}

// ดึงข้อมูลคำถามที่ต้องการแก้ไขจากฐานข้อมูล
$sql = "SELECT * FROM questions WHERE question_id = :question_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':question_id', $question_id);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่ามีข้อมูลคำถามหรือไม่
if (!$question) {
    echo "Question not found.";
    exit;
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
    <h2>แก้ไขแบบทดสอบ</h2>
    <form method="post">
    <div class="form-group">
        <label for="question_text">คำถาม:</label>
        <input type="text" id="question_text" name="question_text" value="<?php echo $question['question_text']; ?>">
    </div>
    <div class="form-group">
        <label for="choice_ch1">ตัวเลือก 1:</label>
        <input type="text" id="choice_ch1" name="choice_ch1" value="<?php echo $question['choice_ch1']; ?>">
    </div>
    <div class="form-group">
        <label for="choice_ch2">ตัวเลือก 2:</label>
        <input type="text" id="choice_ch2" name="choice_ch2" value="<?php echo $question['choice_ch2']; ?>">
    </div>
    <div class="form-group">
        <label for="choice_ch3">ตัวเลือก 3:</label>
        <input type="text" id="choice_ch3" name="choice_ch3" value="<?php echo $question['choice_ch3']; ?>">
    </div>
    <div class="form-group">
        <label for="choice_ch4">ตัวเลือก 4:</label>
        <input type="text" id="choice_ch4" name="choice_ch4" value="<?php echo $question['choice_ch4']; ?>">
    </div>
    <div class="form-group">
        <label for="correct_answer">คำตอบที่ถูกต้อง (ตัวเลือก)</label>
        <select id="correct_answer" name="correct_answer">
        <option value="<?php echo $question['choice_ch1']; ?>">ตัวเลือก 1</option>
        <option value="<?php echo $question['choice_ch2']; ?>">ตัวเลือก 2</option>
        <option value="<?php echo $question['choice_ch3']; ?>">ตัวเลือก 3</option>
        <option value="<?php echo $question['choice_ch4']; ?>">ตัวเลือก 4</option>
    </select>

    </div>
    <div class="form-group">
        <label for="description">รายละเอียด</label>
        <textarea class="form-control" id="description" name="description"><?php echo $question['description']; ?></textarea>
    </div>
    <input type="submit" name="submit" value="Update">
</form>

</main>
  <!-- ======= Footer ======= -->
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
  <?php include('scripts.php');?>
  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>

