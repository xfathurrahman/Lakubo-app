$(document).ready(function () {
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        if (type === 'password') {
            togglePassword.innerHTML = `<i class="fa-regular fa-eye-slash h-6 w-6"></i>`;
        } else {
            togglePassword.innerHTML = `<i class="fa-regular fa-eye h-6 w-6"></i>`;
        }
    });
});
