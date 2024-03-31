<?php
// เชื่อมต่อกับฐานข้อมูล
include('../connections/connection.php');

// คำสั่ง SQL เพื่อดึงจำนวนนักเรียนทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) AS total_students FROM students");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_students = $result['total_students'];
// คำสั่ง SQL เพื่อดึงจำนวนนักเรียนทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) AS total_teachers FROM teachers");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_teachers = $result['total_teachers'];
// คำสั่ง SQL เพื่อดึงจำนวนวิชาที่มี is_open = 1
$stmt = $db->prepare("SELECT COUNT(*) AS total_courses FROM courses WHERE is_open = 1");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_courses = $result['total_courses'];
$stmt = $db->prepare("SELECT COUNT(*) AS total_courses FROM courses WHERE is_open = 0");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_courses_close = $result['total_courses'];
$stmt = $db->prepare("SELECT COUNT(*) AS total_video FROM videos_embed ");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_video = $result['total_video'];
// คำสั่ง SQL เพื่อดึงจำนวนแบบทดสอบทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) as total_quizzes FROM quizzes");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_quizzes = $result['total_quizzes'];

// คำสั่ง SQL เพื่อดึงจำนวนแบบฝึกหัดทั้งหมด
$stmt = $db->prepare("SELECT COUNT(*) as total_exercises FROM assignments");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_exercises = $result['total_exercises'];
// คำสั่ง SQL เพื่อดึงจำนวนไฟล์ทั้งหมด
$stmt = $db->prepare("SELECT (SELECT COUNT(*) FROM files) +
                             (SELECT COUNT(*) FROM student_images) +
                             (SELECT COUNT(*) FROM teachers_images) +
                             (SELECT COUNT(*) FROM images) +
                             (SELECT COUNT(*) FROM submitted_assignments) AS total_files");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_files = $result['total_files'];
  // คำสั่ง SQL สำหรับดึงข้อมูลจำนวนผู้เรียนที่สำเร็จในแต่ละวิชาพร้อมกับชื่อวิชา
  $sql = "SELECT m.course_id, COUNT(*) AS total_marks_done, c.course_name 
          FROM marks_as_done AS m
          INNER JOIN courses AS c ON m.course_id = c.c_id
          GROUP BY m.course_id";
  $stmt = $db->prepare($sql);
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
$menu = "Dashboard";
include("header.php");
?>

<body id="page-top">

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-address-Dashboard"></i> Dashboard</h1>
    </div>
</section>
                <!-- Begin Page Content -->
                <div class="container mt-4">

                    <!-- Content Row -->
                    <div class="row">
                    <!--total students Card  -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            จำนวนนักเรียน</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_students; ?>  คน</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Total Teachers Card  -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ครูผู้สอนทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_teachers; ?>  คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    วิชาทังหมด (ที่เปิด)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_courses; ?>  วิชา</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        วิชาทังหมด (ที่ปิด)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_courses_close; ?>  วิชา</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        ไฟล์ทั้งหมด</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_files; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        วิดีโอทั้งหมด</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_video; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-video fa-2x text-gray-300"></i> <!-- แก้ไข icon ใหม่เป็น fa-video -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- แบบทดสอบทั้งหมด -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        แบบทดสอบทั้งหมด</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_quizzes; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-poll fa-2x text-gray-300"></i> <!-- ไอคอนแบบทดสอบ -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- แบบฝึกหัดทั้งหมด -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        แบบฝึกหัดทั้งหมด</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_exercises; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-tasks fa-2x text-gray-300"></i> <!-- ไอคอนแบบฝึกหัด -->
                </div>
            </div>
        </div>
    </div>
</div>

                    <!-- Content Row -->

                    <div class="row">
                                    <!-- Reports -->
            <div class="col-xl-8 col-lg-7">

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
                                      height: 450,
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



<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <!-- Learning Progress Report -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ความก้าวหน้าการเรียนรู้</h5>
            <div class="my-5" id="learningProgressChart" style="min-height: 360px;"></div>
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
                            fontSize: 18,
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: subjects.map((subject, index) => ({
                        name: subject,
                        value: parseFloat(percentages[index]).toFixed(2) // เปลี่ยนเป็นทศนิยม 2 ตำแหน่ง
                    }))
                }
            ]
        });
    });
</script>


                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- End of Page Wrapper -->
    <?php include('footer.php'); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/apexcharts/apexcharts.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/echarts/echarts.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>