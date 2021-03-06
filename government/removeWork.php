<?php

    require_once 'config.php';
    
    $output = array('success' => false, 'messages' => array());
    
    $WorkId = $_POST['Work_Id'];
    $VisitorId = $_POST['Visitor_Id'];
    $U_ID = $_POST['User_Id'];

    if($WorkId != "" && $VisitorId != ""){

        $sql_work = "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id`=  {$WorkId};";
        
        $sql_work .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Delete Goverment Work details','{$VisitorId}','{$WorkId}')";
        
        $query = $con->multi_query($sql_work);
        if($query === TRUE) {
            // $output['success'] = true;
            // $output['messages'] = 'Successfully removed Work';

            //remove visitor detail also
            // $sql_visitor = "UPDATE `visitor_info` SET `V_Visibility`='hidden' WHERE `V_Id`=  {$VisitorId}";
            // $sql_visitor = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
            //                 VALUES ('{$U_ID}','Delete Goverment Work and Visitor Work','{$VisitorId}','{$WorkId}')";
            
            // $query = $con->query($sql_visitor);
            // if($query === TRUE) {
            //     $output['success'] = true;
            //     $output['messages'] = 'Successfully removed Work and Visitor detail';
                
            // }

            $output['success'] = true;
            $output['messages'] = 'Successfully removed Work detail';


        } else {
            $output['success'] = false;
            $output['messages'] = 'Error while removing the detail'.$con->error;
        }

    }else{
        $output['success'] = false;
        $output['messages'] = 'Error while removing the detail'.$con->error();
    }
    
    $con->close();
    
    echo json_encode($output);

?>