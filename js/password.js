    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.classList.remove('bxs-hide');
            togglePassword.classList.add('bx-show');
        } else {
            passwordInput.type = 'password';
            togglePassword.classList.remove('bx-show');
            togglePassword.classList.add('bxs-hide');
        }
    });
