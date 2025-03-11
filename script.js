const register = document.getElementById("register");
const login = document.getElementById("login");
const btn_register = document.getElementById("btn-register");
const btn_log = document.getElementById("btn-log");

btn_register.addEventListener("click", function () {
  register.style.display = "block";
  login.style.display = "none";
});

btn_log.addEventListener("click", function () {
  register.style.display = "none";
  login.style.display = "block";
});
