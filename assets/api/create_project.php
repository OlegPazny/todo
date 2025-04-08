<?php
require_once './db_connect.php';

// Проверяем, что пришел параметр project_name
if (isset($_POST['project_name'])) {
    $projectName = $_POST['project_name'];
    $stmt = $db->prepare("INSERT INTO `projects` (`name`) VALUES (?)");
    $stmt->bind_param("s", $projectName);

    if ($stmt->execute()) {
        $newProjectId = $stmt->insert_id;
        echo json_encode(['success' => true, 'new_project_id' => $newProjectId]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
