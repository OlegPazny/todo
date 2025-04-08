<?php
require_once './db_connect.php';

$stmt = $db->prepare("INSERT INTO `tasks` (`title`, `project_id`, `status`, `priority`, `deadline`, `assigned_by`, `description`)
VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisssss", $_POST['title'], $_POST['project_id'], $_POST['status'], $_POST['priority'], $_POST['deadline'], $_POST['assigned_by'], $_POST['description']);
if($stmt->execute()){
    echo json_encode(['success' => true]);
}else{
    echo json_encode(['success' => false]);
}


