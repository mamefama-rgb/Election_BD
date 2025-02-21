const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const passwordInput = document.querySelector('input[type="password"]');
const passwordStrengthIndicator = document.getElementById('passwordStrength');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

passwordInput.addEventListener('input', function() {
    const password = passwordInput.value;
    let strength = 'Faible';

    if (password.length > 8) {
        strength = 'Moyenne';
    }
    if (/[A-Z]/.test(password) && /[0-9]/.test(password) && password.length > 10) {
        strength = 'Forte';
    }

    passwordStrengthIndicator.textContent = `Force du mot de passe: ${strength}`;
});



