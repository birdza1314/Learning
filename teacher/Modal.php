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
            <label for="file" class="form-label">เลือกไฟล์ <span style="color: red;">*</span></label>
            <input type="file" class="form-control" id="file" name="file" required>
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
                <h5 class="modal-title" id="imageModalLabel">เพิ่มรูปภาพ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_img.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" id="image_course_id" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="lesson_id" id="image_lesson_id" value="">
                    <div class="mb-3">
                        <label for="image" class="form-label">เลือกรูแภาพ:<span style="color: red;">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึกรูปภาพ</button>
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
                    <h5 class="modal-title" id="QuizModalLabel">เพิ่มแบบทดสอบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save_Quiz.php" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="course_id" id="quiz_course_id" value="<?php echo $course_id; ?>">
                        <input type="hidden" name="lesson_id" id="quiz_lesson_id" value="">
                        
                        <div class="col-md-12">
                        <div class="form-group">
                                <label>หัวข้อเรื่อง<span style="color: red;">*</span></label>
                                <input type="text" name="Quiz_Title" class="form-control" placeholder="Input Quiz Title" required="">
                            </div>
                        <div class="form-group">
                            <label for="timeLimit">เวลาทำแบบทดสอบ (นาที)<span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="timeLimit" name="timeLimit" min="0" placeholder="Enter time in minutes" required>
                        </div>
                            <div class="form-group">
                                <label>จำนวนข้อสอบ<span style="color: red;">*</span></label>
                                <input type="number" name="QuestDipLimit" id="" class="form-control" placeholder="Input question limit to display" required>
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                <textarea name="QuizDesc" class="form-control" rows="4" placeholder="Input Quiz Description"></textarea>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary ">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Add Lessons -->
<div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="addLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonModalLabel">เพิ่มบทเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-primary" id="saveLessonBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Lessons Type -->
<div class="modal fade" id="addLessontypeModal" tabindex="-1" aria-labelledby="addLessontypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessontypeModalLabel">เพิ่มบทเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLessonForm">
                <div class="row mb-3">
                <label for="group_id" class="col-sm-2 col-form-label">กลุ่ม<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <!-- ใช้ select element เพื่อให้เลือกกลุ่ม -->
                    <select class="form-select" id="group_id" name="group_id">
                        <!-- ตรวจสอบและแสดงตัวเลือกจากข้อมูลที่มีอยู่ในฐานข้อมูล -->
                        <?php
                        $stmt = $db->query("SELECT * FROM add_topic");
                        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($groups as $group) {
                            echo "<option value='{$group['topic_id']}'>{$group['topic_type']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveLessonBtn">บันทึก</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal embed Modal -->
<div class="modal fade" id="embedModal" tabindex="-1" aria-labelledby="embedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="embedModalLabel">เพิ่มวิดีโอแบบฝัง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_embed_video.php" method="post">
                    <input type="hidden" name="lesson_id" id="embed_lesson_id" value="">
                    <input type="hidden" name="course_id" id="embed_course_id" value="">
                    <div class="form-group">
                        <label for="description">รายละเอียด:</label>
                        <textarea name="description" id="description" rows="2" cols="50" class="form-control"></textarea>
                        <label for="embed_code">ฝังโค้ด:<span style="color: red;">*</span></label>
                        <textarea name="embed_code" id="embed_code" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save Embed Video" class="btn btn-primary">
                    </div>
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
                <h5 class="modal-title" id="urlModalLabel">เพิ่ม URL วิดีโอ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_url.php" method="post">
                    <input type="hidden" name="course_id" id="url_course_id" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="lesson_id" id="url_lesson_id" value="">
                    <div class="form-group">
                        <label for="url_description">รายละเอียด:</label>
                        <textarea name="url_description" id="url_description" rows="2" cols="50" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="url">URL:<span style="color: red;">*</span></label>
                        <input type="text" name="url" id="url" class="form-control" required>
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
