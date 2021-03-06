<?php
require_once "config.php";

if($_POST['action'] == "getData")
{
    $J_ID = $_POST['job_Id'];

    $output = array('data' => array());

    $sql = "SELECT job_info.J_Id, job_info.J_Name, job_info.J_Dob, job_info.J_Gender, job_info.J_Email, 
            job_info.J_Phone, job_info.J_Qualification, job_info.J_Exp, job_info.J_Type, job_info.V_Id, job_info.W_Id, 
            job_info.J_Old_Company, job_info.J_Relative, job_info.J_Type, 
            work_detail.Status, work_detail.Work_Doc FROM job_info INNER JOIN work_detail ON job_info.W_Id = work_detail.W_Id 
            WHERE job_info.J_Visibility = 'visible' AND work_detail.Visibility = 'visible' AND job_info.J_Id = $J_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "removeJobDetail"){

    $RM_JID = $_POST['J_Id'];
    $WID = $_POST['WID'];
    $VID = $_POST['VID'];
    $U_ID = $_POST['UID'];

    if($RM_JID != ""){

        $output_rm_job= array('success' => false, 'messages' => array());    

        // UPDATE `work_detail` SET `Visibility`=[value-11],WHERE `V_Id`= 
        
        $sql_rm_Job =  "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id` ={$WID} AND `V_Id`={$VID};";

        $sql_rm_Job .=  "UPDATE `job_info` SET `J_Visibility`= 'hidden' WHERE `J_Id`={$RM_JID} AND `W_Id`={$WID} AND`V_Id`={$VID};";

        $sql_rm_Job .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                        VALUES ('{$U_ID}','Remove Job Details','{$VID}','{$WID}')";
       

        $query_rm_visitor = $con->multi_query($sql_rm_Job);
        if($query_rm_visitor === TRUE) {

            $output_rm_job['success'] = true;
            $output_rm_job['messages'] = 'Successfully removed Job Detail';
        } else {
            $output_rm_job['success'] = false;
            $output_rm_job['messages'] = 'Error while removing Job Detail'.$con->error;
        }
        
        // close database connection
        $con->close();        
        echo json_encode($output_rm_job);

    }else{
      
        $output_rm_job['success'] = false;
        $output_rm_job['messages'] = 'Error No ID Pass'.$con->error;
        $con->close();        
        echo json_encode($output_rm_job);  
    }

}else if($_POST['action'] == "getdefaultData"){

    // SELECT  `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign` FROM `job_info` WHERE `J_Id`= 1

    $J_ID = "1";

    $output = array('data' => array());

    $sql = "SELECT  `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign` FROM `job_info` WHERE `J_Id` = $J_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "updateDefaultJobLetterFormat"){

    $validator_ml_update = array('success' => false, 'messages' => array());

    $U_Id = $_POST["user_id"];
    $JL_TO = $_POST["jobletter_to"];
    $JL_SUBJECT = $_POST["jobletter_subject"];
    $JL_DETAIL = $_POST["jobletter_detail"];
    $JL_SIGN = $_POST["jobletter_sign"];
    $JL_Id = '1';
 // SELECT  `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign` FROM `job_info` WHERE `J_Id`= 1
    $sql_update = "UPDATE `job_info` SET `J_LTo`='$JL_TO',`J_LSubject`='$JL_SUBJECT',
            `J_LDetail`='$JL_DETAIL',`J_LSign`='$JL_SIGN' WHERE `J_Id`='$JL_Id';";

    $sql_update .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                    VALUES ('{$U_Id}','Update Job Letter Format')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update['success'] = true;
        $validator_ml_update['messages'] = 'Successfully Update Default JOB Letter Detail';
    }else{
        $validator_ml_update['success'] = false;
        $validator_ml_update['messages'] = 'Error Update Default JOB Letter Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update);


}else if($_POST["action"] == "getVisitorData"){

    $WORKID = $_POST["Work_Id"];

    $sql = "SELECT job_info.J_Id, job_info.V_Id, job_info.J_Name, job_info.J_Dob, job_info.J_Gender, job_info.J_Email, job_info.J_Phone,
                    job_info.J_Qualification, job_info.J_Exp, job_info.J_Old_Company, job_info.J_Relative, job_info.J_LTo, 		
                    job_info.J_LSubject, job_info.J_LDetail, job_info.J_LSign, job_info.J_LFinal,
                    visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, 			  
                    visitor_info.V_Gender, visitor_info.V_Address, 
                    visitor_info.V_City, visitor_info.V_Pincode
            FROM job_info INNER JOIN visitor_info ON job_info.V_Id = visitor_info.V_Id WHERE job_info.J_Type='Job Letter'
            AND job_info.J_Visibility = 'visible' AND job_info.W_Id = '$WORKID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST["action"] == "updateJobLetter"){

    $validator_ml_update_id = array('success' => false, 'messages' => array());

    $JL_TO = $_POST["jobletter_to"];
    $JL_SUBJECT = $_POST["jobletter_subject"];
    $JL_DETAIL = $_POST["jobletter_detail"];
    $JL_SIGN = $_POST["jobletter_sign"];
    $JL_Id = $_POST["Jl_id"];
    $VId = $_POST["visitor_id"];
    $WId = $_POST["work_id"];
    $U_ID = $_POST["U_ID"];

    $sql_update = "UPDATE `job_info` SET `J_LTo`='$JL_TO',`J_LSubject`='$JL_SUBJECT',
            `J_LDetail`='$JL_DETAIL',`J_LSign`='$JL_SIGN' WHERE `J_Id`='$JL_Id';";

    $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';";
    
    $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Edit and Update Job Letter','{$VId}','{$WId}')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update_id['success'] = true;
        $validator_ml_update_id['messages'] = 'Successfully Update Job Letter Detail';
    }else{
        $validator_ml_update_id['success'] = false;
        $validator_ml_update_id['messages'] = 'Error Update Job Letter Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update_id);


}else if($_POST["action"] == "uploadFile"){

    // print_r($_POST);
    // echo "asdas";

    $J_Id = $_POST["Jl_id"];
    $WId = $_POST["W_ID"];
    $VId = $_POST["visitor_id"];
    $U_ID = $_POST["U_ID"];
    $C_DATE = date("Y-m-d");


    $documentName = "JobLetter-".$J_Id."-".$_FILES["jl_final_document"]["name"];
    $target_dir_ml_letter = "../image/Work_File/job_letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["jl_final_document"]["size"] > 500000) {
        echo "File size should not be greated than 500Kb";       
    }else{
        //Upload Profile Image
        if(move_uploaded_file($_FILES["jl_final_document"]["tmp_name"], $target_file_ml_letter)) {

            // UPDATE `medical_letter` SET `ML_Final_Letter`='{$documentName}' WHERE `ML_Id`= '{$MLID}'

                $sql_upload = "UPDATE `job_info` SET `J_CDate`= '{$C_DATE}', 
                                `J_LFinal`='{$documentName}' WHERE `J_Id`= '{$J_Id}';";

                $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Upload Complete Job Letter','{$VId}','{$WId}')";
            
            if($con->multi_query($sql_upload)){
                echo "Image uploaded and saved in the Database".$C_DATE;
                // echo $con->error;              
            } else {
                echo "There was an erro uploading the file".$con->error;              
            }
        }else {
            echo "There was an erro uploading the file".$con->error;    
        }

    }

}else if($_POST["action"] == "todayJobEntry"){

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
    FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
    WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
    AND `Work_Category`='Job'
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