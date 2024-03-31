<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login.php'); 
    exit();
}

try {
  // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
  $user_id = $_SESSION['user_id'];
  $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  
  // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
  $student = $stmt->fetch(PDO::FETCH_ASSOC);
  
} catch (PDOException $e) {
  // แสดงข้อผิดพลาด
  echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
// Function to get assignments from the database
function getAssignments() {
  include('../connections/connection.php');
  try {
    // Get the user ID of the logged-in student
    $student_id = $_SESSION['user_id'];

    // Retrieve the courses that the student is registered for
    $stmt_courses = $db->prepare("SELECT course_id FROM student_course_registration WHERE student_id = :student_id");
    $stmt_courses->bindParam(':student_id', $student_id);
    $stmt_courses->execute();
    $registered_courses = $stmt_courses->fetchAll(PDO::FETCH_COLUMN);

    // If the student is not registered for any courses, return an empty array
    if (empty($registered_courses)) {
      return [];
    }

    // Prepare and execute the SQL query to fetch assignments for the registered courses
    $stmt = $db->prepare("SELECT assignment_id, title, open_time, close_time, description FROM assignments WHERE course_id IN (".implode(',', $registered_courses).")");
    $stmt->execute();
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $assignments;
  } catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
  }
}

// Function to check if submission exists for an assignment
function isSubmissionExists($assignment_id) {
  include('../connections/connection.php');
  try {
    $stmt = $db->prepare("SELECT COUNT(*) FROM submitted_assignments WHERE assignment_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  } catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
  }
}

// Get assignments from the database
$assignments = getAssignments();

?>
<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <main id="main" class="main">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h3 style="text-align: center;">ปฏิทินกิจกรรม</h3>
        </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 ">
        <div id="calendar" class="row"></div>
      </div>
    </div>
  </div>
  </div>
    </div>
  </div>
</main>
<?php include('footer.php'); ?>
<?php include('scripts.php'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'th',
      initialView: 'dayGridMonth',
      events: [
        <?php foreach ($assignments as $assignment): ?>
        {
          title: '<?php echo $assignment['title']; ?>',
          start: '<?php echo $assignment['open_time']; ?>',
          description: '<?php echo $assignment['description']; ?>',
          end: '<?php echo $assignment['close_time']; ?>' // เพิ่ม end โดยให้มีค่าเท่ากับ close_time
        },
        <?php endforeach; ?>
      ],
      eventDidMount: function(info) {
        var tooltip = new bootstrap.Popover(info.el, {
          title: info.event.title,
          content: '<strong>วันเวลาปิดส่งงาน:</strong> ' + info.event.end.toLocaleString('th-TH', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true }),
          trigger: 'hover',
          placement: 'auto',
          html: true // เปิดใช้งาน HTML
        });
      }
    });
    calendar.render();
  });
</script>


</body>
</html>
