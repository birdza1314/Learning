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
                                                ?>
                                                <div class="mt-5">
                                                    <p><strong></strong><?= $topic['topic_type']; ?></p>
                                                    <?php
                                                // ตรวจสอบว่ามี video_embed_id หรือ video_file_id
                                                if ($topic['video_embed_id'] != null) {
                                                    // กรณีมี video_embed_id แสดงว่าเป็นวิดีโอจาก embed code
                                                    // ดึงข้อมูลจากตาราง videos_embed
                                                    $stmt_embed = $db->prepare("SELECT * FROM videos_embed WHERE video_embed_id = :video_embed_id");
                                                    $stmt_embed->bindParam(':video_embed_id', $topic['video_embed_id']);
                                                    $stmt_embed->execute();
                                                    $video_embed = $stmt_embed->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <div class="mt-5 text-center embed-responsive embed-responsive-16by9">
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
                                                
                                                    // เพิ่มเงื่อนไขเช็คสถานะของแบบทดสอบ
                                                    if ($quiz['status'] == 'เปิดใช้งาน') {
                                                        // แสดงแบบทดสอบเฉพาะเมื่อสถานะเป็น "เปิดใช้งาน"
                                                ?>
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
                                                                            <button type="button" class="btn btn-outline-primary me-2 " onclick="editQuiz(<?= $quiz['quiz_id']; ?>)">
                                                                                <i class="bi bi-pencil-square"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    } // ปิดเงื่อนไขตรวจสอบสถานะของแบบทดสอบ 
                                                }elseif ($topic['assignment_id'] != null) {
                                                    $stmt_assignment = $db->prepare("SELECT * FROM assignments WHERE assignment_id = :assignment_id");
                                                    $stmt_assignment->bindParam(':assignment_id', $topic['assignment_id']);
                                                    $stmt_assignment->execute();
                                                    $assignment = $stmt_assignment->fetch(PDO::FETCH_ASSOC);
                                                
                                                    // เช็คเวลา
                                                    $currentDateTime = date('Y-m-d H:i:s');
                                                    $endDateTime = $assignment['deadline'];
                                                    $isOverdue = ($currentDateTime > $endDateTime) ? true : false;
                                                
                                                    // สร้างตัวแปรสีของการ์ด
                                                    $cardColor = ($isOverdue) ? 'text-danger' : '';
                                                
                                                    // แสดงวันที่และเวลาเริ่มและสิ้นสุดการส่งงาน
                                                    $startDateTime = date('d/m/Y H:i', strtotime($assignment['open_time']));
                                                    $endDateTime = date('d/m/Y H:i', strtotime($assignment['close_time']));
                                                
                                                    if ($assignment['status'] == 'open') {
                                                ?>
                                                <div class="col-lg-12">
                                                    <div class="card border rounded-3 shadow-sm  <?= $cardColor ?>">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex mt-4">
                                                                        <i class="bi bi-file-earmark-text-fill text-primary me-2"></i>
                                                                        <h5><?= $assignment['title']; ?></h5>
                                                                    </div>
                                                                    <?php if ($isOverdue) : ?>
                                                                        <p class="text-danger">สิ้นสุด: <?= $endDateTime ?> (เกินเวลา)</p>
                                                                    <?php else : ?>
                                                                        <p>เริ่ม: <?= $startDateTime ?></p>
                                                                        <p>สิ้นสุด: <?= $endDateTime ?></p>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="d-flex justify-content-end mt-3">
                                                                    <?php if ($isOverdue) : ?>
                                                                        <a href="status_assignment?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-danger ">ส่งงาน</a>
                                                                    <?php else : ?>
                                                                        <a href="status_assignment?assignment_id=<?= $assignment['assignment_id']; ?>" class="btn btn-outline-primary ">ส่งงาน</a>
                                                                    <?php endif; ?>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    } 
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