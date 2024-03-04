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
// Check if course_id is set
if (!isset($_GET['course_id'])) {
    header('Location: index.php');
    exit();
}

$course_id = $_GET['course_id'];

try {
    // Prepare SQL statement to select lessons of the specific course
    $stmt = $db->prepare("SELECT * FROM lessons WHERE course_id = :course_id");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    // Fetch lessons data
    $lessons = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

try {
    // Prepare SQL statement to select course details
    $stmt = $db->prepare("SELECT * FROM courses WHERE c_id = :course_id");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    // Fetch course details
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch all groups
    $stmt = $db->query("SELECT * FROM learning_subject_group");
    $stmt->execute();
    $groups = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

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
            <h2>Course Details</h2>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $course['course_name']; ?></h5>
                    <p class="card-text">Course Code: <?php echo $course['course_code']; ?></p>
                    <p class="card-text">Description: <?php echo $course['description']; ?></p>
                </div>
            </div>
            <div id="accordionContainer">
            <?php foreach($lessons as $lesson): ?>
                        <section class="section card mb-3 mt-5">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header d-flex align-items-center">
                                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse<?= $lesson['lesson_id']; ?>" aria-expanded="true" aria-controls="collapse<?= $lesson['lesson_id']; ?>">
                                            <?= $lesson['lesson_name']; ?>
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
                                                <?php }  elseif ($topic['file_id'] != null) {
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
                                                                        <?php
                                                                        $file_directory = '../teacher/uploads/files/';
                                                                        $file_name = $file['file_name']; // ใช้ชื่อไฟล์จากฐานข้อมูล
                                                                        $file_path = $file_directory . $file_name;

                                                                        if (file_exists($file_path)) {
                                                                            // สร้างลิงก์สำหรับดาวน์โหลดไฟล์
                                                                            echo '<a href="'.$file_path.'" download="'.$file_name.'" class="text-decoration-none">'.$file_name.'</a>';
                                                                        } else {
                                                                            echo 'ไม่พบไฟล์';
                                                                        }
                                                                        ?>
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
                                                                    <div class="d-flex align-items-center justify-content-center bg-image hover-zoom">
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
                                                    <div class="col-lg-12">
                                                    <div class="card border rounded-3 shadow-sm">
                                                        <div class="card-body hover-effect text-hover-white">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                            <div class="d-flex  mt-4">
                                                                <i class="bi bi-file-earmark-text-fill text-primary me-2"></i>
                                                                <h5><?= $quiz['quiz_title']; ?></h5>
                                                            </div>
                                                            </div>

                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                <?php 
                                                }elseif ($topic['assignment_id'] != null) {
                                                    $stmt_assignment = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
                                                    $stmt_assignment->bindParam(':assignment_id', $topic['assignment_id']);
                                                    $stmt_assignment->execute();
                                                    $assignment = $stmt_assignment->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <div class="card border rounded-3 shadow-sm hover-effect text-hover-white ">
                                                            <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex mt-4">
                                                                        <i class="bi bi-file-earmark-text-fill text-primary me-2"></i>
                                                                        <h5><?= $assignment['title']; ?></h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php 
                                                }elseif ($topic['url_id'] != null) {
                                                    $stmt_url = $db->prepare("SELECT * FROM urls WHERE url_id = :url_id");
                                                    $stmt_url->bindParam(':url_id', $topic['url_id']);
                                                    $stmt_url->execute();
                                                    $url = $stmt_url->fetch(PDO::FETCH_ASSOC);
                                                    
                                                    if ($url && isset($url['url'])) {
                                                        ?>
                                                        <div class="col-lg-12">
                                                            <div class="card border rounded-3 shadow-sm">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-8">
                                                                            <div class="d-flex mt-4">
                                                                                <i class="bi bi-link-45deg text-primary me-2"></i>
                                                                                <h5><?= $url['description']; ?></h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="videos">
                                                                            <a href="<?= $url['url']; ?>" target="_blank">ดูวิดีโอบน YouTube</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        // แสดงข้อความแจ้งเตือนว่า URL ไม่ถูกต้อง
                                                        ?>
                                                        <div class="col-lg-12">
                                                            <div class="alert alert-danger" role="alert">
                                                                URL วิดีโอนี้ไม่ถูกต้อง กรุณาตรวจสอบ URL และลองอีกครั้ง
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } 
                                                                                                                                                                                                   
                                            }
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endforeach; ?>
            </div>
        </div>
    </main>
    
    <?php include('footer.php'); ?>
    <?php include('scripts.php'); ?>
    <!-- Add jQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Bootstrap script -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Store the current URL in local storage when the page loads
        localStorage.setItem('previousPageUrl', window.location.href);
    </script>
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
          })
      } else {
          $("#show-list").html("");
      }
  })

  $(document).on('click', 'a', function() {
      $("#search").val($(this).text())
      $("#show-list").html("");
  })
})
</script>
</body>
</html>
