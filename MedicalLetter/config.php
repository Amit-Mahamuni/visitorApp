<?php
    $con = new mysqli("localhost","root","Amit@Maha#2020","visit");

    mysqli_set_charset($con, 'utf8');

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    
?>