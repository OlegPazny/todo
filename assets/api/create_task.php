<?php
session_start();
require_once './db_connect.php';

$stmt = $db->prepare("INSERT INTO `tasks` (`title`, `project_id`, `priority`, `deadline`, `assigned_by`, `description`)
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissss", $_POST['title'], $_POST['project_id'], $_POST['priority'], $_POST['deadline'], $_SESSION['name'], $_POST['description']);
if($stmt->execute()){
    echo json_encode(['success' => true]);
}else{
    echo json_encode(['success' => false]);
}


