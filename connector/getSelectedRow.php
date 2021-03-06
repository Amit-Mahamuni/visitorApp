<?php

    require_once "config.php";

    $Id = $_POST['Connector_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `connector_info` WHERE `CO_Id` = $Id ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

?>
