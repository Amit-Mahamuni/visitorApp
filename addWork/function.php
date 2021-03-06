<?php

require_once "config.php";

$VID = $_POST['visitor_Id'];

$output = array('data' => array());

$sql = "SELECT * FROM `visitor_info` WHERE `V_Visibility` = 'visible' AND `V_Id` = $VID";

$query = $con->query($sql);

$result = $query->fetch_assoc();

$con->close();

echo json_encode($result);
//  echo "ID".$VID;

?>