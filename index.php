<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text: #0f172a;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background: linear-gradient(to bottom right, #f1f5f9, #e2e8f0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: var(--text);
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            position: relative;
        }

        .auth-card {
            background-color: var(--card-bg);
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            padding: 2rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        #register {
            display: none;
            opacity: 0;
            transform: translateY(20px);
        }

        .auth-card.active {
            display: block;
            animation: fadeIn 0.3s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .name-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            background-color: var(--input-bg);
            font-size: 0.875rem;
            transition: border-color 0.15s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .password-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .forgot-password {
            font-size: 0.75rem;
            color: var(--primary);
            text-decoration: none;

        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            background-color: var(--input-bg);
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .auth-footer p {
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .password-input-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem;
            }

            .name-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
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
                </div>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')"><i class="fa-solid fa-eye"></i></span>
                </div>

                <a href="#" class="forgot-password">Forgot password?</a>
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
                    <input type="password" name="password" id="register-password" placeholder="Password" required>
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