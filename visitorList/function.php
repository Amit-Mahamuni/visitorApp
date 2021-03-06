<?php
require_once "config.php";

if($_POST['action'] == "getData")
{
    $VID = $_POST['visitor_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM visitor_info LEFT JOIN reference_detail ON visitor_info.V_Id = reference_detail.V_Id WHERE visitor_info.V_Visibility = 'visible' AND visitor_info.V_Id = $VID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);
    //  echo "ID".$VID;

}
else if($_POST['action'] == "removeVisitor"){

    $VID_rm_visitor = $_POST['visitor_Id'];
    $U_ID = $_POST['user_id'];

    if($VID_rm_visitor != ""){

        $output_rm_visitor = array('success' => false, 'messages' => array());    

        // UPDATE `work_detail` SET `Visibility`=[value-11],WHERE `V_Id`=    
        
        $sql_rm_visitor =  "UPDATE `visitor_info` SET `V_Visibility`='hidden' WHERE `V_Id`= {$VID_rm_visitor};";
        $sql_rm_visitor .=  "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `V_Id`= {$VID_rm_visitor};";
        $sql_rm_visitor .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`) 
                                VALUES ('{$U_ID}','Delete Visitor and his work Details','{$VID_rm_visitor}')";

        $query_rm_visitor = $con->multi_query($sql_rm_visitor);
        if($query_rm_visitor === TRUE) {

            $output_rm_visitor['success'] = true;
            $output_rm_visitor['messages'] = 'Successfully removed Visitor Detail';
        } else {
            $output_rm_visitor['success'] = false;
            $output_rm_visitor['messages'] = 'Error while removing Visitor Detail'.$con->error;
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

}else if($_POST['action'] == "todayEntry"){  

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
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