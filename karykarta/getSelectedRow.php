<?php

    require_once "config.php";

    $karykartaId = $_POST['karykarta_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `karykarta` WHERE `K_Id` = $karykartaId ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

?>