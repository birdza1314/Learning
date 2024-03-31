<?php
include('../connections/connection.php');
session_start();

// Check if the user is logged in and has a role of 'student'
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM students WHERE s_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if assignment_id is set
if (!isset($_GET['assignment_id'])) {
    header('Location: index.php');
    exit();
}

$assignment_id = $_GET['assignment_id'];

// Fetch assignment details from the database
$stmt = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->execute();
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch submission details for the current user and assignment
$user_id = $_SESSION['user_id'];
$stmt_submission = $db->prepare("SELECT * FROM submitted_assignments WHERE assignment_id = :assignment_id AND student_id = :student_id");
$stmt_submission->bindParam(':assignment_id', $assignment_id);
$stmt_submission->bindParam(':student_id', $user_id);
$stmt_submission->execute();
$submission = $stmt_submission->fetch(PDO::FETCH_ASSOC);

// Redirect if no submission found
if (!$submission) {
    header('Location: status_assignment.php');
    exit();
}

// กำหนดค่าสำหรับภาษาไทย
setlocale(LC_TIME, 'th_TH.UTF-8');

// แสดงวันที่และเวลาเริ่มและสิ้นสุดการส่งงาน
$startDateTime = strftime('%A, %e %B %Y %I:%M %p', strtotime($assignment['open_time']));
$endDateTime = strftime('%A, %e %B %Y %I:%M %p', strtotime($assignment['close_time']));
// แปลงวันและเวลาของการส่งงานเป็นวัตถุ DateTime
$deadline = new DateTime($assignment['close_time']);
$current_time = new DateTime();
// คำนวณความแตกต่างระหว่างวันและเวลาปัจจุบันกับวันและเวลาสิ้นสุดของการส่งงาน
$time_remaining = date_diff($current_time, $deadline);

// ตรวจสอบหากเวลาที่เหลือน้อยกว่า 0 แสดงว่าเลยกำหนดการส่งแล้ว
if ($time_remaining->invert) {
    $time_remaining_text = "เลยกำหนดการส่ง";
} else {
    $time_remaining_text = $time_remaining->format('%a วัน %H ชั่วโมง %I นาที %S วินาที');
}
// Process update submission here...

?>
<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    <main id="main" class="main">
        <div class="card overflow-auto">
            <div class="card-body">
                <div class="container">
                    <h2 class="py-2"> <i class="bi bi-journal-arrow-up text-danger"></i> Update Assignment: <?php echo $assignment['title']; ?></h2>
                    <div class="row">
                        <div class="card">
                           <!-- แสดงวันที่และเวลาเริ่มต้นและสิ้นสุด -->
                        เปิด: <?php echo $startDateTime; ?><br>
                        สิ้นสุด: <?php echo $endDateTime; ?>
                    </div>
                    <div class="mt-3 card">
                        <h5>รายละเอียด</h5>
                        <p><?php echo $assignment['description']; ?></p><br><br>
                        </div>
                    </div>
                    <!-- Display submitted files for updating -->
                    <div class="container mt-3">
                        <h2>Submitted Files</h2>
                        <ul id="file-list" class="list-group">
                            <?php
                            // Fetch submitted files for the assignment
                            $stmt_files = $db->prepare("SELECT * FROM submitted_assignments WHERE assignment_id = :assignment_id AND student_id = :student_id");
                            $stmt_files->bindParam(':assignment_id', $assignment_id);
                            $stmt_files->bindParam(':student_id', $user_id);
                            $stmt_files->execute();
                            $files = $stmt_files->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($files as $file) {
                                echo "<li class='list-group-item'>{$file['submitted_file']} <button class='btn btn-sm btn-danger' onclick='deleteFile({$file['id']})'><i class='bi bi-trash'></i> Delete</button></li>";
                            }
                            ?>
                        </ul>
                        <!-- File Upload Form -->
                        <form action="upload.php" method="post" enctype="multipart/form-data" id="file-upload-form">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="file" id="file" >
                                <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-cloud-upload"></i> Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include('footer.php'); ?>
    <?php include('scripts.php'); ?>
    <!-- Add jQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <!-- JavaScript for deleting files -->
<script>
    function deleteFile(fileId) {
        $.ajax({
            url: 'delete_file.php',
            type: 'POST',
            data: { fileId: fileId },
            success: function(response) {
                // Reload the page or update the file list as needed
                // For example:
                location.reload();
                // Redirect back to status_assignment.php after file deletion
                window.history.back();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
</body>
</html>
