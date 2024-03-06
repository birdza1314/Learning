<?php
// Include connection file
include('../connections/connection.php');

// Check if fileId is provided
if (!isset($_POST['fileId'])) {
    echo "File ID is missing.";
    exit();
}

$fileId = $_POST['fileId'];

// Fetch file details from the database
$stmt = $db->prepare("SELECT * FROM submitted_assignments WHERE id = :fileId");
$stmt->bindParam(':fileId', $fileId);
$stmt->execute();
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$file) {
    echo "File not found.";
    exit();
}

// Delete file from the database
$stmt_delete = $db->prepare("DELETE FROM submitted_assignments WHERE id = :fileId");
$stmt_delete->bindParam(':fileId', $fileId);
$stmt_delete->execute();

// Delete the file from the server
$filePath = $file['submitted_file'];
if (file_exists($filePath)) {
    unlink($filePath); // Delete the file
}
echo "<script>window.history.back();</script>";
echo "File deleted successfully.";
?>
