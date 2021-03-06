<?php
require_once "config.php";

if($_POST['action'] == "getData")
{
    $WI_ID = $_POST['invition_Id'];

    $output = array('data' => array());

    $sql = "SELECT invitation.I_Id, invitation.I_Title, invitation.I_Date, invitation.I_Time, 
            invitation.I_Address, invitation.WI_BName, invitation.WI_GName, invitation.I_Type,
            invitation.W_Id, invitation.V_Id, invitation.I_Status, work_detail.Work_Doc 
            FROM invitation INNER JOIN work_detail 
            ON invitation.W_Id = work_detail.W_Id 
            WHERE invitation.I_Visibility = 'visible' 
            AND invitation.I_Id =  $WI_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "removeInvitation"){

    $RM_WIID = $_POST['WI_Id'];
    $WID = $_POST['WID'];
    $VID = $_POST['VID'];
    $U_ID = $_POST['User_Id'];

    if($RM_WIID != ""){

        $output_rm_visitor = array('success' => false, 'messages' => array());    

        // UPDATE `work_detail` SET `Visibility`=[value-11],WHERE `V_Id`= 
        
        $sql_rm_visitor =  "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id` ={$WID} AND `V_Id`={$VID};";
        // UPDATE `invitation` SET `I_Visibility`='hidden' WHERE `I_Id`=7
        $sql_rm_visitor .=  "UPDATE `invitation` SET `I_Visibility`= 'hidden' WHERE `I_Id`={$RM_WIID} AND `W_Id`={$WID} AND`V_Id`={$VID};";

        $sql_rm_visitor .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Delete Invitation Details','{$VID}','{$WID}')";
       

        $query_rm_visitor = $con->multi_query($sql_rm_visitor);
        if($query_rm_visitor === TRUE) {

            $output_rm_visitor['success'] = true;
            $output_rm_visitor['messages'] = 'Successfully removed Invitation Detail';
        } else {
            $output_rm_visitor['success'] = false;
            $output_rm_visitor['messages'] = 'Error while removing Invitation Detail'.$con->error;
        }
        
        // close database connection
        $con->close();        
        echo json_encode($output_rm_visitor);

    }else{
      
        $output_rm_visitor['success'] = false;
        $output_rm_visitor['messages'] = 'Error No ID Pass'.$con->error;
        $con->close();        
        echo json_encode($output_rm_visitor);  
    }

}else if($_POST['action'] == "todayWorkEntry"){

    $output_t_visitor = array('success' => false, 'total' => '');   

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                        AND `Work_Category`='Invitation'
                        AND  work_detail.Work_add_date > CURRENT_DATE";
    
    $query_t_visitor = $con->query($sql_t_visitor);

    $result = $query_t_visitor->num_rows;

    $con->close();        
    echo json_encode($result);
    
}

else{
    echo "No action selected".$con->error();
}


?>