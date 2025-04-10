<?php
require_once './db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = intval($_POST['task_id']);
    $status = trim($_POST['status']);

    $allowedStatuses = ['new', 'pending', 'completed'];
    if (!in_array($status, $allowedStatuses)) {
        http_response_code(400);
        echo json_encode(['error' => 'Недопустимый статус']);
        exit;
    }

    // Используем подготовленный запрос
    $stmt = $db->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Ошибка подготовки запроса']);
        exit;
    }

    $stmt->bind_param('si', $status, $taskId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Статус не обновлён или не изменился']);
    }

    $stmt->close();
}
