$(document).ready(function () {
    $.ajax({
        url: './assets/api/tasks.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            const grouped = {};
            data.forEach(task => {
                if (!grouped[task.project_name]) grouped[task.project_name] = [];
                grouped[task.project_name].push(task);
            });

            let html = '';
            let i = 0;
            for (const [project, tasks] of Object.entries(grouped)) {
                
                const projectId = `project${i++}`;
                html += `
                    <div class="accordion-item mb-2 border">
                        <h2 class="accordion-header" id="heading${projectId}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${projectId}" aria-expanded="false">
                            ${project}
                        </button>
                        </h2>
                        <div id="collapse${projectId}" class="accordion-collapse collapse" data-bs-parent="#accordionContainer">
                        <div class="accordion-body bg-white">
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Название</th>
                                    <th>Статус</th>
                                    <th>Приоритет</th>
                                    <th>Дедлайн</th>
                                    <th>Назначил</th>
                                    <th>Описание</th>
                                </tr>
                                </thead>
                                <tbody>
                                ${tasks.map(task => `
                                    <tr>
                                    <td>${task.title}</td>
                                    <td>
                                        <select class="form-select form-select-sm task-status-select" data-task-id="${task.id}">
                                            <option value="new" ${task.status === 'new' ? 'selected' : ''}>Открыта</option>
                                            <option value="pending" ${task.status === 'pending' ? 'selected' : ''}>В работе</option>
                                            <option value="completed" ${task.status === 'completed' ? 'selected' : ''}>Завершена</option>
                                        </select>
                                    </td>
                                    <td><span class="badge bg-${priorityColor(task.priority)}">${task.priority}</span></td>
                                    <td>${task.deadline == null ? 'Без ограничений' : task.deadline}</td>
                                    <td>${task.assigned_by}</td>
                                    <td>${task.description}</td>
                                    </tr>`).join('')}
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>`;
            }

            $('#accordionContainer').html(html);
        }
    });

    function priorityColor(priority) {
        return {
            'low': 'secondary',
            'medium': 'warning',
            'high': 'danger'
        }[priority] || 'light';
    }

    $(document).on('change', '.task-status-select', function () {
        const newStatus = $(this).val();
        const taskId = $(this).data('task-id');
      
        $.ajax({
          url: './assets/api/update_task_status.php',
          type: 'POST',
          data: { task_id: taskId, status: newStatus },
          success: function (response) {
            console.log('Статус обновлён');
          },
          error: function (err) {
            console.error('Ошибка обновления статуса', err);
            alert('Ошибка при обновлении статуса');
          }
        });
      });
      
});
