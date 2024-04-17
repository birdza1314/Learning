<?php
session_start();
include('../connections/connection.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPSTORM_META\sql_injection_subst;

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

                // Check if it's a new academic year
                $current_year = date('Y');
                $current_month = date('n');
                $old_year = $year;

                if ($current_month >= 3) {
                    $academic_year = $current_year + 543; // Convert to Buddhist calendar
                } else {
                    $academic_year = $current_year + 542; // Convert to Buddhist calendar
                }

                $diff = $academic_year - $year;

                // Calculate the student's level using the difference between academic year and the student's year
                $level = $classes + $diff;

                // If the level is greater than 6, set it to "Graduated"
                if ($level > 6) {
                    $level = "Graduated";
                }

                // Insert the new student data into the database
                $sql_insert = "INSERT INTO students (username, password, first_name, last_name, classes, classroom, year) 
                        VALUES (:username, :password, :first_name, :last_name, :classes, :classroom, :year)";
                $stmt_insert = $db->prepare($sql_insert);
                $stmt_insert->execute([
                    ':username' => $username,
                    ':password' => $password,
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':classes' => $level,
                    ':classroom' => $classroom,
                    ':year' => $year
                ]);       
           
            } else {
                $count++;
            }
        }

        $_SESSION['message'] = "เพิ่มข้อมูลสำเร็จ";

        // Redirect to the student_data page after adding the data and showing the alert
        echo '<script type="text/javascript">';
        echo 'alert("เพิ่มข้อมูลสำเร็จ");';
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
