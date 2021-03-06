<?php

    require_once 'config.php';
    
    $output = array('success' => false, 'messages' => array());
    
    $karykartaId = $_POST['karykarta_Id'];
    $U_ID = $_POST['user_id'];

    
    // $sql = "DELETE FROM `karykarta` WHERE `K_Id` = {$karykartaId}";
    $sql =  "UPDATE `karykarta` SET `K_Visibility`='hidden' WHERE `K_Id`=  {$karykartaId};";

    $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `K_Id`) 
                VALUES ('{$U_ID}','Remove Karykarta','{$karykartaId}')";


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