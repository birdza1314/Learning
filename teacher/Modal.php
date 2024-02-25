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
                                <label>Quiz Time Limit</label>
                                <select class="form-control" name="timeLimit" required="">
                                <option value="0">Select time</option>
                                <option value="10">10 Minutes</option> 
                                <option value="20">20 Minutes</option> 
                                <option value="30">30 Minutes</option> 
                                <option value="40">40 Minutes</option> 
                                <option value="50">50 Minutes</option> 
                                <option value="60">60 Minutes</option> 
                                </select>
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
    <!----Add Video---->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="videoModalLabel">Add Quiz</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="save_video.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="lesson_id" id="lesson_id" value="<?php echo $lesson['lesson_id']; ?>">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <div class="col-md-12">
                        <div class="form-group">
                        <label for="video_type" >Select video type:</label>
                        <select name="video_type" id="video_type" class="form-control">
                            <option selected> select video type</option>
                            <option value="embed">Embed Code</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                    <div class="form-group" id="embed_input" style="display:none;">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="2" cols="50" class="form-control"></textarea>
                        <label for="embed_code">Embed Code:</label>
                        <textarea name="embed_code" id="embed_code" rows="4" cols="50" class="form-control"></textarea>
                    </div>
                    <div class="form-group" id="file_input" style="display:none;">
                        <label for="description_file">Description:</label>
                        <textarea name="description_file" id="description_file" rows="2" cols="50" class="form-control"></textarea>
                        <label for="video_file">Choose Video File:</label>
                        <input type="file" name="video_file" id="video_file" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Upload Video" class="btn btn-primary">
                    </div>
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
                <h5 class="modal-title" id="modalForAddQuestionLabel">Add New Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="save_question.php" method="post">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                    <div class="form-group">
                        <label for="questionText">Question Text</label>
                        <textarea class="form-control" id="questionText" name="questionText" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="choice1">Choice 1</label>
                        <input type="text" class="form-control" id="choice1" name="choice1" required>
                    </div>
                    <div class="form-group">
                        <label for="choice2">Choice 2</label>
                        <input type="text" class="form-control" id="choice2" name="choice2" required>
                    </div>
                    <div class="form-group">
                        <label for="choice3">Choice 3</label>
                        <input type="text" class="form-control" id="choice3" name="choice3" required>
                    </div>
                    <div class="form-group">
                        <label for="choice4">Choice 4</label>
                        <input type="text" class="form-control" id="choice4" name="choice4" required>
                    </div>
                    <div class="form-group">
                        <label for="correctAnswer">Correct Answer (Choice)</label>
                        <input type="text" class="form-control" id="correctAnswer" name="correctAnswer" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal update Question -->
<div class="modal fade" id="updateQuestionModal<?php echo isset($selQuestionRow['question_id']) ? $selQuestionRow['question_id'] : ''; ?>" aria-labelledby="updateQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateQuestionModalLabel">Update Question</h5>
                <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="update_Question.php" method="POST">
                    <input type="hidden" name="question_id" value="<?php echo isset($selQuestionRow['question_id']) ? $selQuestionRow['question_id'] : ''; ?>">
                    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                    <div class="form-group">
                        <label for="updatedQuestionText">Question Text</label>
                        <textarea class="form-control" id="updatedQuestionText" name="updatedQuestionText"><?php echo isset($selQuestionRow['question_text']) ? $selQuestionRow['question_text'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="updatedChoice1">Choice 1</label>
                        <input type="text" class="form-control" id="updatedChoice1" name="updatedChoice1" value="<?php echo isset($selQuestionRow['choice_ch1']) ? $selQuestionRow['choice_ch1'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="updatedChoice2">Choice 2</label>
                        <input type="text" class="form-control" id="updatedChoice2" name="updatedChoice2" value="<?php echo isset($selQuestionRow['choice_ch2']) ? $selQuestionRow['choice_ch2'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="updatedChoice3">Choice 3</label>
                        <input type="text" class="form-control" id="updatedChoice3" name="updatedChoice3" value="<?php echo isset($selQuestionRow['choice_ch3']) ? $selQuestionRow['choice_ch3'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="updatedChoice4">Choice 4</label>
                        <input type="text" class="form-control" id="updatedChoice4" name="updatedChoice4" value="<?php echo isset($selQuestionRow['choice_ch4']) ? $selQuestionRow['choice_ch4'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="updatedCorrectAnswer">Correct Answer</label>
                        <input type="text" class="form-control" id="updatedCorrectAnswer" name="updatedCorrectAnswer" value="<?php echo isset($selQuestionRow['correct_answer']) ? $selQuestionRow['correct_answer'] : ''; ?>">
                            
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal()" >Close</button>
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
