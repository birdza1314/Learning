<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ส่งไปยังหน้าเข้าสู่ระบบหรือหน้าอื่น ๆ หากผู้ใช้ไม่ได้เข้าสู่ระบบหรือไม่มีบทบาทที่ถูกต้อง
    header('Location: ../login'); 
    exit();
}
try {
    // Execute SQL statement to retrieve user data
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Display error if any
    echo "Error: " . $e->getMessage();
}
// รับค่า course_id จากตาราง assignments
if(isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];

    // เตรียมและดำเนินการ SQL statement เพื่อดึงข้อมูล course_id
    $stmt = $db->prepare("SELECT course_id FROM assignments WHERE assignment_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();
    $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
    $course_id = $assignment['course_id'];

    // เตรียมและดำเนินการ SQL statement เพื่อดึงข้อมูลการลงทะเบียนนักเรียนสำหรับวิชาที่ระบุ
    $stmt = $db->prepare("SELECT scr.*, s.first_name, s.last_name, sa.status, sa.submitted_datetime, a.close_time,username
                          FROM student_course_registration scr
                          LEFT JOIN students s ON scr.student_id = s.s_id 
                          LEFT JOIN submitted_assignments sa ON scr.student_id = sa.student_id
                          LEFT JOIN assignments a ON sa.assignment_id = a.assignment_id
                          WHERE scr.course_id = :course_id
                          ORDER BY username ASC, scr.registration_date DESC");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "ไม่ได้ระบุ Assignment ID ใน URL";
}
?>


<!-- ส่วนหัว -->
<?php include('head.php'); ?>
<!-- ส่วนหัว -->
<body>

  <!-- ส่วนหัวเว็บ -->
  <?php include('header.php'); ?>

  <!-- แถบเมนูด้านข้าง -->
  <?php include('sidebar.php'); ?>

  <!-- เนื้อหาหลัก -->
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card overflow-auto">
            <div class="card-body">
              <div class="card-header d-flex">
                <h4 class="mt-2">ตรวจสอบนักเรียนและงานที่กำหนด</h4>
              </div>
              <div class="mt-5">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                    <th>รหัสนักเรียน</th>
                      <th>ชื่อนักเรียน</th>
                      <th>วันที่ส่ง</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    foreach($registrations as $registration):
                      
                    ?>
                    <tr>
                    <td><?= $registration['username'] ?> </td>
                        <td><?= $registration['first_name'] ?> <?= $registration['last_name'] ?></td>
                        <td>
                            <?php
                            if (!empty($registration['submitted_datetime'])) {
                                // ตรวจสอบว่างานถูกส่งก่อนหรือหลังกำหนด
                                $submitted_datetime = strtotime($registration['submitted_datetime']);
                                $close_time = strtotime($registration['close_time']);
                                if ($submitted_datetime < $close_time) {
                                    // ถ้าส่งก่อนกำหนด แสดงสีเขียว
                                    echo '<span class="submitted">' . $registration['submitted_datetime'] . '</span>';
                                } else {
                                    // ถ้าส่งหลังกำหนด แสดงสีเหลือง
                                    echo '<span class="late-submission">' . $registration['submitted_datetime'] . '</span>';
                                }
                            } else {
                                echo '<span class="not-submitted">ยังไม่ได้ส่ง</span>';

                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($registration['status']=='ตรวจแล้ว')) {
                                echo '<span class="submitted">' . $registration['status']. '</span>';
                            } else {
                                echo '<span class="not-submitted">ยังไม่ตรวจ</span>';

                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- ส่วนท้าย -->
  <?php include('footer.php');?>
  <?php include('scripts.php');?>

</body>
</html>
