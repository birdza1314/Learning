<!-- Modal add file -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileModalLabel">เพิ่มไฟล์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- ที่นี่คุณสามารถเพิ่มฟอร์มสำหรับอัปโหลดไฟล์ได้ -->
        <form action="save_file.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <input type="hidden" name="lesson_id" id="lesson_id" value="<?php echo $lesson['lesson_id']; ?>">
          <div class="mb-3">
            <label for="file" class="form-label">เลือกไฟล์</label>
            <input type="file" class="form-control" id="file" name="file">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">คำอธิบาย</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">อัปโหลด</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal add Images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_img.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" id="image_course_id" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="lesson_id" id="image_lesson_id" value="">
                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image:</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal add Quiz -->
    <div class="modal fade" id="QuizModal" tabindex="-1" aria-labelledby="QuizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="QuizModalLabel">Add Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save_Quiz.php" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="course_id" id="quiz_course_id" value="<?php echo $course_id; ?>">
                        <input type="hidden" name="lesson_id" id="quiz_lesson_id" value="">
                        
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="timeLimit">Quiz Time Limit</label>
                            <input type="number" class="form-control" id="timeLimit" name="timeLimit" min="0" placeholder="Enter time in minutes" required>
                        </div>
                            <div class="form-group">
                                <label>Question Limit to Display</label>
                                <input type="number" name="QuestDipLimit" id="" class="form-control" placeholder="Input question limit to display">
                            </div>

                            <div class="form-group">
                                <label>Quiz Title</label>
                                <input type="text" name="Quiz_Title" class="form-control" placeholder="Input Quiz Title" required="">
                            </div>

                            <div class="form-group">
                                <label>Quiz Description</label>
                                <textarea name="QuizDesc" class="form-control" rows="4" placeholder="Input Quiz Description"></textarea>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Quiz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
  <!-- Modal Add Lessons -->
<div class="modal fade" id="addLessonModal" tabindex="-1" role="dialog" aria-labelledby="addLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonModalLabel">เพิ่มบทเรียน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addLessonForm">
                    <div class="form-group">
                        <label for="lessonName">ชื่อบทเรียน:</label>
                        <input type="text" class="form-control" id="lessonName" name="lesson_name" placeholder="กรุณาใส่ชื่อบทเรียน">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="saveLessonBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>

 <!-- Modal Add Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" aria-labelledby="modalForAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalForAddQuestionLabel">เพิ่มคำถามใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="save_question.php" method="post">
                    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                    <div class="form-group">
                        <label for="questionText">คำถาม</label>
                        <textarea class="form-control" id="questionText" name="questionText" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="choice1">ตัวเลือก 1</label>
                        <input type="text" class="form-control choice-input" id="choice1" name="choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="choice2">ตัวเลือก 2</label>
                        <input type="text" class="form-control choice-input" id="choice2" name="choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="choice3">ตัวเลือก 3</label>
                        <input type="text" class="form-control choice-input" id="choice3" name="choice3" required>
                    </div>
                    <div class="form-group">
                        <label for="choice4">ตัวเลือก 4</label>
                        <input type="text" class="form-control choice-input" id="choice4" name="choice4" required>
                    </div>
                    <div class="form-group">
                        <label for="correctAnswerSelect">คำตอบที่ถูกต้อง (ตัวเลือก)</label>
                        <select class="form-control" id="correctAnswerSelect" name="correctAnswerSelect"  onchange="updateCorrectAnswer(this)" required>
                            <option selected>เลือกตัวเลือก</option>
                            <option value="choice1">ตัวเลือก 1</option>
                            <option value="choice2">ตัวเลือก 2</option>
                            <option value="choice3">ตัวเลือก 3</option>
                            <option value="choice4">ตัวเลือก 4</option>
                        </select>
                        <input type="hidden" id="correctAnswer" name="correctAnswer" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="choice4">รายละเอียด</label>
                        <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ส่งคำตอบ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateCorrectAnswer(selectElement) {
        var selectedChoice = selectElement.value;
        var choiceInputElement = document.querySelector('.choice-input[name="' + selectedChoice + '"]');
        var choiceValue = choiceInputElement.value;
        document.getElementById('correctAnswer').value = choiceValue;
    }
</script>

<!-- Modal embed Modal -->
<div class="modal fade" id="embedModal" tabindex="-1" aria-labelledby="embedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="embedModalLabel">Add Video Embed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_embed_video.php" method="post">
                    <input type="hidden" name="lesson_id" id="embed_lesson_id" value="">
                    <input type="hidden" name="course_id" id="embed_course_id" value="">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="2" cols="50" class="form-control"></textarea>
                        <label for="embed_code">Embed Code:</label>
                        <textarea name="embed_code" id="embed_code" rows="4" cols="50" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save Embed Video" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal add Images -->
<div class="modal fade" id="videoFileModal" tabindex="-1" aria-labelledby="videoFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoFileModalLabel">Upload Video File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_file_video.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" id="image_course_id" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="lesson_id" id="image_lesson_id" value="">
                    <div class="form-group">
                        <label for="description_file">Description:</label>
                        <textarea name="description_file" id="description_file" rows="2" cols="50" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="video_file">Choose Video File:</label>
                        <input type="file" name="video_file" id="video_file" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload File</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- URL Modal -->
<div class="modal fade" id="urlModal" tabindex="-1" aria-labelledby="urlModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="urlModalLabel">Upload URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_url.php" method="post">
                    <input type="hidden" name="course_id" id="url_course_id" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="lesson_id" id="url_lesson_id" value="">
                    <div class="form-group">
                        <label for="url_description">Description:</label>
                        <textarea name="url_description" id="url_description" rows="2" cols="50" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="url">URL:</label>
                        <input type="text" name="url" id="url" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        // เลือก Modal และใช้ jQuery เพื่อปิด Modal
        $('#updateQuestionModal').modal('hide');
    }
</script>
