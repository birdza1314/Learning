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

// Prepare SQL statement to check if the student has registered for this course
$stmt = $db->prepare("SELECT * FROM student_course_registration WHERE student_id = :student_id AND course_id = :course_id");
$stmt->bindParam(':student_id', $user_id);
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();
$registration = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registration) {
    // If the student has not registered for this course, redirect to the registration page
    header('Location: registeration_course.php?course_id=' . $course_id);
    exit();
}

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

<?php include('head.php'); ?>
<body>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>
    
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
                                        <!-- เริ่มต้นการวนลูปการแสดงผลข้อมูลหัวข้อ -->
                                        <?php include('display_topics.php'); ?>
                                        <!-- สิ้นสุดการวนลูปการแสดงผลข้อมูลหัวข้อ -->
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
