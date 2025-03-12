<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <form action="" method="POST">
            <label for="">New Password Form</label>
            <hr><br><br>
            <label for="">New Password</label>
            <input type="password" name="npassword" id="">
            <br><br>
            <label for="">Comfirm Password</label>
            <input type="password" name="cpassword" id="">
            <button name="submit" type="submit">Okay</button>
        </form>
    </center>
</body>
</html>


<?php
    session_start();
    include("connection.php");
    if(!isset($_SESSION['id_user'])) {
    echo "<script>alert('Unauthorized access!'); window.location='changepw.php';</script>";
    exit();
    }
    if(isset($_POST['submit']))
    {
        $id_user = $_SESSION['id_user'];
        $newpw = $_POST['npassword'];
        $comfirmpw = $_POST['cpassword'];
        if($newpw == $comfirmpw)
        {
            $encryptpw = password_hash($newpw,PASSWORD_DEFAULT);
            $sql = "UPDATE tb_user SET pass = '$encryptpw' WHERE id = '$id_user'";
           if( $conn->query($sql))
           {
                session_destroy();
                echo"<script>alert ('The Password update succussuly!!!'); window.location='index.php'</script>";
           }else{
                echo"<script>alert ('The Password update failed!! error');</script>";
           }

        }else{
            echo"<script>alert ('The Password isn't match!!');</script>";
        }
    }
?>

