<?php

require_once 'config.php';

//if form is submitted
if($_POST) {

    $validator = array('success' => false, 'messages' => array());

    $U_ID = $_POST['user_id'];

    $Id = $_POST['connector_Id_up'];
    $ANAME = $_POST['connector_name_up'];
    $APHONE = $_POST['connector_phone_up'];
    $AEMAIL = $_POST['connector_email_up'];
    $AADDRESS = $_POST['connector_address_up'];
    $AGENDER = $_POST['connector_gender_up'];
    $ADOB = $_POST['connector_dob_up'];
    $ACITY = $_POST['connector_city_up'];
    $APINCODE = $_POST['connector_pincode_up'];
    $ASTATUS = $_POST['connector_status_up'];
    // $ADEPARTMENT = $_POST['adhikari_department'];
    $AOCCUPATION = $_POST['connector_occupation_up'];

    // `CO_Id`, `CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`, `CO_Address`,
    // `CO_City`, `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`, `CO_Profile_img`

    $sql = "UPDATE `connector_info` SET `CO_Name` = '$ANAME', `CO_Phone` = '$APHONE', `CO_Mail` = '$AEMAIL',
                                   `CO_Gender` = '$AGENDER', `CO_Dob` = '$ADOB', `CO_Address` = '$AADDRESS',
                                   `CO_City` = '$ACITY', `CO_Pincode` = '$APINCODE', `CO_Status` = '$ASTATUS',
                                   `CO_Occupation` = '$AOCCUPATION'
                                    WHERE `CO_Id` = $Id";
    $query = $con->query($sql);

    if($query === TRUE) {

        $msg = "Edit and Update Connector Detail of Id ".$Id;

        $sql_ul_d = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                        VALUES ('{$U_ID}','{$msg}')";

        if($con->query($sql_ul_d)){
            $validator['success'] = true;
            $validator['messages'] = "Successfully Updated Connector Detail";
        }else{
            $validator['success'] = false;
            $validator['messages'] = "Error to add user log".$con->error;
        }


        if($_FILES["connector_profile_up"]["name"] != "") {

            if($_FILES["connector_profile_up"]["size"] < 500000){
                $profileImageName = $Id."-".$_FILES["connector_profile_up"]["name"];
                $target_dir_visitor = "../image/Connector_Profile/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["connector_profile_up"]["tmp_name"], $target_file_visitor_img)) {

                    $sql_ap = "UPDATE `connector_info` SET `CO_Profile_img`= '{$profileImageName}' WHERE `CO_Id` = '{$Id}';";

                    $msg_ap = "Upload Profile Photo of Connector with id ".$Id;

                    $sql_ap .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                                VALUES ('{$U_ID}','{$msg_ap}')";

                    if($con->multi_query($sql_ap)){

                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and update ".$Id;

                    } else {
                            $validator['success'] = true;
                            $validator['messages'] = "Data added sucessful and not update profile ".$con->error;

                    }
                }else {
                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and not upload profile ".$con->error;
                }
            }else {

                $validator['success'] = true;
                $validator['messages'] = "Data added sucessful but Image size should not be greated than 500Kb".$Id;
            }
        }


    } else {
        $validator['success'] = false;
        $validator['messages'] = "Error while adding the member information".$con->error;
    }

    // close the database connection
    $con->close();

    echo json_encode($validator);

}

?>
