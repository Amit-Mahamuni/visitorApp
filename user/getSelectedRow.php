<?php

    require_once "config.php";

    $userId = $_POST['user_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `user_info` WHERE `U_Id` = $userId ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

?>