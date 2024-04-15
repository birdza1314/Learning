<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: ../login'); 
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
// Function to get assignments from the database
function getAssignments() {
  include('../connections/connection.php');
  try {
    // Get the user ID of the logged-in student
    $student_id = $_SESSION['user_id'];

    // Retrieve the courses that the student is registered for and is open
    $stmt_courses = $db->prepare("SELECT course_id 
                                  FROM student_course_registration 
                                  WHERE student_id = :student_id");
    $stmt_courses->bindParam(':student_id', $student_id);
    $stmt_courses->execute();
    $registered_courses = $stmt_courses->fetchAll(PDO::FETCH_COLUMN);

    // If the student is not registered for any courses, return an empty array
    if (empty($registered_courses)) {
      return [];
    }

    // Prepare and execute the SQL query to fetch assignments for the registered courses
    $stmt = $db->prepare("SELECT a.assignment_id, a.title, a.open_time, a.close_time, a.description 
                          FROM assignments a 
                          INNER JOIN courses c ON a.course_id = c.c_id 
                          WHERE a.course_id IN (".implode(',', $registered_courses).") AND c.is_open = 1");
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

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรกนักเรียน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- เชื่อมต่อกับไฟล์ JavaScript ของ FullCalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!-- เชื่อมต่อกับไฟล์ CSS ของ FullCalendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
</head>
</head>
<body>

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

    <script>
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        locale: 'th', // กำหนด locale เป็น 'th' เพื่อแสดงภาษาไทย
        events: [
            <?php foreach ($assignments as $assignment): ?>
                {
                    title: '<?php echo $assignment['title']; ?>',
                    start: '<?php echo $assignment['open_time']; ?>',
                    end: '<?php echo $assignment['close_time']; ?>',
                    url: 'submit_assignment.php?assignment_id=<?php echo $assignment['assignment_id']; ?>'
                },
            <?php endforeach; ?>
        ]
    });

    $('#calendar').on('mouseenter', '.fc-event', function() {
        var title = $(this).find('.fc-title').text();
        var start = $(this).find('.fc-time').text();
        var end = $(this).find('.fc-time').next().text();
        var content = '<b>' + title + '</b><br>เริ่ม: ' + start + '<br>ปิด: ' + end;

        $(this).tooltip({
            title: content,
            placement: 'auto',
            html: true,
            trigger: 'hover'
        });
    });
});

    </script>
</body>
</html>
