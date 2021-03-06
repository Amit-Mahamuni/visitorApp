<?php

require_once "config.php";

if($_POST['action'] == "getdefaultData"){

    // SELECT `RL_To`, `RL_Subject`, `RL_Detail`, `RL_Sign` FROM `residential_letter` WHERE `RL_Id` = 

    $RL_Id = "1";

    $output = array('data' => array());    

    $sql = "SELECT `RL_To`, `RL_Subject`, `RL_Detail`, `RL_Sign` FROM `residential_letter` WHERE `RL_Id` = $RL_Id";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "updateDefaultResidentialLetterFormat"){

    $validator_ml_update = array('success' => false, 'messages' => array());

// print_r($_POST);

    $U_Id = $_POST["user_id"];
    $RL_TO = $_POST["residentialL_to"];
    $RL_SUBJECT = $_POST["residentialL_subject"];
    $RL_DETAIL = $_POST["residentialL_detail"];
    $RL_SIGN = $_POST["residentialL_sign"];
    $RL_Id = '1';

    $sql_update = "UPDATE `residential_letter` SET `RL_To`='$RL_TO',`RL_Subject`='$RL_SUBJECT',
            `RL_Detail`='$RL_DETAIL',`RL_Sign`='$RL_SIGN' WHERE `RL_Id`='$RL_Id';";

    $sql_update .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                    VALUES ('{$U_Id}','Update Residential Letter Format')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update['success'] = true;
        $validator_ml_update['messages'] = 'Successfully Update Default Residential Letter Format Detail';
    }else{
        $validator_ml_update['success'] = false;
        $validator_ml_update['messages'] = 'Error Update Default Residential Letter Format Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update);


}else if($_POST["action"] == "getVisitorData"){

    $WORKID = $_POST["Work_Id"];

    $sql = "SELECT residential_letter.RL_Id, residential_letter.RL_For, residential_letter.RL_TYear, residential_letter.RL_To, 
                    residential_letter.RL_Subject, residential_letter.RL_Detail, residential_letter.RL_Sign, residential_letter.V_Id,
                    visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, 			  
                    visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode
            FROM residential_letter INNER JOIN visitor_info ON residential_letter.V_Id = visitor_info.V_Id 
            WHERE residential_letter.RL_Visibility = 'visible' AND residential_letter.W_Id = '$WORKID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST["action"] == "updateLetter"){

    $validator_ml_update_id = array('success' => false, 'messages' => array());

    $RL_TO = $_POST["letter_to"];
    $RL_SUBJECT = $_POST["letter_subject"];
    $RL_DETAIL = $_POST["letter_detail"];
    $RL_SIGN = $_POST["letter_sign"];
    $RL_Id = $_POST["id"];
    $VId = $_POST["visitor_id"];
    $WId = $_POST["work_id"];
    $U_ID = $_POST["U_ID"];

    $sql_update = "UPDATE `residential_letter` SET `RL_To`='$RL_TO',`RL_Subject`='$RL_SUBJECT',
                 `RL_Detail`='$RL_DETAIL',`RL_Sign`='$RL_SIGN' WHERE `RL_Id`='$RL_Id';";

    $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';";  
    
    $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Edit and Update Residential Letter','{$VId}','{$WId}')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update_id['success'] = true;
        $validator_ml_update_id['messages'] = 'Successfully Update Residential Letter Detail';
    }else{
        $validator_ml_update_id['success'] = false;
        $validator_ml_update_id['messages'] = 'Error Update Residential Letter Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update_id);


}else if($_POST["action"] == "uploadFile"){

    $RL_Id = $_POST["Rl_id"];
    $WId = $_POST["W_ID"];
    $VId = $_POST["visitor_id"];
    $U_ID = $_POST["U_ID"];
    $C_DATE = date("Y-m-d");


    $documentName = "ResdentailLetter-".$RL_Id."-".$_FILES["final_document"]["name"];
    $target_dir_ml_letter = "../../image/Work_File/residential_letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["final_document"]["size"] > 2000000) {
        echo "File size should not be greated than 200Kb";       
    }else{
        //Upload Profile Image
        if(move_uploaded_file($_FILES["final_document"]["tmp_name"], $target_file_ml_letter)) {

                $sql_upload = "UPDATE `residential_letter` SET `RL_C_Date`= '{$C_DATE}', 
                                `RL_FLetter`='{$documentName}' WHERE `RL_Id`= '{$RL_Id}';";

                $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Upload Residential Complete Letter','{$VId}','{$WId}')";
            
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