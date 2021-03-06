<?php
require_once "config.php";

if($_POST['action'] == "getDataEducation")
{
    $E_ID = $_POST['education_Id'];

    $output = array('data' => array());

    $sql = "SELECT education_info.E_Id, education_info.E_Student_Name, education_info.E_Collage_Name, 
            education_info.E_Class, education_info.E_T_Fee, education_info.E_D_Fee, education_info.V_Id,
            education_info.W_Id, education_info.E_Visibility, work_detail.Work_Doc 
            FROM education_info INNER JOIN work_detail ON education_info.W_Id = work_detail.W_Id 
            WHERE education_info.E_Visibility = 'visible' AND work_detail.Visibility = 'visible' AND education_info.E_Id = $E_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "removeEducation"){

    $RM_EID = $_POST['E_Id'];
    $WID = $_POST['WID'];
    $VID = $_POST['VID'];
    $U_ID = $_POST['U_ID'];

    if($RM_EID != ""){

        $output_rm_education = array('success' => false, 'messages' => array());    

        // UPDATE `work_detail` SET `Visibility`=[value-11],WHERE `V_Id`= 
        
        $sql_rm_education =  "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id` ={$WID} AND `V_Id`={$VID};";
        // UPDATE `invitation` SET `I_Visibility`='hidden' WHERE `I_Id`=7
        $sql_rm_education .=  "UPDATE `education_info` SET `E_Visibility`= 'hidden' WHERE `E_Id`={$RM_EID} AND `W_Id`={$WID} AND`V_Id`={$VID};";

        $sql_rm_education .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Remove Education Detail','{$VID}','{$WID}')";
       

        $query_rm_education = $con->multi_query($sql_rm_education);
        if($query_rm_education === TRUE) {

            $output_rm_education['success'] = true;
            $output_rm_education['messages'] = 'Successfully removed Invitation Detail';
        } else {
            $output_rm_education['success'] = false;
            $output_rm_education['messages'] = 'Error while removing Invitation Detail'.$con->error;
        }
        
        // close database connection
        $con->close();        
        echo json_encode($output_rm_education);

    }else{
      
        $output_rm_education['success'] = false;
        $output_rm_education['messages'] = 'Error No ID Pass'.$con->error;
        $con->close();        
        echo json_encode($output_rm_education);  
    }

}else if($_POST['action'] == "todayWorkEntry"){

    $output_t_visitor = array('success' => false, 'total' => '');   

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                        AND `Work_Category`='Personal' AND `Work_Subcategory`='Education'
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