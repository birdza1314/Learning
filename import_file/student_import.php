<?php
session_start();
include('../connections/connection.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPSTORM_META\sql_injection_subst;

// โค้ดจากการอัปโหลดไฟล์ Excel และเพิ่มข้อมูลนักเรียน
if (isset($_POST['save_excel_data'])) {
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = 0;
        foreach ($data as $row) {
            if ($count > 0 && !empty($row[0])) {
                $username = $row[0];
                $rawPassword = $row[1]; // Assuming the password is in column 1 of the spreadsheet
                $password = password_hash($rawPassword, PASSWORD_DEFAULT);
                $first_name = $row[2];
                $last_name = $row[3];
                $classes = $row[4];
                $classroom = $row[5];
                $year = $row[6];

                // Insert the new student data into the database
                $sql_insert = "INSERT INTO students (username, password, first_name, last_name, classes, classroom, year) 
                        VALUES (:username, :password, :first_name, :last_name, :classes, :classroom, :year)";
                $stmt_insert = $db->prepare($sql_insert);
                $stmt_insert->execute([
                    ':username' => $username,
                    ':password' => $password,
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':classes' => $classes,
                    ':classroom' => $classroom,
                    ':year' => $year
                ]);       

                // Update classes only if it's not equal to 4
                if ($classes != 4) {
                    // Get the maximum year from the students table
                    $sql = "SELECT MAX(year) AS max_year FROM students";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $max_year_row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $max_year = $max_year_row["max_year"];

                    // Loop through the years
                    for($i = $max_year; $i >= $max_year - 100; $i--){
                        // Update the class level for students based on the year
                        if($i > $max_year - 6 && $i <= $max_year && $max_year != 4 ){
                            // Update the class level for students within the last 6 years
                            $update_sql = "UPDATE students SET classes = :class_level WHERE year = :year";
                            $update_stmt = $db->prepare($update_sql);
                            $update_stmt->bindValue(':class_level', $max_year - $i + 1); // Calculate the class level based on the difference from the maximum year
                            $update_stmt->bindValue(':year', $i);
                            $update_stmt->execute();
                        } else {
                            // Set the class level to 'จบการศึกษา' for years beyond 6 years ago
                            $update_sql = "UPDATE students SET classes = 'จบการศึกษา' WHERE year = :year";
                            $update_stmt = $db->prepare($update_sql);
                            $update_stmt->bindValue(':year', $i);
                            $update_stmt->execute();
                        }
                    }
                }
            } else {
                $count++;
            }
        }

        $_SESSION['message'] = "เพิ่มข้อมูลสำเร็จ";

        // Redirect to the student_data page after adding the data and showing the alert
        echo '<script type="text/javascript">';
        echo 'alert("เพิ่มข้อมูและอัปเดตระดับชั้นเรียบร้อยแล้ว");';
        echo 'window.location.href = "../admin/student_data";';  
        echo '</script>';

        exit(0);
    } else {
        $_SESSION['message'] = "Invalid File";
        header('Location: ../admin/student_data');
        exit(0);
    }
}
?>
