<?php

require_once "config.php";

if($_POST['action'] == "getdefaultData"){

    // SELECT  `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign` FROM `job_info` WHERE `J_Id`= 1

    $RC_Id = "1";

    $output = array('data' => array());
    

    $sql = "SELECT `RC_LTo`, `RC_LSubject`, `RC_LDetail`, `RC_LSign` FROM `ration_card_letter` WHERE `RC_Id`= $RC_Id";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "updateDefaultRationLetterFormat"){

    $validator_ml_update = array('success' => false, 'messages' => array());

// print_r($_POST);

    $U_Id = $_POST["user_id"];
    $RCL_TO = $_POST["rationcardL_to"];
    $RCL_SUBJECT = $_POST["rationcardL_subject"];
    $RCL_DETAIL = $_POST["rationcardL_detail"];
    $RCL_SIGN = $_POST["rationcardL_sign"];
    $RCL_Id = '1';

 // SELECT  `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign` FROM `job_info` WHERE `J_Id`= 1

    $sql_update = "UPDATE `ration_card_letter` SET `RC_LTo`='$RCL_TO',`RC_LSubject`='$RCL_SUBJECT',
                 `RC_LDetail`='$RCL_DETAIL',`RC_LSign`='$RCL_SIGN' WHERE `RC_Id`='$RCL_Id';";

    $sql_update .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                    VALUES ('{$U_Id}','Update Ration Letter Format')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update['success'] = true;
        $validator_ml_update['messages'] = 'Successfully Update Default Ration Card Letter Format Detail';
    }else{
        $validator_ml_update['success'] = false;
        $validator_ml_update['messages'] = 'Error Update Default Ration Card Letter Format Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update);


}else if($_POST["action"] == "getVisitorData"){

    $WORKID = $_POST["Work_Id"];

    $sql = "SELECT ration_card_letter.RC_Id, ration_card_letter.RC_TM, ration_card_letter.RC_TW, ration_card_letter.RC_TY, 
                    ration_card_letter.RC_LTo, ration_card_letter.RC_LSubject, ration_card_letter.RC_LDetail, ration_card_letter.RC_LSign, 
                    ration_card_letter.RC_FLetter, ration_card_letter.RC_CDate, ration_card_letter.V_Id,
                    visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, 			  
                    visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode
            FROM ration_card_letter INNER JOIN visitor_info ON ration_card_letter.V_Id = visitor_info.V_Id 
            WHERE ration_card_letter.RC_Visibility = 'visible' AND ration_card_letter.W_Id = '$WORKID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST["action"] == "updateLetter"){

    $validator_ml_update_id = array('success' => false, 'messages' => array());

    $RCL_TO = $_POST["letter_to"];
    $RCL_SUBJECT = $_POST["letter_subject"];
    $RCL_DETAIL = $_POST["letter_detail"];
    $RCL_SIGN = $_POST["letter_sign"];
    $RCL_Id = $_POST["id"];
    $VId = $_POST["visitor_id"];
    $WId = $_POST["work_id"];
    $U_ID = $_POST["U_ID"];

    $sql_update = "UPDATE `ration_card_letter` SET `RC_LTo`='$RCL_TO',`RC_LSubject`='$RCL_SUBJECT',
                 `RC_LDetail`='$RCL_DETAIL',`RC_LSign`='$RCL_SIGN' WHERE `RC_Id`='$RCL_Id';";

    $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';"; 
    
    $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Edit and Update Ration Card Letter','{$VId}','{$WId}')";

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

    $RC_Id = $_POST["Rl_id"];
    $WId = $_POST["W_ID"];
    $VId = $_POST["visitor_id"];
    $U_ID = $_POST["U_ID"];
    $C_DATE = date("Y-m-d");


    $documentName = "RationCardLetter-".$RC_Id."-".$_FILES["final_document"]["name"];
    $target_dir_ml_letter = "../../image/Work_File/rationc_letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["final_document"]["size"] > 500000) {
        echo "File size should not be greated than 500Kb";       
    }else{
        //Upload Profile Image
        if(move_uploaded_file($_FILES["final_document"]["tmp_name"], $target_file_ml_letter)) {

                $sql_upload = "UPDATE `ration_card_letter` SET `RC_CDate`= '{$C_DATE}', 
                                `RC_FLetter`='{$documentName}' WHERE `RC_Id`= '{$RC_Id}';";

                $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Upload Ration Card Complete Letter','{$VId}','{$WId}')";
            
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

}


?>