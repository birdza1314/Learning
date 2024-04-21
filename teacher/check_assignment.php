<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // Redirect to login page or any other page if user is not logged in or doesn't have the correct role
    header('Location: ../login'); 
    exit();
}


// Check if assignment_id is set
if(isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];

    // Prepare and execute SQL statement to retrieve assignment data
    $stmt = $db->prepare("SELECT sa.*, a.close_time 
                          FROM submitted_assignments sa
                          JOIN assignments a ON sa.assignment_id = a.assignment_id
                          WHERE sa.assignment_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->execute();
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    
?>

<!-- Head section -->
<?php include('head.php'); ?>
<!-- Head section -->

<body>

  <!-- Header -->
  <?php include('header.php'); ?>

  <!-- Sidebar -->
  <?php include('sidebar.php'); ?>

  <!-- Main content -->
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card overflow-auto">
            <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mt-2">ตรวจสอบงานที่มอบหมาย</h4>
            <a href="check_ass_all.php?assignment_id=<?= $assignment_id;?>" class="btn btn-primary">นักเรียนทั้งหมด</a>
        </div>


              <div class="mt-5">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                    <th>รหัสนักเรียน</th>
                      <th>ชื้อ นักเรียน</th>
                      <th>ไฟล์ที่ส่ง</th>
                      <th>วันที่ส่ง</th>
                      <th>ความคิดเห็นจากครู</th> 
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $unique_student_ids = array(); // เก็บ student_id เพื่อตรวจสอบว่าถูกดึงมาแล้วหรือยัง
                    foreach($assignments as $assignment):
                        $student_id = $assignment['student_id'];
                        // ตรวจสอบว่า student_id นี้เคยถูกดึงมาแล้วหรือยัง
                        if (!in_array($student_id, $unique_student_ids)) {
                            $unique_student_ids[] = $student_id; // เพิ่ม student_id เข้าไปในอาร์เรย์เพื่อไม่ให้ถูกดึงซ้ำอีก
                            // ดึงข้อมูลของนักเรียนจากฐานข้อมูล
                            $stmt_student = $db->prepare("SELECT username, first_name, last_name FROM students WHERE s_id = :student_id ORDER BY username ASC");
                            $stmt_student->bindParam(':student_id', $student_id);
                            $stmt_student->execute();
                            $student = $stmt_student->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                    <td><?= $student['username'] ?></td>
                        <td><?= $student['first_name'] ?> <?= $student['last_name'] ?></td>
                        <td>
                            <?php
                            // แสดงไฟล์ที่เกี่ยวข้องกับนักเรียนนี้
                            foreach($assignments as $file_assignment) {
                                if ($file_assignment['student_id'] == $student_id) {
                                    $file_path = "../student/uploads/{$file_assignment['submitted_file']}";
                                    if (file_exists($file_path)) {
                                        echo "<a href=\"{$file_path}\" download>{$file_assignment['submitted_file']}</a><br>";
                                    } else {
                                        echo "ไม่พบไฟล์<br>";
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
    <?php
    // Check if the assignment is submitted before or after the deadline
    if (!empty($assignment['submitted_datetime']) && !empty($assignment['close_time'])) {
        $submitted_datetime = strtotime($assignment['submitted_datetime']);
        $close_time = strtotime($assignment['close_time']);
        if ($submitted_datetime < $close_time) {
            // If submitted before the deadline, display in green color
            echo '<span style="color: green;">' . $assignment['submitted_datetime'] . ' - ส่งก่อนเวลา</span>';
        } else {
            // If submitted after the deadline, display in red color
            echo '<span style="color: red;">' . $assignment['submitted_datetime'] . ' - เลยกำหนด</span>';
        }
    } else {
        echo "ข้อมูลไม่สมบูรณ์";
    }
    ?>
</td>

                        <td>
                            <?php
                            // Check if there is a comment in the database for this assignment
                            $comment = isset($assignment['comment']) ? $assignment['comment'] : '';
                            ?>
                            <input type="text" id="comment_<?= $assignment['id'] ?>" class="form-control" value="<?= $comment ?>" placeholder="พิมพ์ความคิดเห็นของคุณที่นี่" onchange="updateStatus(<?= $assignment['id'] ?>, this.value)">
                        </td>
                        <td id="assignment_row_<?= $assignment['id'] ?>">
                            <select class="form-select" name="status" onchange="updateStatus(<?= $assignment['id'] ?>, this.value)">
                                <option value="ตรวจแล้ว" <?= ($assignment['status'] == 'ตรวจแล้ว') ? 'selected' : '' ?>>ตรวจแล้ว</option>
                                <option value="ยังไม่ตรวจ" <?= ($assignment['status'] == 'ยังไม่ตรวจ') ? 'selected' : '' ?>>ยังไม่ตรวจ</option>
                            </select>
                        </td>
                    </tr>
                    <?php 
                        }
                    endforeach; 
                    ?>
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


  <script>
 function updateStatus(assignment_id, new_status) {
    var comment = document.getElementById('comment_' + assignment_id).value; // รับค่า comment จาก input field
    $.ajax({
        url: 'update_status.php',
        method: 'POST',
        data: {
            assignment_id: assignment_id,
            new_status: new_status,
            comment: comment // เพิ่ม comment ไปในข้อมูลที่ส่งไปยัง update_status.php
        },
        success: function(response) {
            var row = document.getElementById('assignment_row_' + assignment_id);
            if (new_status === 'ตรวจแล้ว') {
                row.style.backgroundColor = 'lightgreen';
            } else if (new_status === 'ยังไม่ตรวจ') {
                row.style.backgroundColor = 'lightcoral';
            }
            alert('บันทึกสถานะเรียบร้อยแล้ว');
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

</script>

  <!-- Footer -->
  <?php include('footer.php');?>
  
  <!-- Scripts -->
  <?php include('scripts.php');?>
  <script>
    // Store the current URL in local storage when the page loads
    localStorage.setItem('previousPageUrl', window.location.href);
  </script>
</body>
</html>

<?php
} else {
    echo "ไม่พบ assignment_id ใน URL";
}
?>
