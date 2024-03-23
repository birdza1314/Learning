<?php
// กำหนดภาษาและประเทศให้กับเซิร์ฟเวอร์ PHP เป็นภาษาไทยและประเทศไทย
setlocale(LC_TIME, 'th_TH.utf8');
?>
<?php
include('../connections/connection.php');

// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'student' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'student' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

// ฟังก์ชันในการดึงกิจกรรมจากฐานข้อมูลตามวันที่และวิชาที่ลงทะเบียน
function getAssignmentsByDate($date) {
    // เชื่อมต่อฐานข้อมูล
    include('../connections/connection.php');
    
    // ตรวจสอบว่านักเรียนลงทะเบียนเรียนวิชาไหนบ้าง
    $student_id = $_SESSION['user_id'];
    $stmt_reg = $db->prepare("SELECT course_id FROM student_course_registration WHERE student_id = :student_id");
    $stmt_reg->bindParam(':student_id', $student_id);
    $stmt_reg->execute();
    $registered_courses = $stmt_reg->fetchAll(PDO::FETCH_COLUMN);
    
    // คำสั่ง SQL เลือกกิจกรรมที่มีวันที่ตรงกับวันที่ที่กำหนด และเฉพาะวิชาที่นักเรียนลงทะเบียนไว้
    $stmt = $db->prepare("SELECT assignment_id, title, course_id FROM assignments WHERE DATE(deadline) = :date AND course_id IN (".implode(',', $registered_courses).")");
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    
    // เก็บข้อมูลกิจกรรมที่ได้จากฐานข้อมูล
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $assignments;
}

// ฟังก์ชันในการดึงเวลาส่งงานจากฐานข้อมูล
function getAssignmentDeadline($assignment_id) {
    // เชื่อมต่อฐานข้อมูล
    include('../connections/connection.php');
    
    // คำสั่ง SQL เลือกเวลาส่งงานของกิจกรรม
    $stmt = $db->prepare("SELECT deadline FROM assignments WHERE assignment_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();
    
    // เก็บข้อมูลเวลาส่งงาน
    $deadline = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $deadline['deadline'];
}

// ฟังก์ชันในการดึงสถานะการส่งงานจากฐานข้อมูล
function getSubmissionStatus($assignment_id) {
    // เชื่อมต่อฐานข้อมูล
    include('../connections/connection.php');
    
    // คำสั่ง SQL เลือกสถานะการส่งงานของกิจกรรม
    $stmt = $db->prepare("SELECT status FROM submitted_assignments WHERE assignment_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();
    
    // เก็บข้อมูลสถานะการส่งงาน
    $submission = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // หากไม่พบการส่งงานให้สถานะเป็น 'not-submitted' ถ้าพบให้ใช้สถานะจากฐานข้อมูล
    $status = ($submission) ? $submission['status'] : 'not-submitted';
    
    return $status;
}
// ฟังก์ชันในการดึงชื่อวิชาจากฐานข้อมูล
function getCourseName($course_id) {
    // เชื่อมต่อฐานข้อมูล
    include('../connections/connection.php');

    // คำสั่ง SQL เลือกชื่อวิชาจากรหัสวิชา
    $stmt = $db->prepare("SELECT course_name FROM courses WHERE c_id = :course_id");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    // เก็บข้อมูลชื่อวิชา
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    return $course['course_name'];
}

?>


<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ปฏิทินกิจกรรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .calendar {
        max-width: 900px;
      margin: 0 auto;
      border-collapse: collapse;
    }

    .calendar th,
    .calendar td {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
    }

    .calendar th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .today {
      background-color: #ffffcc;
      font-weight: bold;
    }

    .submitted,
    .not-submitted {
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 5px;
      width: 100%;
    }

    .submitted {
      background-color: #90EE90; /* Green */
    }

    .not-submitted {
      background-color: #FFA07A; /* Red */
    }

    a {
      color: inherit;
      text-decoration: none;
      font-weight: bold;
    }

    .activity-box {
      font-size: 0.9rem;
    }
  </style>

</head>
<body>
  <div class="container">
    <h1 class="text-center mt-5">ปฏิทินกิจกรรม</h1>
  </div>

  <?php
  // กำหนดวันที่ปัจจุบัน
  $today = date("Y-m-d");

  // สร้างปฏิทินขนาด 7x7
  echo "<table class='calendar'>";
  echo "<tr><th>อา.</th><th>จ.</th><th>อ.</th><th>พ.</th><th>พฤ.</th><th>ศ.</th><th>ส.</th></tr>";

  // กำหนดวันแรกของเดือน
  $firstDayOfMonth = date('Y-m-01');

  // หาวันของสัปดาห์ที่ 1
  $firstDayOfWeek = date('w', strtotime($firstDayOfMonth));

  // หาวันสุดท้ายของเดือน
  $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

  // กำหนดวันที่เริ่มต้นและสิ้นสุดของการวนลูป
  $start_date = date('Y-m-d', strtotime("-" . $firstDayOfWeek . " days", strtotime($firstDayOfMonth)));
  $end_date = date('Y-m-d', strtotime("+6 days", strtotime($lastDayOfMonth)));

  // วนลูปเพื่อสร้างช่วงวันที่
  $current_date = $start_date;
  while ($current_date <= $end_date) {
    echo "<tr>";
    for ($i = 0; $i < 7; $i++) {
      echo "<td";
      if ($current_date == $today) {
        echo " class='today'";
      }
      echo ">";
      echo strftime("%e", strtotime($current_date)) . "<br>";

      // เรียกดูกิจกรรมที่เกี่ยวข้องกับวันนี้จากฐานข้อมูล
      $assignments = getAssignmentsByDate($current_date); // ฟังก์ชันเรียกข้อมูลจากฐานข้อมูล
      if ($assignments) {
        foreach ($assignments as $assignment) {
          $status = getSubmissionStatus($assignment['assignment_id']); // ฟังก์ชันเรียกข้อมูลสถานะการส่งงาน
          if ($status) {
            $color_class = ($status == 'ตรวจแล้ว') ? 'submitted' : 'not-submitted';
            $deadline = getAssignmentDeadline($assignment['assignment_id']); // เรียกดูเวลาส่งงาน
            $course_id = isset($assignment['course_id']) ? $assignment['course_id'] : null; // รหัสวิชาที่เกี่ยวข้องกับงาน
            $course_name = getCourseName($course_id); // เรียกดูชื่อวิชา
            echo "<span class='$color_class'>- <a href='course_details.php?course_id=$course_id'>" . $assignment['title'] . "</a> (กำหนดส่งเวลา $deadline)</span><br>";
          }
        }
      } else {
        // กรณีไม่มีกิจกรรมในวันที่นั้น
      }

      echo "</td>";
      $current_date = date('Y-m-d', strtotime("+1 day", strtotime($current_date)));
    }
    echo "</tr>";
  }
  echo "</table>";
  ?>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
