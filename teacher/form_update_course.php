<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
}

try {
    // ทำคำสั่ง SQL เพื่อดึงข้อมูลของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM teachers WHERE t_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // แสดงข้อผิดพลาด
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
// ตรวจสอบว่ามีการส่ง course_id มาหรือไม่
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    try {
        // ทำคำสั่ง SQL เพื่อดึงข้อมูลของคอร์สที่ต้องการแก้ไข
        $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        // ดึงข้อมูลกลุ่มทั้งหมด
        $stmt = $db->query("SELECT * FROM learning_subject_group");
        $stmt->execute();
        $groups = $stmt->fetchAll();
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
        exit(); // จบการทำงานถ้าพบข้อผิดพลาด
    }

    // ตรวจสอบว่ามีข้อมูล $teacher หรือไม่
    if (!empty($_SESSION['teacher_id'])) {
        $teacher_id = $_SESSION['teacher_id'];

        try {
            // ทำคำสั่ง SQL เพื่อดึงข้อมูลของครู
            $stmt = $db->prepare("SELECT * FROM teachers WHERE teacher_id = :teacher_id");
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->execute();

            // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // แสดงข้อผิดพลาด
            echo "Error: " . $e->getMessage();
            exit(); // จบการทำงานถ้าพบข้อผิดพลาด
        }
    }
} else {
    // ถ้าไม่มี course_id ที่ส่งมา ให้ redirect หรือทำการแจ้งเตือนตามที่เหมาะสม
    header('Location: index.php');
    exit();
}
?>
<!-- ตรวจสอบว่ามีข้อมูล $course และ $groups หรือไม่ -->
<?php if (isset($course, $groups)) : ?>
    <!-- Header -->
    <?php include('head.php'); ?>
    <!-- Header -->

    <body>
    <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Course</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="history.back()">My Course</a></li>   
                <li class="breadcrumb-item active">Edit Course</li>
            </ol>
        </nav>      
    </div><!-- End Page Title -->


            <section class="section">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card ">
                            <div class="card-body">
                                <h5 class="card-title">Edit Course</h5>
                                <div class="filter text-end ">
                                <a href="add_lessons.php?course_id=<?php echo $course['c_id']; ?>" class="btn btn-success">
                                    <i class="bi bi-file-earmark-plus"></i> เพิ่มบทเรียน
                                </a>
                                </div>
                                <!-- Update Course Form -->
                                <form class="mx-auto" action="update_course_db.php" method="post" enctype="multipart/form-data">
                                    <!-- เพิ่ม input hidden เพื่อเก็บค่า course_id -->
                                    <input type="hidden" name="course_id" value="<?php echo $course['c_id']; ?>">
                                    <!-- เพิ่ม input hidden เพื่อเก็บค่า course_id -->
                                   <div class="row mb-3">
                                        <label for="c_img" class="col-sm-2 col-form-label">รูป</label>
                                        <div class="col-sm-10">
                                            <!-- แสดงรูปภาพอันเดิม -->
                                            <img src="<?php echo $course['c_img']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                                            <!-- Input ให้เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน) -->
                                           
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="c_img" class="col-sm-2 col-form-label">แก้ไข รูป</label>
                                        <div class="col-sm-10">
                                        <input class="form-control" type="file" id="c_img" name="c_img">  
                                        </div>                                      
                                    </div>
                                    <div class="row mb-3">
                                        <label for="course_name" class="col-sm-2 col-form-label">ชื่อ วิชา</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $course['course_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="course_Code" class="col-sm-2 col-form-label">รหัส วิชา</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="course_Code" name="course_code" value="<?php echo $course['course_code']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="course_description" class="col-sm-2 col-form-label">รายละเอียด</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" style="height: 100px" name="course_description"><?php echo $course['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="group_id" class="col-sm-2 col-form-label">กลุ่ม</label>
                                        <div class="col-sm-10">
                                            <!-- เพิ่ม dropdown เพื่อเลือกกลุ่ม -->
                                            <select class="form-control" id="group_id" name="group_id">
                                                <?php foreach ($groups as $group) : ?>
                                                    <option value="<?php echo $group['group_id']; ?>" <?php echo ($group['group_id'] == $course['group_id']) ? 'selected' : ''; ?>><?php echo $group['group_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- เพิ่ม dropdown เพื่อเลือกกลุ่ม -->
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="is_open" class="col-sm-2 col-form-label">สถานะ</label>
                                        <div class="col-sm-10">
                                            <!-- เพิ่ม dropdown เพื่อเลือกสถานะ -->
                                            <select class="form-control" id="is_open" name="is_open">
                                                <option value="1" <?php echo ($course['is_open'] == 1) ? 'selected' : ''; ?>>เปิด</option>
                                                <option value="0" <?php echo ($course['is_open'] == 0) ? 'selected' : ''; ?>>ปิด</option>
                                            </select>
                                            <!-- เพิ่ม dropdown เพื่อเลือกสถานะ -->
                                        </div>
                                    </div>
                                    <!-- เพิ่ม input text เพื่อรับค่า access_code -->
                                    <div class="row mb-3">
                                        <label for="access_code" class="col-sm-2 col-form-label">รหัส</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="access_code" name="access_code" value="<?php echo $course['access_code']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                    <label for="class" class="col-sm-2 col-form-label">เลือกนักเรียน</label>
                                    <div class="col-sm-10">
                                        <!-- เพิ่ม dropdown เพื่อเลือกนักเรียน -->
                                        <select class="form-control" id="class" name="class">
                                            <?php
                                            include('../connections/connection.php');
                                            
                                            // สร้างคำสั่ง SQL เพื่อดึงชื่อคลาสที่ไม่ซ้ำกัน
                                            $sql = "SELECT DISTINCT class FROM students";
                                            $stmt = $db->query($sql);
                                            $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // วนลูปเพื่อแสดงรายชื่อคลาสใน dropdown
                                            foreach ($classes as $class) : ?>
                                                <option value="<?php echo $class['class']; ?>"><?php echo $class['class']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- เพิ่ม dropdown เพื่อเลือกนักเรียน -->
                                    </div>
                                    </div>
                                    <!-- เพิ่ม input text เพื่อรับค่า access_code -->
                                    <div class="text-center">
                                        <button type="save" class="btn btn-primary">บันทึก</button>
                                        <a href="../teacher/course.php" class="btn btn-secondary" onclick="cancelEdit()">ยกเลิก</a>
                                    </div>
                                </form><!-- End Update Course Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <?php include('footer.php'); ?>
        <!-- Footer -->

  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Add Bootstrap script -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <!-- Scripts -->
        <?php include('scripts.php'); ?>
        <!-- Scripts -->

    </body>

    </html>
<?php else : ?>
    <!-- กรณีไม่มีข้อมูล $course หรือ $groups ให้แสดงข้อความหรือทำการ redirect ไปที่หน้าที่เหมาะสม -->
    <p>No course or groups found</p>
<?php endif; ?>
