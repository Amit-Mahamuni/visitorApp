<?php
    $con = new mysqli("localhost","root","Amit@Maha#2020","visit");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    
?>