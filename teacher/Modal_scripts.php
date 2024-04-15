<script>
    // เมื่อเลื่อนหน้าจอ
    window.onscroll = function() {stickyBtn()};

    var btn = document.querySelector('.open-Lesson-modal');
    var sticky = btn.offsetTop;

    function stickyBtn() {
    if (window.pageYOffset >= sticky) {
        btn.classList.add("sticky-btn");
    } else {
        btn.classList.remove("sticky-btn");
    }
    }

            // Store the current URL in local storage when the page loads
    localStorage.setItem('previousPageUrl', window.location.href);
</script>


<script>

    // Handle click event on "Video" button to open modal
    $(document).on('click', '.open-video-modal', function() {
        var lessonId = $(this).data('lesson-id'); // Get lesson ID from data attribute
        $('#lessonId').val(lessonId); // Set lesson ID in the hidden input field of the form
        $('#videoModal').modal('show'); // Open the modal
    });
     // Handle click event on "Files" button to open modal
     $(document).on('click', '.open-file-modal', function() {
        var lesson_id = $(this).data('lesson-id');
        var course_id = $(this).data('course-id');

        $('#lesson_id').val(lesson_id);
        $('#course_id').val(course_id);
        $('#fileModal').modal('show'); 
    });

// Handle click event on "Images" button to open modal
$(document).on('click', '.open-image-modal', function() {
    // Get lesson_id and course_id from the button's data attributes
    var lesson_id = $(this).data('lesson-id');
    var course_id = $(this).data('course-id');
    console.log("Lesson ID: ", lesson_id); // Check lesson_id in console
    console.log("Course ID: ", course_id); // Check course_id in console
    // Set the values of lesson_id and course_id in the modal form
    $('#imageModal').find('#image_lesson_id').val(lesson_id);
    $('#imageModal').find('#image_course_id').val(course_id);

    // Show the modal
    $('#imageModal').modal('show'); 
});



$(document).on('click', '.open-Quiz-modal', function() {
    // Get lesson_id and course_id from the button's data attributes
    var lesson_id = $(this).data('lesson-id');
    var course_id = $(this).data('course-id');
    console.log("Lesson ID: ", lesson_id); // Check lesson_id in console
    console.log("Course ID: ", course_id); // Check course_id in console
    // Set the values of lesson_id and course_id in the modal form
    $('#QuizModal').find('#quiz_lesson_id').val(lesson_id);
    $('#QuizModal').find('#quiz_course_id').val(course_id);

    // Show the modal
    $('#QuizModal').modal('show'); 
});

$(document).on('click', '.open-Embed-modal', function() {
    var lesson_id = $(this).data('lesson-id');
    var course_id = $(this).data('course-id');
    console.log("Lesson ID: ", lesson_id); // Check lesson_id in console
    console.log("Course ID: ", course_id); // Check course_id in console
    $('#embedModal').find('#embed_lesson_id').val(lesson_id);
    $('#embedModal').find('#embed_course_id').val(course_id);
     // Show the modal
     $('#embedModal').modal('show'); 
});



$(document).on('click', '.open-URL-modal', function() {
    var lesson_id = $(this).data('lesson-id');
    var course_id = $(this).data('course-id');
    console.log("Lesson ID: ", lesson_id); // Check lesson_id in console
    console.log("Course ID: ", course_id); // Check course_id in console
    $('#urlModal').find('#url_lesson_id').val(lesson_id);
    $('#urlModal').find('#url_course_id').val(course_id);
     // Show the modal
     $('#urlModal').modal('show'); 
});

$(document).ready(function(){
    $(".open-Lesson-modal").click(function(){
        $("#addLessonModal").modal("show");
    });
});

$(document).on('click', '.open-Lessontype-modal', function() {

     $('#addLessontypeModal').modal('show'); 
});
    
</script>
  <script>
$(document).ready(function(){
    $("#saveLessonBtn").click(function(){
        var courseId = $("#courseId").val();
        var lessonName = $("#lessonName").val();
        // ส่งข้อมูลไปยังเซิร์ฟเวอร์เพื่อบันทึกลงในฐานข้อมูล
        $.ajax({
            type: "POST",
            url: "insert_lesson.php",
            data: { course_id: courseId, lesson_name: lessonName },
            success: function(data) {
                // ดำเนินการหลังจากบันทึกข้อมูลสำเร็จ
                // เมื่อบันทึกข้อมูลสำเร็จ ปิด Modal
                $("#addLessonModal").modal("hide");

            // รีเฟรชหน้าเพื่อแสดงข้อมูลใหม่
            location.reload();
            },
            error: function(err) {
                console.error("Error inserting lesson", err);
            }
        });
    });
});


        $(document).ready(function(){
            // Handle click event for Delete Lesson button
            $(".delete-lesson-btn").click(function(){
                // Get the lesson ID from the data attribute
                var lessonId = $(this).data("lesson-id");

                // Confirm with the user before deleting the lesson
                if(confirm("Are you sure you want to delete this lesson?")){
                    // Send an AJAX request to the server to delete the lesson
                    $.ajax({
                        type: "POST",
                        url: "delete_lesson.php",
                        data: { lesson_id: lessonId },
                        success: function(data) {
                            // Reload the page to reflect the changes
                            location.reload();
                        },
                        error: function(err) {
                            // Log error message to the console
                            console.error("Error deleting lesson", err);
                        }
                    });
                }
            });
        });
        
</script>

