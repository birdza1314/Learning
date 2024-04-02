<?php
include('../connections/connection.php');

// ตรวจสอบว่ามี Lesson ID และ Course ID ที่ถูกส่งมาหรือไม่
if (!isset($_GET['lesson_id']) || !isset($_GET['course_id'])) {
    echo "Lesson ID or Course ID not provided.";
    exit; // หยุดการทำงานของสคริปต์เพื่อป้องกันการดำเนินการต่อ
}

// ดึงข้อมูล Lesson จาก URL
$lesson_id = $_GET['lesson_id'];
$course_id = $_GET['course_id'];
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
             <h2 class="fw-bold mb-0">เพิ่ม Assignment</h2>
        </div>
        <div class="card-body">
             <form action="save_assignment.php?lesson_id=<?php echo $lesson_id; ?>&course_id=<?php echo $course_id; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

                <div class="mb-3 mt-3">
                    <label for="title" class="form-label">หัวข้อ Assignment:<span class="text-danger">*</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">รายละเอียด Assignment:</label>
                    <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="file_path" class="form-label">ไฟล์ Assignment:</label>
                    <input type="file" class="form-control" name="file_path" id="file_path">
                </div>
                <div class="card">
                    <div class="card-header">
                            <h5 class="card-title">Availability<span class="text-danger">*</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-lg-4 col-md-6">
                                <label for="open_time" class="form-label">เปิด Assignment เมื่อ:</label>
                                <input type="datetime-local" class="form-control" name="open_time" id="open_time" required>
                            </div>
                            <div class="mb-3 col-lg-4 col-md-6">
                                <label for="deadline" class="form-label">กำหนดส่ง Assignment (Due date):</label>
                                <input type="datetime-local" class="form-control" name="deadline" id="deadline" required>
                            </div>
                            <div class="mb-3 col-lg-4 col-md-6">
                                <label for="close_time" class="form-label">ปิด Assignment เมื่อ:</label>
                                <input type="datetime-local" class="form-control" name="close_time" id="close_time" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-6 col-lg-4">
                    <label for="status" class="form-label">สถานะ:</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="open">เปิด</option>
                        <option value="closed">ปิด</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-outline-primary">เพิ่ม Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

           
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