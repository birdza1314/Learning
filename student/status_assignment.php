<?php
include('../connections/connection.php');
session_start();

// Check if the user is logged in and has a role of 'student'
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

// ดึงข้อมูลของนักเรียน
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

// ดึงรายละเอียดของการบ้านจากฐานข้อมูล
$assignment_id = $_GET['assignment_id'];
$stmt = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
$stmt->bindParam(':assignment_id', $assignment_id);
$stmt->execute();
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

// Query to fetch submission status
$stmt_submission = $db->prepare("SELECT * FROM submitted_assignments WHERE assignment_id = :assignment_id AND student_id = :student_id");
$stmt_submission->bindParam(':assignment_id', $assignment_id);
$stmt_submission->bindParam(':student_id', $_SESSION['user_id']);
$stmt_submission->execute();
$submission = $stmt_submission->fetch(PDO::FETCH_ASSOC);

// Check if submission exists
if ($submission) {
    $assignment_submission_status = "ส่งแล้ว";
    $status_color = "table-success"; // สีเขียวสำหรับส่งแล้ว
} else {
    $assignment_submission_status = "ยังไม่ส่ง";
    $status_color = "table-danger"; // สีแดงสำหรับยังไม่ส่ง
}

// กำหนดค่าสำหรับภาษาไทย
setlocale(LC_TIME, 'th_TH.UTF-8');

// แสดงวันที่และเวลาเริ่มและสิ้นสุด
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
?>

<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    <main id="main" class="main">
        <div class="card overflow-auto">
            <div class="card-body">
                <div class="container">
                    <h2 class="py-2"> <i class="bi bi-journal-arrow-up text-danger"></i> <?php echo $assignment['title']; ?></h2>
                    <div class="row">
                        <div class="card">
                            <!-- แสดงวันที่และเวลาเริ่มต้นและสิ้นสุด -->
                            เปิด: <?php echo $startDateTime; ?><br>
                            สิ้นสุด: <?php echo $endDateTime; ?>
                        </div>
                        
                        <div class="mt-3 card">
                            <h5>ไฟล์</h5>
                            <?php
                            // Check if assignment_id is set
                            if(isset($_GET['assignment_id'])) {
                                $assignment_id = $_GET['assignment_id'];

                                // Prepare and execute SQL query to fetch file data from assignments table
                                $stmt_file = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
                                $stmt_file->bindParam(':assignment_id', $assignment_id);
                                $stmt_file->execute();
                                $assignment = $stmt_file->fetch(PDO::FETCH_ASSOC);

                                // Check if file data is found
                                if ($assignment) {
                                    $file_name = $assignment['file_name']; // Get file name from database
                                    $file_path = $assignment['file_path']; // Get file path from database

                                    if (file_exists('../teacher/' . $file_path)) { // Adjust the file path accordingly
                                        // Create a link to download the file
                                        echo '<a href="../teacher/' . $file_path . '" download="'.$file_name.'" class="text-decoration-none">'.$file_name.'</a>';
                                    } else {
                                        echo 'ไม่พบไฟล์';
                                    }
                                } else {
                                    echo 'ไม่พบข้อมูลไฟล์';
                                }
                            } else {
                                echo 'ไม่พบ assignment_id ใน URL';
                            }
                            ?>
                   

                        <div class="py-2 mt-5">
                            <?php if ($submission) { ?>
                                <a href="update_assignment.php?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-primary">แก้ไขงาน</a>
                            <?php } else { ?>
                                <a href="submit_assignment.php?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-primary">เพิ่มการส่งงาน</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="container mt-3">
                        <h2>สถานะการส่งงาน</h2>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>สถานะการส่งงาน</th>
                                    <td class="<?php echo $status_color; ?>"><?php echo $assignment_submission_status; ?></td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">สถานะการตรวจ</th>
                                    <td>
                                        <?php 
                                        if ($submission !== false) {
                                            echo $submission['status']; 
                                        } else {
                                            echo "ยังไม่มีการตรวจงาน";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ปรับปรุงครั้งสุดท้ายเมื่อ</th>
                                    <td>
                                        <?php 
                                        if ($submission !== false) {
                                            if ($current_time < $deadline) {
                                                echo "<span class='text-success'>" . $submission['last_updated'] . " (งานมอบหมายถูกส่งก่อนเวลา)</span>";
                                            } else {
                                                echo "<span class='text-danger'>" . $submission['last_updated'] . " (งานมอบหมายส่งหลังเวลา)</span>";
                                            }
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>เวลาที่เหลืออยู่</th>
                                    <td><?php echo $time_remaining_text; ?></td>
                                </tr>
                                <tr>
                                <th>ไฟล์ที่ส่ง</th>
                                <td>
                                    <?php 
                                    if ($submission !== false && isset($submission['submitted_file'])) {
                                        // หากมีการส่งไฟล์
                                        echo "<a href='../student/uploads/{$submission['submitted_file']}' download>{$submission['submitted_file']}</a>";
                                    } else {
                                        // หากยังไม่มีการส่งไฟล์
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
    <th>ความคิดเห็น</th>
    <td>
        <?php 
        if ($submission !== false && isset($submission['comment'])) {
            // หากมีความคิดเห็น
            echo $submission['comment'];
        } else {
            // หากยังไม่มีความคิดเห็น
            echo "-";
        }
        ?>
    </td>
</tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include('footer.php'); ?>
    <?php include('scripts.php'); ?>
    <!-- Add jQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Bootstrap script -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Add custom script for search functionality -->
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
                    });
                } else {
                    $("#show-list").html("");
                }
            });

            $(document).on('click', 'a', function() {
                $("#search").val($(this).text());
                $("#show-list").html("");
            });
        });
    </script>

</body>
</html>
