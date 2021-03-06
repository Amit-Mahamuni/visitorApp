<?php

require_once "config.php";

if($_POST['action'] == "getdefaultData"){

    $ID_Id = "1";

    $output = array('data' => array());
    

    $sql = "SELECT `ID_LTitle`, `ID_LSubject`, `ID_LDetail`, `ID_LSign` FROM `identitycard_letter` WHERE `ID_Id` = $ID_Id";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "updateDefaultIdentityLetterFormat"){

    $validator_ml_update = array('success' => false, 'messages' => array());


    $U_Id = $_POST["user_id"];
    $IDC_TO = $_POST["identityL_to"];
    $IDC_SUBJECT = $_POST["identitycardL_subject"];
    $IDC_DETAIL = $_POST["identitycardL_detail"];
    $IDC_SIGN = $_POST["identitycardL_sign"];
    $ID_Id = '1';

    $sql_update = "UPDATE `identitycard_letter` SET `ID_LTitle`='$IDC_TO',`ID_LSubject`='$IDC_SUBJECT',
            `ID_LDetail`='$IDC_DETAIL',`ID_LSign`='$IDC_SIGN' WHERE `ID_Id`='$ID_Id';";

    $sql_update .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                    VALUES ('{$U_Id}','Update Identity Letter Format')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update['success'] = true;
        $validator_ml_update['messages'] = 'Successfully Update Default Identity Card Letter Format Detail';
    }else{
        $validator_ml_update['success'] = false;
        $validator_ml_update['messages'] = 'Error Update Default Identity Card Letter Format Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update);


}else if($_POST["action"] == "getVisitorData"){

    $WORKID = $_POST["Work_Id"];

    $sql = "SELECT identitycard_letter.ID_Id, identitycard_letter.ID_TYear, identitycard_letter.V_Id, identitycard_letter.W_Id, 
                identitycard_letter.ID_LTitle, identitycard_letter.ID_LSubject, identitycard_letter.ID_LDetail, identitycard_letter.ID_LSign, 
                identitycard_letter.ID_FLetter, identitycard_letter.ID_CDate, identitycard_letter.ID_Visibility,
                visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, visitor_info.V_Gender, 
                visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode
            FROM identitycard_letter INNER JOIN visitor_info ON identitycard_letter.V_Id = visitor_info.V_Id 
            WHERE identitycard_letter.ID_Visibility = 'visible' AND identitycard_letter.W_Id = '$WORKID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST["action"] == "updateLetter"){

    $validator_ml_update_id = array('success' => false, 'messages' => array());

    $IDL_TO = $_POST["letter_to"];
    $IDL_SUBJECT = $_POST["letter_subject"];
    $IDL_DETAIL = $_POST["letter_detail"];
    $IDL_SIGN = $_POST["letter_sign"];
    $IDL_Id = $_POST["id"];
    $VId = $_POST["visitor_id"];
    $WId = $_POST["work_id"];
    $U_ID = $_POST["U_ID"];

    $sql_update = "UPDATE `identitycard_letter` SET `ID_LTitle`='$IDL_TO',`ID_LSubject`='$IDL_SUBJECT',
                 `ID_LDetail`='$IDL_DETAIL',`ID_LSign`='$IDL_SIGN' WHERE `ID_Id`='$IDL_Id';";

    $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';";  
    
    $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Edit and Update Identity Card Letter','{$VId}','{$WId}')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update_id['success'] = true;
        $validator_ml_update_id['messages'] = 'Successfully Update Identity Card Letter Detail';
    }else{
        $validator_ml_update_id['success'] = false;
        $validator_ml_update_id['messages'] = 'Error Update Identity Card Letter Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update_id);


}else if($_POST["action"] == "uploadFile"){

    // print_r($_POST);
    // echo "asdas";

    $RC_Id = $_POST["IDl_id"];
    $WId = $_POST["W_ID"];
    $VId = $_POST["visitor_id"];
    $U_ID = $_POST["U_ID"];
    $C_DATE = date("Y-m-d");


    $documentName = "IdentityCardLetter-".$RC_Id."-".$_FILES["final_document"]["name"];
    $target_dir_ml_letter = "../../image/Work_File/identityc_letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["final_document"]["size"] > 500000) {
        echo "File size should not be greated than 500Kb";       
    }else{
        //Upload Profile Image
        if(move_uploaded_file($_FILES["final_document"]["tmp_name"], $target_file_ml_letter)) {

                $sql_upload = "UPDATE `identitycard_letter` SET `ID_CDate`= '{$C_DATE}', 
                                `ID_FLetter`='{$documentName}' WHERE `ID_Id`= '{$RC_Id}';";

                $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Upload Identity Card Complete Letter','{$VId}','{$WId}')";
            
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