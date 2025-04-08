<?php
require_once './db_connect.php';

$sql = "SELECT * FROM projects";
$result = $db->query($sql);

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);
?>
