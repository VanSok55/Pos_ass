<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if(isset($_POST["register"])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $fullname = $fname . " " . $lname; 

    $checkemail = "SELECT * FROM tb_user WHERE email = ?";
    $stmt = $conn->prepare($checkemail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO tb_user (u_name, email, pass) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);

        if ($stmt->execute()) {
            // Ensure no output before header()
            ob_start();
            header("Location: index.php");
            ob_end_flush();
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt->close();
    }

    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM tb_user WHERE u_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['pass'])) {
                $_SESSION['u_name'] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid username or password (Password Mismatch)";
            }
        } else {
            echo "Invalid username or password (User Not Found)";
        }

        $stmt->close();
    } else {
        echo "Username and password are required.";
    }
}



$conn->close();
?>