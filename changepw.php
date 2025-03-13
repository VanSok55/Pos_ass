<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <form action="" method="post">
            <label for="">Change Password</label><hr>
            <br><br>
            <label for="">Your Username (old)</label>
            <input type="text" name="username" id="">
            <br><br>
            <label for="">Your Password (old)</label>
            <input type="password" name="password" id="">
            <br><br>
            <button name="submit" type="submit">Enter</button>
        </form>
    </center>
</body>
</html>

<?php
    session_start();
//    include("connection.php");
    include("connection.php");
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM tb_user WHERE u_name = '$username'";
        $rs = $conn->query($sql);
        if($rs -> num_rows > 0)
        {
            $row = $rs->fetch_assoc();
            if(password_verify($password,$row['pass'])){
                $_SESSION['id_user'] = $row['id'];
               header("Location: newpw.php");
            }else{
                echo"<script> alert(The password is wrong!!)";
            }
        }else{
            echo"<script> alert(The username can not found!!);";
        }
    }
?>