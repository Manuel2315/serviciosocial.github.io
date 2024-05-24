document.addEventListener('DOMContentLoaded', function() {
    const loginLink = document.querySelector('a[href="#register"]');
    const loginSection = document.getElementById('login');
    const registerSection = document.getElementById('register');
    const documentsSection = document.getElementById('documents');

    loginLink.addEventListener('click', function(event) {
        event.preventDefault();
        loginSection.style.display = 'none';
        registerSection.style.display = 'block';
    });

    document.querySelector('form[action="register.php"]').addEventListener('submit', function(event) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const usernameRegex = /^IS\d{8}$/;

        if (!usernameRegex.test(username)) {
            alert('El nombre de usuario debe comenzar con IS seguido de 8 números.');
            event.preventDefault();
        }

        if (password.length !== 8) {
            alert('La contraseña debe tener exactamente 8 caracteres.');
            event.preventDefault();
        }
    });

    document.querySelector('form[action="login.php"]').addEventListener('submit', function(event) {
        const username = document.getElementById('login_username').value;
        const password = document.getElementById('login_password').value;
        const usernameRegex = /^IS\d{8}$/;

        if (!usernameRegex.test(username)) {
            alert('El nombre de usuario debe comenzar con IS seguido de 8 números.');
            event.preventDefault();
        }

        if (password.length !== 8) {
            alert('La contraseña debe tener exactamente 8 caracteres.');
            event.preventDefault();
        }
    });
});
