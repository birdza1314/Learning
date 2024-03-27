<?php
  include('../connections/connection.php');

  // ตรวจสอบว่ามีการล็อกอินและมีบทบาทเป็น 'teacher' หรือไม่
  session_start();
  if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
      // ถ้าไม่ได้ล็อกอินหรือบทบาทไม่ใช่ 'teacher' ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอินหรือหน้าที่คุณต้องการ
      header('Location: login.php'); 
      exit();
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
  try {
   // คำสั่ง SQL เพื่อดึงจำนวนรายวิชาทั้งหมดที่เป็นของ teacher_id ที่ระบุ
  $stmt = $db->prepare("SELECT COUNT(*) as total_courses FROM courses WHERE teacher_id = :teacher_id");
  $stmt->bindParam(':teacher_id', $teacher_id); // ตัวแปร $teacher_id คือ teacher_id ที่ต้องการดึงข้อมูล
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_courses = $result['total_courses'];

  // คำสั่ง SQL เพื่อดึงจำนวนแบบทดสอบทั้งหมดที่เป็นของ teacher_id ที่อ้างอิงคีย์รองจากตาราง courses
  $stmt = $db->prepare("SELECT COUNT(q.quiz_id) AS total_quizzes 
                        FROM quizzes q
                        INNER JOIN courses c ON q.c_id = c.c_id
                        WHERE c.teacher_id = :teacher_id");
  $stmt->bindParam(':teacher_id', $teacher_id); // ตัวแปร $teacher_id คือ teacher_id ที่ต้องการดึงข้อมูล
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_quizzes = $result['total_quizzes'];


 // คำสั่ง SQL เพื่อดึงจำนวนแบบฝึกหัดทั้งหมดที่เป็นของ teacher_id ที่อ้างอิงคีย์รองจากตาราง courses
$stmt = $db->prepare("SELECT COUNT(a.assignment_id) AS total_exercises 
FROM assignments a
INNER JOIN courses c ON a.course_id = c.c_id
WHERE c.teacher_id = :teacher_id");
$stmt->bindParam(':teacher_id', $teacher_id); // ตัวแปร $teacher_id คือ teacher_id ที่ต้องการดึงข้อมูล
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_exercises = $result['total_exercises'];


  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
    // คำสั่ง SQL สำหรับดึงข้อมูลจำนวนผู้เรียนที่สำเร็จในแต่ละวิชาพร้อมกับชื่อวิชา
  $sql = "SELECT m.course_id, COUNT(*) AS total_marks_done, c.course_name 
  FROM marks_as_done AS m
  INNER JOIN courses AS c ON m.course_id = c.c_id
  WHERE c.teacher_id = :teacher_id
  GROUP BY m.course_id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':teacher_id', $teacher_id); // ตัวแปร $teacher_id คือ teacher_id ที่ต้องการตรวจสอบ
$stmt->execute();
$marks_data = $stmt->fetchAll(PDO::FETCH_ASSOC);


  // สร้างตัวแปรเก็บข้อมูล
  $subjects = [];
  $marks_count = [];

  // วนลูปเพื่อดึงข้อมูลแต่ละแถว
  foreach ($marks_data as $data) {
      $course_name = $data['course_name'];
      $total_marks_done = $data['total_marks_done'];
      
      // เพิ่มข้อมูลลงในตัวแปรที่เก็บ
      $subjects[] = $course_name;
      $marks_count[] = $total_marks_done;
  }

  // คำนวณเปอร์เซ็นต์แต่ละวิชา
  $total_marks = array_sum($marks_count);
  $percentage = [];
  foreach ($marks_count as $count) {
      $percentage[] = ($count / $total_marks) * 100;
  }

  // แปลงข้อมูลเป็นรูปแบบ JSON
  $subjects_json = json_encode($subjects);
  $percentage_json = json_encode($percentage);
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

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>      
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Course Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                  <div class="card-body">
                    <h5 class="card-title">รายวิชาทั้งหมด</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?php echo $total_courses; ?> วิชา</h6>
                          
                          </div>
                      </div>
                  </div>
                </div>
            </div><!-- End course Card -->

            <!-- quiz Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">จำนวนแบบทดสอบ</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-journal-code"></i>
                    </div>
                    <div class="ps-3">
                    <h3><?php echo $total_quizzes; ?></h3>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End quiz Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">จำนวนแบบฝึกหัด</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-journal-plus"></i>
                    </div>
                    <div class="ps-3">
                    <h3><?php echo $total_exercises; ?></h3>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

          <!-- Reports -->
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">วิชาที่มีการเข้าเรียนมากที่สุด </h5>

                      <!-- Bar Chart -->
                      <div id="reportsChart"></div>

                      <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              new ApexCharts(document.querySelector("#reportsChart"), {
                                  series: [{
                                      name: 'เปอร์เซ็นต์ของการเรียน',
                                      data: <?php echo $percentage_json; ?>,
                                  }],
                                  chart: {
                                      height: 350,
                                      type: 'bar',
                                      toolbar: {
                                          show: false
                                      },
                                  },
                                  plotOptions: {
                                      bar: {
                                          horizontal: false,
                                          columnWidth: '55%',
                                          endingShape: 'rounded'
                                      },
                                  },
                                  dataLabels: {
                                      enabled: false
                                  },
                                  stroke: {
                                      show: true,
                                      width: 2,
                                      colors: ['transparent']
                                  },
                                  colors: ['#2eca6a'],
                                  xaxis: {
                                      categories: <?php echo $subjects_json; ?>,
                                  },
                                  yaxis: {
                                      title: {
                                          text: 'เปอร์เซ็นต์ของการเรียน',
                                          style: {
                                              fontSize: '14px'
                                          }
                                      }
                                  },
                                  fill: {
                                      opacity: 1
                                  },
                                  tooltip: {
                                      y: {
                                          formatter: function(val) {
                                              return val.toFixed(2) + '%';
                                          }
                                      }
                                  }
                              }).render();
                          });
                      </script>
                      <!-- End Bar Chart -->

                  </div>
              </div>
          </div><!-- End Reports -->
          </div>
        </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">

      <!-- Customers Card -->
      <div class="">
          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">จำนวนแบบฝึกหัด</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-journal-plus"></i>
                </div>
                <div class="ps-3">
                <h3><?php echo $total_exercises; ?></h3>
                </div>
              </div>

            </div>
          </div>

      </div><!-- End Customers Card -->

      <!-- Learning Progress Report -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">ความก้าวหน้าการเรียนรู้</h5>
          <div id="learningProgressChart" style="min-height: 360px;"></div>
        </div>
      </div><!-- End Learning Progress Report -->


    </div><!-- End Right side columns -->

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        // ข้อมูลแสดงการเรียนรู้ของแต่ละวิชา (เปอร์เซ็นต์)
        const subjects = <?php echo $subjects_json; ?>;
        const percentages = <?php echo $percentage_json; ?>;

        // สร้างกราฟวงกลมแสดงการเรียนรู้ของแต่ละวิชา
        const learningProgressChart = echarts.init(document.querySelector("#learningProgressChart"));
        learningProgressChart.setOption({
          tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b}: {c}%'
          },
          legend: {
            orient: 'vertical',
            left: 10,
            data: subjects
          },
          series: [
            {
              name: 'ความก้าวหน้าการเรียนรู้',
              type: 'pie',
              radius: ['50%', '70%'],
              avoidLabelOverlap: false,
              label: {
                show: false,
                position: 'center'
              },
              emphasis: {
                label: {
                  show: true,
                  fontSize: '18',
                  fontWeight: 'bold'
                }
              },
              labelLine: {
                show: false
              },
              data: subjects.map((subject, index) => ({
                name: subject,
                value: percentages[index].toFixed(2) // เปลี่ยนเป็นทศนิยม 2 ตำแหน่ง
              }))
            }
          ]
        });
      });
    </script>
    

      </div>
   </section>
   </main><!-- End #main -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- ======= Footer ======= -->
<?php include('footer.php');?>
 <!-- ======= scripts ======= -->
<?php include('scripts.php');?>


</body>
</html>
