<?php

    require_once 'config.php';
    
    $output = array('success' => false, 'messages' => array());
    
    $AID = $_POST['adhikari_id'];
    $U_ID = $_POST['user_id'];

    $msg = "Delete Adhikari Details of Id ".$AID;
    
    // UPDATE `adhikari_info` SET `AD_Visibility` = 'hidden' WHERE `AD_Id` =
    $sql =  "UPDATE `adhikari_info` SET `AD_Visibility` = 'hidden' WHERE `AD_Id` =  {$AID};";

    $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                VALUES ('{$U_ID}','{$msg}')";
    
    $query = $con->multi_query($sql);
    if($query === TRUE) {
        $output['success'] = true;
        $output['messages'] = 'Successfully removed Karykarta';
    } else {
        $output['success'] = false;
        $output['messages'] = 'Error while removing the karykarta information';
    }
    
    // close database connection
    $con->close();
    
    echo json_encode($output);

?>