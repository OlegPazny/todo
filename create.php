<?php
session_start();
if ($_SESSION['loggedin'] == false) {
    header("Location: ./auth.php");
};
require_once './assets/api/db_connect.php';
$projects = $db->query("SELECT `id`, `name` FROM `projects`")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/bs/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/bs/bootstrap-select.min.css">
</head>

<body>

    <body class="bg-light">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">TODO Manager</a>
            </div>
        </nav>

        <div class="container py-5">
            <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
                <h4 class="mb-4">Создание новой задачи</h4>

                <form id="taskForm">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название задачи</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="projects" class="form-label">Проект</label>
                        <select name="project_id" class="form-select selectpicker projects" id="projectSelect" required>
                        </select>
                        <!-- Кнопка для добавления нового проекта -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                            Добавить новый проект
                        </button>

                        <!-- Модальное окно для добавления нового проекта -->
                        <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addProjectModalLabel">Добавить новый проект</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="newProjectName" class="form-label">Название проекта</label>
                                            <input type="text" class="form-control" id="newProjectName">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                        <button type="button" class="btn btn-primary" id="addProjectBtn">Добавить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Приоритет</label>
                        <select class="form-select selectpicker" id="priority" name="priority" required>
                            <option value="low">Низкий</option>
                            <option value="medium">Средний</option>
                            <option value="high">Высокий</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">Дедлайн</label>
                        <input type="date" class="form-control" id="deadline" name="deadline">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Создать задачу</button>
                </form>
            </div>
        </div>
    </body>
    <script src="./assets/js/jquery/jquery.min.js"></script>
    <script src="./assets/js/bs/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/bs/bootstrap-select.min.js"></script>
    <script src="./assets/js/create.js"></script>

</html>