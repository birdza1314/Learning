<?php
session_start();
include('../connections/connection.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php'); // ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหากไม่ได้ล็อกอิน
    exit();
}

// ดึงข้อมูลของนักเรียน
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// ดึงรายวิชาที่นักเรียนลงทะเบียน
$stmt = $db->prepare("SELECT * FROM courses 
                      WHERE c_id IN (SELECT course_id FROM student_course_registration WHERE student_id = :user_id)");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
     include('head.php');
?>
<body>
<?php
     include('header.php');
     include('sidebar.php');
?>
    <main id="main" class="main">
        <div class="container mt-5">
            <h2>วิชาเรียนของฉัน</h2>
            <div class="row mt-3">
                <?php if ($courses): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                                    <p class="card-text">Course ID: <?php echo $course['course_code']; ?></p>
                                    <?php 
                                        // ดึงบทเรียนทั้งหมดในรายวิชานี้
                                        $stmt = $db->prepare("SELECT COUNT(*) as total_lessons FROM lessons WHERE course_id = :course_id");
                                        $stmt->bindParam(':course_id', $course['c_id']);
                                        $stmt->execute();
                                        $total_lessons = $stmt->fetch(PDO::FETCH_ASSOC)['total_lessons'];

                                        // ดึงบทเรียนที่เสร็จสิ้นแล้วในรายวิชานี้
                                        $stmt = $db->prepare("SELECT COUNT(*) as completed_lessons FROM marks_as_done WHERE course_id = :course_id AND student_id = :student_id");
                                        $stmt->bindParam(':course_id', $course['c_id']);
                                        $stmt->bindParam(':student_id', $user_id);
                                        $stmt->execute();
                                        $completed_lessons = $stmt->fetch(PDO::FETCH_ASSOC)['completed_lessons'];

                                        // คำนวณเปอร์เซ็นต์ของบทเรียนที่เสร็จสิ้น
                                        if ($total_lessons > 0) {
                                            $completion_percentage = ($completed_lessons / $total_lessons) * 100;
                                            // ตัดทศนิยมออกถ้ามีเศษ
                                            $completion_percentage = round($completion_percentage);
                                        } else {
                                            $completion_percentage = 0;
                                        }
                                    ?>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $completion_percentage; ?>%" aria-valuenow="<?php echo $completion_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $completion_percentage; ?>% complete</div>
                                    </div>
                                    <a href="course_details.php?course_id=<?php echo $course['c_id']; ?>" class="btn btn-primary mt-1">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col">
                        <p>No courses found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php include('footer.php');?>
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>
<script>

$(document).ready(function() {
  $("#search").keyup(function() {
      let searchText = $(this).val();
      if (searchText != "") {
          $.ajax({
              url: "action.php",
              method: "post",
              data: {
                  query: searchText
              },
              success: function(response) {
                  $("#show-list").html(response);
              }
          })
      } else {
          $("#show-list").html("");
      }
  })

  $(document).on('click', 'a', function() {
      $("#search").val($(this).text())
      $("#show-list").html("");
  })
})
</script>
 
</body>
</html>
