<?php

require_once "config.php";

if($_POST['action'] == "visitorDetail"){

    $visitorId = $_POST['visitorId'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `visitor_info` WHERE `V_Id`= $visitorId";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}

?>