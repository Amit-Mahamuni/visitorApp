<?php

    require_once 'config.php';

    $output = array('success' => false, 'messages' => array());

    $AID = $_POST['connector_id'];
    $U_ID = $_POST['user_id'];

    $msg = "Delete Connector Details of Id ".$AID;

    // UPDATE `adhikari_info` SET `AD_Visibility` = 'hidden' WHERE `AD_Id` =
    $sql =  "UPDATE `connector_info` SET `CO_Visibility` = 'hidden' WHERE `CO_Id` =  {$AID};";

    $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                VALUES ('{$U_ID}','{$msg}')";

    $query = $con->multi_query($sql);
    if($query === TRUE) {
        $output['success'] = true;
        $output['messages'] = 'Successfully removed Connector';
    } else {
        $output['success'] = false;
        $output['messages'] = 'Error while removing the Connector information';
    }

    // close database connection
    // $con->close();
    $con->close();

    echo json_encode($output);

?>
