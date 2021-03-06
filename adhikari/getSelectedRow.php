<?php

    require_once "config.php";

    $A_Id = $_POST['Adhikari_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `adhikari_info` WHERE `AD_Id` = $A_Id ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

?>