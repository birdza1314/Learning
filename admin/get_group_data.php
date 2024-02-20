<?php
include('../connections/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupId'])) {
    $groupId = $_POST['groupId'];

    $stmt = $db->prepare("SELECT group_name FROM learning_subject_group WHERE group_id = :group_id");
    $stmt->bindParam(':group_id', $groupId);
    $stmt->execute();

    $groupData = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($groupData);
} else {
    header('HTTP/1.1 400 Bad Request');
}
?>
