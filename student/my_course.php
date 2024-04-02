<?php
session_start();
include('../connections/connection.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php'); // ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหากไม่ได้ล็อกอิน
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
            <div class="card">
                <div class="card-body my-4">
                   
                    <div class="row mt-3">
                        <div class="col-sm-2">
                        <div class="form-group">
                        <label for="display-format">แสดงรูปแบบ:</label>
                        <select class="form-control" id="display-format">
                            <option value="card">Card</option>
                            <option value="list">List</option>
                        </select>
                    </div>                        
                        </div>
                        <div class="col-sm-10">
                        <div class="search-bar">
                            <form action="details_All_course.php" method="POST" class="p-3">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control form-control-lg  rounded-0" placeholder="ค้นหารายวิชา..." autocomplete="off" required>
                                        <input type="submit" name="submit" value="ค้นหา" class="btn btn-outline-secondary btn-sm">
                                </div>
                                <div class="col-md-5">
                                    <div class="list-group" style="width: 250px;" id="show-list"></div>
                                </div>
                            </form>
                        </div><!-- End Search Bar -->
                        </div>
                    </div>
  

                    <!-- ส่วนที่แสดงเป็น List -->
                    <div class="row mt-3 card-format">
                        <?php if ($courses): ?>
                            <?php foreach ($courses as $course): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                    <?php if (!empty($course['c_img'])): ?>
                                        <div class="text-center">
                                            <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <img src="../admin/teacher_process/img/course.jpg" class="card-img-top" alt="รูปภาพ" style="height: 150px; object-fit: cover;">
                                        </div>
                                    <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                                            <p class="card-text">รหัสวิชา: <?php echo $course['course_code']; ?></p>
                                            <?php
                                            // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
                                            $teacher_id = $course['teacher_id'];
                                            $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                                            $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                                            $teacher_stmt->execute();
                                            $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <p class="card-text">ครูผู้สอน: <?php echo $teacher['first_name']; ?> <?php echo $teacher['last_name']; ?></p>
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
                                            <a href="course_details.php?course_id=<?php echo $course['c_id']; ?>" class="btn btn-outline-primary mt-1" style="float: right;">รายละเอียด</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col">
                                <p>ไม่มีรายวิชา</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row mt-3 list-format" style="display: none;">
    
    <?php if ($courses): ?>
        <?php foreach ($courses as $course): ?>
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo $course['c_img']; ?>" class="card-img-top" alt="Course Image" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                                <p class="card-text">รหัสวิชา: <?php echo $course['course_code']; ?></p>
                                <?php
                                // เรียกข้อมูลผู้สอนจากตาราง teachers โดยใช้ teacher_id จากตาราง courses เป็นเงื่อนไข
                                $teacher_id = $course['teacher_id'];
                                $teacher_stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :teacher_id");
                                $teacher_stmt->bindParam(':teacher_id', $teacher_id);
                                $teacher_stmt->execute();
                                $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <p class="card-text">ครูผู้สอน: <?php echo $teacher['first_name']; ?> <?php echo $teacher['last_name']; ?></p>
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
                            </div>
                        </div>
                        <a href="course_details.php?course_id=<?php echo $course['c_id']; ?>" class="btn btn-outline-primary mt-3" style="float: right;">รายละเอียด</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col">
            <p>ไม่มีรายวิชา</p>
        </div>
    <?php endif; ?>
</div>


                </div>
                </div>
            </div>
        </div>
    </main>
<?php include('footer.php');?>
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<?php include('scripts.php');?>
<script>
$(document).ready(function() {
    $('#display-format').change(function() {
        var format = $(this).val();
        if (format === 'list') {
            $('.card-format').hide();
            $('.list-format').show(); // ต้องแสดง .list-format เมื่อเปลี่ยนเป็น list
        } else if (format === 'card') {
            $('.list-format').hide();
            $('.card-format').show();
        }
    });
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
    });

    $(document).on('click', 'a', function() {
        $("#search").val($(this).text())
        $("#show-list").html("");
    });
});
</script>
</body>
</html>    