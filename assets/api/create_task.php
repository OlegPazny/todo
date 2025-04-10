<?php
session_start();
require_once './db_connect.php';

$formatted_description=nl2br(htmlspecialchars($_POST['description']));
$deadline = empty($_POST['deadline']) ? null : $_POST['deadline'];
  
$stmt = $db->prepare("INSERT INTO `tasks` (`title`, `project_id`, `priority`, `deadline`, `assigned_by`, `description`)
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissss", $_POST['title'], $_POST['project_id'], $_POST['priority'], $deadline, $_SESSION['name'], $formatted_description);
if($stmt->execute()){
    echo json_encode(['success' => true]);
}else{
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}


