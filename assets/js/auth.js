document.getElementById('loginForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Отключаем стандартное поведение формы

    // Получаем данные формы
    const login = document.getElementById('login').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('./assets/api/auth_script.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ login: login, password: password })
        });

        const result = await response.json();

        if (result.success) {
            // Перенаправление или другое действие при успешной авторизации
            window.location.href = './index.php';
        } else {
            // Вывод сообщения об ошибке
            document.getElementById('error-message').style.display = 'block';
            $("#error-message").text(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
});
