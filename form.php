<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

   
</head>
<body>
    <div class="container" id="login">
         <form action="login.php" method="post">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input name="login" type="submit" value="Login"><br><br>
    </form>
    <p>Don't have account yet?</p>
    <button id="btn-register">Register</button>
    </div>

    <div class="container" id="register" style="display:none;">
        <form action="login.php" method="post">
        <h2>Register</h2>
        <label for="">First name</label>
        <input type="text" name="fname" id="" required>
        <br><br>
        <label for="">Last name</label>
        <input type="text" name="lname" id="" required>
        <br><br>
        <label for="">Email</label>
        <input type="email" name="email" id="" required>
        <br><br>
        <label for="">Password</label>
        <input type="password" name="password" id="" required>
        <br><br>
        <button name="register" type="submit">Create account</button>
        <p>Have Account?</p>
        <input type="button" value="login" id="btn-log">
    </form>
    </div>

<script src='script.js'>

</script>
</body>

</html>