<?php
  session_start();
  if($_SESSION['loggedin']==false){
    header("Location: ./auth.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/bs/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/bs/bootstrap-select.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">TODO Manager</a>
    <a class="btn btn-light ms-auto" href="create.php">+ Добавить задачу</a>
  </div>
</nav>

<div class="container py-4">
  <h3 class="mb-4">Все задачи по проектам</h3>
  <div class="accordion" id="accordionContainer"></div>
</div>
</body>
<script src="./assets/js/jquery/jquery.min.js"></script>
<script src="./assets/js/bs/bootstrap.bundle.min.js"></script>
<script src="./assets/js/bs/bootstrap-select.min.js"></script>
<script src="./assets/js/index.js"></script>
</html>