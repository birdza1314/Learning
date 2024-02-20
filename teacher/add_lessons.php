<?php
include('../connections/connection.php');
// ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
    header('Location: login.php'); 
    exit();
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

// Check if course_id is set
if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    try {
        // Prepare SQL statement to select lessons of the specific course and user
        $stmt = $db->prepare("SELECT * FROM lessons WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // Fetch lessons data
        $lessons = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo "Error: " . $e->getMessage();
        exit(); // Stop script execution if an error occurs
    }
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
<!-- ======= Head ======= -->
<?php include('head.php'); ?>
<!-- ======= Head ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>

  <!-- ======= Sidebar ======= -->
  <?php include('sidebar.php'); ?>

  <main id="main" class="main">
  <div class="container">
    <div class="card">
        <div class="card-body">
            <?php echo $teacher['first_name']; ?>
            <?php echo $course['course_name']; ?>
            <div class="row">
                    <button type="button"  class="btn btn-outline-primary btn-block mt-3" data-toggle="modal" data-target="#addLessonModal">เพิ่มบทเรียน</button>
            </div>
            <!-- เพิ่ม Element input hidden สำหรับ courseId -->
            <input type="hidden" id="courseId" value="<?= $course_id ?>">
            <div id="accordionContainer">
                <!-- Loop through lessons and display them --> 
                <?php foreach($lessons as $lesson): ?>
                    <section class="section card mb-3 mt-5">
                        <div class="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex align-items-center">
                                    <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse<?= $lesson['lesson_id']; ?>" aria-expanded="true" aria-controls="collapse<?= $lesson['lesson_id']; ?>">
                                        <?= $lesson['lesson_name']; ?>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning edit-lesson-btn" data-lesson-id="<?= $lesson['lesson_id']; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger delete-lesson-btn" data-lesson-id="<?= $lesson['lesson_id']; ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </h2>
                                <div id="collapse<?= $lesson['lesson_id']; ?>" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                    <?php
                                    // เรียกใช้งาน connections/connection.php เพื่อเชื่อมต่อกับฐานข้อมูล
                                    include('../connections/connection.php');

                                    // ดึงข้อมูลจากตาราง add_topic
                                    $stmt = $db->prepare("SELECT * FROM add_topic WHERE lesson_id = :lesson_id");
                                    $stmt->bindParam(':lesson_id', $lesson['lesson_id']);
                                    $stmt->execute();
                                    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // ตรวจสอบว่ามีข้อมูลหัวข้อในบทเรียนนี้หรือไม่
                                    if ($topics) {
                                        foreach ($topics as $topic) {
                                            // ตรวจสอบว่ามี video_embed_id หรือ video_file_id
                                            if ($topic['video_embed_id'] != null) {
                                                // กรณีมี video_embed_id แสดงว่าเป็นวิดีโอจาก embed code
                                                // ดึงข้อมูลจากตาราง videos_embed
                                                $stmt_embed = $db->prepare("SELECT * FROM videos_embed WHERE video_embed_id = :video_embed_id");
                                                $stmt_embed->bindParam(':video_embed_id', $topic['video_embed_id']);
                                                $stmt_embed->execute();
                                                $video_embed = $stmt_embed->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="mt-5 text-center">
                                                    <p>Description: <?= $video_embed['description']; ?></p>
                                                    <?= $video_embed['embed_code']; ?>
                                                </div>
                                            <?php } elseif ($topic['video_file_id'] != null) {
                                                // กรณีมี video_file_id แสดงว่าเป็นวิดีโอจากไฟล์
                                                // ดึงข้อมูลจากตาราง videos_file
                                                $stmt_file = $db->prepare("SELECT * FROM videos_file WHERE video_file_id = :video_file_id");
                                                $stmt_file->bindParam(':video_file_id', $topic['video_file_id']);
                                                $stmt_file->execute();
                                                $video_file = $stmt_file->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="mt-5 text-center ">
                                                    <p><?= $video_file['description_file']; ?></p>
                                                    <video controls>
                                                        <source src="<?= $video_file['file_path']; ?>" type="video/mp4">
                                                    </video>
                                                </div>
                                                
                                                <?php } elseif ($topic['file_id'] != null) {
                                                // กรณีมี file_id แสดงว่าเป็นไฟล์
                                                // ดึงข้อมูลจากตาราง files
                                                $stmt_file = $db->prepare("SELECT * FROM files WHERE file_id = :file_id");
                                                $stmt_file->bindParam(':file_id', $topic['file_id']);
                                                $stmt_file->execute();
                                                $file = $stmt_file->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="row mt-2">
                                                    <div class="col-lg-12">
                                                        <div class="card border rounded-3">
                                                        <div class="card-body">
                                                            <p class="card-text"></p>
                                                            <div class="d-flex align-items-center">
                                                            <i class="bi bi-file-earmark-text-fill text-red me-2"></i>
                                                            <a href="<?= $file['file_path']; ?>" target="_blank" class="text-decoration-none"><?= $file['file_name']; ?></a>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }elseif ($topic['img_id'] != null) {
                                                // กรณีมี img_id แสดงว่าเป็นรูปภาพ
                                                // ดึงข้อมูลจากตาราง images
                                                $stmt_img = $db->prepare("SELECT * FROM images WHERE img_id = :img_id");
                                                $stmt_img->bindParam(':img_id', $topic['img_id']);
                                                $stmt_img->execute();
                                                $image = $stmt_img->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <div class="row mt-2">
                                                    <div class="col-lg-12">
                                                        <div class="card border rounded-3">
                                                            <div class="card-body text-center">
                                                                <p class="card-text"></p>
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <img id="zoom-image" src="<?= $image['file_path']; ?>" alt="<?= $image['filename']; ?>" class="img-fluid mx-auto" width="50%" height="25">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            }elseif ($topic['quiz_id'] != null) {
                                                // กรณีมี quiz_id แสดงว่าเป็น Quiz
                                                // ดึงข้อมูลจากตาราง quizzes
                                                $stmt_quiz = $db->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
                                                $stmt_quiz->bindParam(':quiz_id', $topic['quiz_id']);
                                                $stmt_quiz->execute();
                                                $quiz = $stmt_quiz->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <div class="row mt-2">
                                                    <div class="col-lg-12">
                                                        <div class="card border rounded-3">
                                                        <div class="card-body">
                                                            <p class="card-text"></p>
                                                            <div class="d-flex align-items-center">
                                                            <i class="bi bi-file-earmark-text-fill text-red me-2"></i>
                                                            <p class="card-text"><?= $quiz['quiz_title']; ?></p>
                                                            </div>
                                                            <div class="d-flex align-items-right">
                                                            <!-- ปุ่มแก้ไข -->
                                                                <button type="button" class="btn btn-primary" onclick="editQuiz(<?= $quiz['quiz_id']; ?>)">แก้ไข</button>
                                                                <!-- ปุ่มลบ -->
                                                                <button type="button" class="btn btn-danger" onclick="deleteQuiz(<?= $quiz['quiz_id']; ?>)">ลบ</button>

                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            }
                                            
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                        <div class="dropdown dropdown-mega mt-5 position-static dropdown-center" >
                                            <button  class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                เพิ่มหัวข้อ
                                            </button>
                                            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                                                <li class="mega-content px-4">
                                                <div class="container">
                                                    <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="button" class="btn btn-outline-info btn-block mx-2 open-Quiz-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                            <i class="bi bi-journal-arrow-up text-info"></i><br>Quiz
                                                        </button>
                                                        <a href="form_assignment.php" role="button" class="btn btn-outline-success btn-block mx-2"><i class="bi bi-journal-arrow-up text-success"></i><br>Assignment</a>
                                                        <button type="button" class="btn btn-outline-info btn-block mx-2 open-image-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                            <i class="bi bi-journal-arrow-up text-info"></i><br>Image
                                                        </button>
                                                        <button type="button" class="btn btn-outline-info btn-block mx-2 open-video-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo isset($_POST['course_id']) ? $_POST['course_id'] : ''; ?>">
                                                            <i class="bi bi-journal-arrow-up text-info"></i><br>Video
                                                        </button>
                                                        <button type="button" class="btn btn-outline-info btn-block mx-2 open-file-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo isset($_POST['course_id']) ? $_POST['course_id'] : ''; ?>">
                                                            <i class="bi bi-journal-arrow-up text-info"></i><br>File
                                                        </button>

                                                    </div>
                                                    </div>
                                                </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include('Modal.php');?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('footer.php');?>
 <!-- ======= scripts ======= -->
  <?php include('scripts.php');?>

  <!-- Add jQuery script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Add Bootstrap script -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <?php include('scripts_topic.php');?>
  <?php include('Modal_scripts.php');?>
</body>
</html>
