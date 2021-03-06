<?php

    require_once 'config.php';
    
    $output = array('success' => false, 'messages' => array());
    
    $userId = $_POST['user_Id'];
    $U_ID = $_POST['user_id'];
    
    $sql =  "UPDATE `user_info` SET `U_Visibility`='hidden' WHERE `U_Id`=  {$userId};";

    $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `U_Id_On`) 
                 VALUES ('{$U_ID}','Remove User and Details','{$userId}')";

    $query = $con->multi_query($sql);

    if($query === TRUE) {

        $output['success'] = true;
        $output['messages'] = 'Successfully removed User';

    } else {

        $output['success'] = false;
        $output['messages'] = 'Error while removing the User information';
        
    }
    
    $con->close();
    
    echo json_encode($output);

?>