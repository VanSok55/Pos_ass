<?php

    $host = "localhost";
    $user = "root";
    $pass = ""; // Default XAMPP MySQL password is empty
    $db = "db-pos-system";
    $port = 3306; // Use the correct port (3306 or 3307)

    $conn = new mysqli($host, $user, $pass, $db, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


?>
