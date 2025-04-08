<?php
require_once './db_connect.php';

$sql = "SELECT t.*, p.name as project_name 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id";
$result = $db->query($sql);
$tasks = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($tasks);
