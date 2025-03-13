<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style/style.css">
</head>
<body
<div class="auth-container">
    <div class="auth-card" id="login">
        <div class="auth-header">
            <h2>Login</h2>
            <p class="auth-subtitle">Enter your credentials to sign in</p>
        </div>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <div class="password-header">
                    <label for="password">Password</label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
                </div>
            </div>
            <button class="btn btn-primary" name="login" type="submit">Login</button>
        </form>
        <div class="auth-footer">
            <p>Don't have account yet?</p>
            <button class="btn btn-outline" id="btn-register">Register</button>
        </div>
    </div>

    <div class="auth-card" id="register">
        <div class="auth-header">
            <h2>Register</h2>
            <p class="auth-subtitle">Create a new account</p>
        </div>
        <form action="login.php" method="post">
            <div class="name-row">
                <div class="form-group">
                    <label for="fname">First name</label>
                    <input type="text" name="fname" id="fname" placeholder="John" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last name</label>
                    <input type="text" name="lname" id="lname" placeholder="Doe" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="john.doe@example.com" required>
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <div class="password-input-container">
                    <input type="password" name="password" id="register-password" placeholder="••••••••" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('register-password')">👁️</span>
                </div>
            </div>
            <button class="btn btn-primary" name="register" type="submit">Create account</button>
        </form>
        <div class="auth-footer">
            <p>Have Account?</p>
            <button class="btn btn-outline" id="btn-log">Login</button>
        </div>
    </div>
</div>
<script src="script.js">

</script>
</body>
</html>