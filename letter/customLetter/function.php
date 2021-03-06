<?php

require_once "config.php";

if($_POST['action'] == "getdefaultData"){

    $CL_Id = "1";

    $output = array('data' => array());    

    $sql = "SELECT `CL_Id`, `CL_Title`, `CL_LTo`, `CL_LSubject`, `CL_LDetail`, `CL_LSign` FROM `custom_letter` WHERE `CL_Id` = $CL_Id";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST["action"] == "getVisitorData"){

    $WORKID = $_POST["Work_Id"];

    $sql = "SELECT  custom_letter.CL_Id, custom_letter.CL_Title, custom_letter.CL_LTo, custom_letter.CL_LSubject, custom_letter.CL_LDetail, 
                    custom_letter.CL_LSign,custom_letter.V_Id, custom_letter.W_Id,
                    visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, 			  
                    visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode, 
                    work_detail.Work_title, work_detail.Work_Category, work_detail.Work_Subcategory, work_detail.Work_detail, 
                    work_detail.Work_add_date, work_detail.Priority, work_detail.Status
            FROM custom_letter INNER JOIN visitor_info ON custom_letter.V_Id = visitor_info.V_Id INNER JOIN work_detail 
            ON custom_letter.W_Id = work_detail.W_Id WHERE custom_letter.W_Id  = '$WORKID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST["action"] == "updateLetter"){

    $validator_ml_update_id = array('success' => false, 'messages' => array());

    $L_TITLE = $_POST["letter_title"];
    $L_TO = $_POST["letter_to"];
    $L_SUBJECT = $_POST["letter_subject"];
    $L_DETAIL = $_POST["letter_detail"];
    $L_SIGN = $_POST["letter_sign"];
    $L_Id = $_POST["id"];
    $VId = $_POST["visitor_id"];
    $WId = $_POST["work_id"];
    $U_ID = $_POST["user_id"];

    //`CL_Id`, `CL_Title`, `CL_LTo`, `CL_LSubject`, `CL_LDetail`, `CL_LSign`, `CL_FLetter`, `CL_CDate`, `CL_Visibility`, `V_Id`, `W_Id`

    $sql_update = "UPDATE `custom_letter` SET `CL_Title`='$L_TITLE', `CL_LTo`='$L_TO', `CL_LSubject`='$L_SUBJECT',
                                            `CL_LDetail`='$L_DETAIL', `CL_LSign`='$L_SIGN' WHERE `CL_Id`='$L_Id';";

    $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';";
    
    $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Create and Update Custom Letter','{$VId}','{$WId}')";

    $query_ml = $con->multi_query($sql_update);           
  
    if($query_ml === TRUE) { 
        $validator_ml_update_id['success'] = true;
        $validator_ml_update_id['messages'] = 'Successfully Update Letter Detail';
    }else{
        $validator_ml_update_id['success'] = false;
        $validator_ml_update_id['messages'] = 'Error Update Letter Detail'.$con->error; 
    }

    $con->close();

    echo json_encode($validator_ml_update_id);


}else if($_POST["action"] == "uploadFile"){

    // print_r($_POST);
    // echo "asdas";
    $U_ID = $_POST["user_id"];
    $RL_Id = $_POST["l_id"];
    $WId = $_POST["W_ID"];
    $VId = $_POST["V_ID"];
    $C_DATE = date("Y-m-d");


    $documentName = "CustomLetter-".$RL_Id."-".$_FILES["final_document"]["name"];
    $target_dir_ml_letter = "../../image/Work_File/custom_letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["final_document"]["size"] > 5000000) {
        echo "File size should not be greated than 500Kb";       
    }else{
        //Upload Profile Image
        if(move_uploaded_file($_FILES["final_document"]["tmp_name"], $target_file_ml_letter)) {

                $sql_upload = "UPDATE `custom_letter` SET `CL_CDate`= '{$C_DATE}', 
                                `CL_FLetter`='{$documentName}' WHERE `CL_Id`= '{$RL_Id}';";

                $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                VALUES ('{$U_ID}','Upload Complete Letter','{$VId}','{$WId}')";
            
            if($con->multi_query($sql_upload)){

                echo "Image uploaded and saved in the Database".$C_DATE;
           
            } else {
                echo "There was an erro uploading the file".$con->error;              
            }
        }else {
            echo "There was an erro uploading the file".$con->error;    
        }

    }

}


?>