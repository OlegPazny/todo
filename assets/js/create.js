$(document).ready(function() {
    const deadlineInput = document.getElementById('deadline');
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);

    const yyyy = tomorrow.getFullYear();
    const mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
    const dd = String(tomorrow.getDate()).padStart(2, '0');

    deadlineInput.min = `${yyyy}-${mm}-${dd}`;
    // Функция для загрузки проектов
    function loadProjects() {
        $.ajax({
            url: './assets/api/get_projects.php',
            type: 'GET',
            dataType: 'json',
            success: function(projects) {
                // Получаем текущий select элемент
                const select = $('select.projects');
                
                // Очищаем его
                select.empty();
                select.append('<option value="">Выберите проект</option>');
                
                // Добавляем новые options
                projects.forEach(project => {
                    select.append(new Option(project.name, project.id));
                });
                
                // Уничтожаем старый selectpicker (если был)
                select.selectpicker('destroy');
                
                // Инициализируем заново
                select.selectpicker();
            },
            error: function(error) {
                console.error('Ошибка при загрузке проектов:', error);
            }
        });
    }

    // Загружаем проекты при старте
    loadProjects();

    // Обработчик для добавления нового проекта
    $('#addProjectBtn').click(function() {
        const projectName = $('#newProjectName').val().trim();

        if (projectName) {
            $.ajax({
                url: './assets/api/create_project.php',
                type: 'POST',
                dataType: 'json',
                data: { project_name: projectName },
                success: function(response) {
                    if (response.success) {
                        $('#addProjectModal').modal('hide');
                        $('#newProjectName').val('');
                        loadProjects();
                    } else {
                        alert('Ошибка при добавлении проекта');
                    }
                },
                error: function(error) {
                    console.error('Ошибка при добавлении проекта:', error);
                }
            });
        } else {
            alert('Название проекта не может быть пустым');
        }
    });

    // Обработчик для добавления задачи
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        
        $.post('./assets/api/create_task.php', $(this).serialize(), function(response) {
            alert('Задача добавлена!');
            $('#taskForm')[0].reset();
        });
    });
});