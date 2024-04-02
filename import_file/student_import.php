<?php
session_start();
include('../connections/connection.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            if ($count > 0) {
                $username = $row[0];
                $rawPassword = $row[1]; // Assuming the password is in column 1 of the spreadsheet
                $password = password_hash($rawPassword, PASSWORD_DEFAULT);
                $first_name = $row[2];
                $last_name = $row[3];
                $classroom = $row[4];
                $year = $row[5];
                

                $sql = "INSERT INTO students (username, password, first_name, last_name,  classroom,year) VALUES (:username, :password, :first_name, :last_name,  :classroom, :year)";
                $stmt = $db->prepare($sql);
                $stmt->execute([':username' => $username, ':password' => $password, ':first_name' => $first_name, ':last_name' => $last_name,  ':classroom' => $classroom, ':year' => $year]);

            } else {
                $count++;
            }
        }

        $_SESSION['message'] = "Successfully Imported";

        // Adding JavaScript code to show alert
        echo '<script type="text/javascript">';
        echo 'alert("Successfully Imported");';
        echo 'window.location.href = "../admin/student_data.php";';  // Redirect after showing the alert
        echo '</script>';

        exit(0);
    } else {
        $_SESSION['message'] = "Invalid File";
        header('Location: ../admin/student_data.php');
        exit(0);
    }
}
?>
