document.addEventListener('DOMContentLoaded', function() {
  const loginCard = document.getElementById('login');
  const registerCard = document.getElementById('register');
  const btnRegister = document.getElementById('btn-register');
  const btnLogin = document.getElementById('btn-log');

  // Initially show login form
  loginCard.classList.add('active');

  // Switch to register form
  btnRegister.addEventListener('click', function() {
    loginCard.style.display = 'none';
    loginCard.classList.remove('active');

    registerCard.style.display = 'block';
    setTimeout(() => {
      registerCard.classList.add('active');
    }, 10);
  });

  // Switch to login form
  btnLogin.addEventListener('click', function() {
    registerCard.style.display = 'none';
    registerCard.classList.remove('active');

    loginCard.style.display = 'block';
    setTimeout(() => {
      loginCard.classList.add('active');
    }, 10);
  });
});

function togglePasswordVisibility(inputId) {
  const passwordInput = document.getElementById(inputId);
  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);
}