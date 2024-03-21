<?php foreach($lessons as $lesson): ?>
                    <section class="section card mb-3 mt-5">
                        <div class="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex align-items-center">
                                    <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse<?= $lesson['lesson_id']; ?>" aria-expanded="true" aria-controls="collapse<?= $lesson['lesson_id']; ?>">
                                        <?= $lesson['lesson_name']; ?>
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
                                            <?php }elseif ($topic['file_id'] != null) {
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
                                                                <button type="button" class="btn btn-danger ms-auto" onclick="deletefile(<?= $file['file_id']; ?>)"><i class="bi bi-trash3"></i></button>
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
                                                        <div class="col-md-4 ">
                                                        <div class="d-flex justify-content-end mt-3 ">
                                                            <button type="button" class="btn btn-outline-info me-2 " onclick="viewQuizResults(<?= $quiz['quiz_id']; ?>)">
                                                                ผลการสอบ
                                                            </button>
                                                            <button type="button" class="btn btn-outline-primary me-2 " onclick="editQuiz(<?= $quiz['quiz_id']; ?>)">
                                                            <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger" onclick="deleteQuiz(<?= $quiz['quiz_id']; ?>)">
                                                            <i class="bi bi-trash3"></i>
                                                            </button>
                                                           
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
                                            
                                                // ตรวจสอบว่าเวลาปัจจุบันเกินเวลาที่กำหนดหรือไม่
                                                $now = time(); // เวลาปัจจุบันในรูปแบบ timestamp
                                                $deadline = strtotime($assignment['deadline']); // เวลาสิ้นสุดของการส่งงานในรูปแบบ timestamp
                                            
                                                // เช็คว่าเวลาปัจจุบันเกินเวลาส่งงานหรือไม่
                                                if ($now > $deadline) {
                                                    // ถ้าเกินเวลาส่งงานแล้ว ให้เพิ่มคลาส 'text-danger' เพื่อแสดงสีแดง
                                                    $cardClass = 'card border rounded-3 shadow-sm hover-effect text-hover-white text-danger';
                                                } else {
                                                    // ถ้ายังไม่เกินเวลาส่งงาน ให้ใช้คลาสเดิม
                                                    $cardClass = 'card border rounded-3 shadow-sm hover-effect text-hover-white';
                                                }
                                                ?>
                                                <div class="col-lg-12">
                                                    <div class="<?= $cardClass; ?>">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex mt-4">
                                                                        <i class="bi bi-file-earmark-text-fill text-primary me-2"></i>
                                                                        <h5><?= $assignment['title']; ?></h5>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="d-flex justify-content-end mt-3">
                                                                        <a href="check_assignment.php?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-success me-2">
                                                                            <i class="bi bi-check-square"></i> ตรวจสอบงาน
                                                                        </a>
                                                                        <a href="edit_assignment.php?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-primary me-2">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-outline-danger" onclick="deleteAssignment(<?= $assignment['assignment_id']; ?>)">
                                                                            <i class="bi bi-trash3"></i>
                                                                        </button>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            }
                                            elseif ($topic['url_id'] != null) {
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
                                        <div class="dropdown dropdown-mega mt-5 position-static dropdown-center" >
                                            <button  class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                เพิ่มกิจกรรม
                                            </button>
                                            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                                                <li class="mega-content px-4">
                                                <div class="container">
                                                    
                                                    <div class="row mt-3">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-Quiz-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>Quiz
                                                            </button>
                                                            <a href="Add_assignment.php?lesson_id=<?php echo $lesson['lesson_id']; ?>&course_id=<?php echo $course_id; ?>" role="button" class="btn btn-outline-success btn-block mx-2">
                                                                <i class="bi bi-journal-arrow-up text-success"></i><br>
                                                                Assignment
                                                            </a>
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-image-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>Image
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-file-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo isset($_POST['course_id']) ? $_POST['course_id'] : ''; ?>">
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>File
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <h4 class="card-title">Video</h4>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-Embed-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>" >
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>Video Embed
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-File-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>Video File
                                                            </button>
                                                            
                                                            <button type="button" class="btn btn-outline-info btn-block mx-2 open-URL-modal" data-lesson-id="<?php echo $lesson['lesson_id']; ?>" data-course-id="<?php echo $course_id; ?>">
                                                                <i class="bi bi-journal-arrow-up text-info"></i><br>URL
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