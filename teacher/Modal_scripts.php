<script>
    $(document).ready(function() {
  $('.modal').modal();
});
$(document).ready(function() {

// ฟังก์ชันสำหรับดึงข้อมูลคำถาม
function getQuestionData(questionId) {
  $.ajax({
    url: "getQuestionData.php",
    method: "POST",
    data: {
      question_id: questionId
    },
    success: function(data) {
      // แสดงข้อมูลคำถามใน Modal
      $("#updatedQuestionText").val(data.question_text);
      $("#updatedChoice1").val(data.choice_ch1);
      $("#updatedChoice2").val(data.choice_ch2);
      $("#updatedChoice3").val(data.choice_ch3);
      $("#updatedChoice4").val(data.choice_ch4);
      $("#updatedCorrectAnswer").val(data.correct_answer);
    }
  });
}

// โค้ดสำหรับเปิด Modal
$(".open-update-modal").click(function() {
  var questionId = $(this).data("question-id");
  getQuestionData(questionId);
});

});
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


    // Handle change event on video type select to toggle input fields
    $(document).on('change', '#video_type', function() {
        var selectedOption = $(this).val();
        $('#embed_input, #file_input').hide(); // Hide all input fields
        if (selectedOption === 'embed') {
            $('#embed_input').show(); // Show embed code input field
        } else if (selectedOption === 'file') {
            $('#file_input').show(); // Show file input field
        }
    });

    
</script>
  <script>
        $(document).ready(function(){
            // Initialize lessonCount
            var lessonCount = <?= count($lessons) ?>;

            // Handle form submission
            $("#saveLessonBtn").click(function(){
                var courseId = $("#courseId").val(); // Get the course ID from the hidden field
                var lessonName = $("#lessonName").val(); // Get the lesson name from the input field

                // Generate HTML for new accordion section with the lesson name
                var accordionSection = `
                    <section class="section">
                        <h5 class="card-title">${lessonName}</h5>
                        <div class="accordion" id="accordion${lessonCount}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading${lessonCount}">
                                    <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse${lessonCount}" aria-expanded="true" aria-controls="collapse${lessonCount}">
                                        ${lessonName}
                                    </button>
                                </h2>
                                <div id="collapse${lessonCount}" class="accordion-collapse collapse show" aria-labelledby="heading${lessonCount}" data-parent="#accordion${lessonCount}">
                                    <div class="accordion-body">
                                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addLessonModal">Add Topic</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                `;

                // Append the new accordion section to the accordion container
                $("#accordionContainer").append(accordionSection);

                // Increment the lesson count for unique IDs
                lessonCount++;

                // Reset the form and hide the modal
                $("#addLessonModal").modal("hide");
                $("#addLessonForm").trigger("reset");

                // Insert data into the database
                $.ajax({
                    type: "POST",
                    url: "insert_lesson.php",
                    data: { course_id: courseId, lesson_name: lessonName },
                    success: function(data) {
                        // Reload the lessons section to display the newly added lesson
                        $("#accordionContainer").load(location.href + " #accordionContainer>*", "");
                    },
                    error: function(err) {
                        // Log error message to the console
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

