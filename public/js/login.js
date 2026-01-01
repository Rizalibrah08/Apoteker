document.addEventListener('DOMContentLoaded', function () {
    // Password Visibility Toggle
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            // Toggle type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon class
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Input Focus Animations (Optional fallback if CSS :focus-within isn't enough)
    const inputs = document.querySelectorAll('.form-control');

    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function () {
            if (this.value === '') {
                this.parentElement.classList.remove('focused');
            }
        });
    });

    // Form Submission Animation
    const loginForm = document.querySelector('form');
    const btnLogin = document.querySelector('.btn-login');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            // Check HTML5 validity first
            if (!this.checkValidity()) {
                e.preventDefault();
                return;
            }

            // Simple button loading state
            if (btnLogin) {
                const originalText = btnLogin.innerHTML;
                btnLogin.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
                btnLogin.style.opacity = '0.9';
                btnLogin.style.pointerEvents = 'none'; // Prevent double submit

                // Allow form submission to proceed
            }
        });
    }
});
