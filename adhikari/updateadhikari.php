<?php

require_once 'config.php';
 
//if form is submitted
if($_POST) {    
 
    $validator = array('success' => false, 'messages' => array());

    $U_ID = $_POST['user_id'];
 
    $Id = $_POST['adhikari_Id_up'];
    $ANAME = $_POST['adhikari_name_up'];
    $APHONE = $_POST['adhikari_phone_up'];
    $AEMAIL = $_POST['adhikari_email_up'];
    $AADDRESS = $_POST['adhikari_address_up'];
    $AGENDER = $_POST['adhikari_gender_up'];
    $ADOB = $_POST['adhikari_dob_up'];
    $ACITY = $_POST['adhikari_city_up'];
    $APINCODE = $_POST['adhikari_pincode_up'];
    $ASTATUS = $_POST['adhikari_status_up'];
    $ADEPARTMENT = $_POST['adhikari_department_up'];
    $AOCCUPATION = $_POST['adhikari_occupation_up']; 

    // `AD_Id`, `AD_Name`, `AD_Phone`, `AD_Email`, `AD_GENDER`, `AD_Dob`, `AD_Address`, `AD_City`, `AD_Pincode`, 
    // `AD_Department`, `AD_SubDepartment`, `AD_Occupation`, `AD_Status`, `AD_Visibility`, `AD_Profile_img` FROM `adhikari_info`
 
    $sql = "UPDATE `adhikari_info` SET `AD_Name` = '$ANAME', `AD_Phone` = '$APHONE', `AD_Email` = '$AEMAIL',
                                   `AD_GENDER` = '$AGENDER', `AD_Dob` = '$ADOB', `AD_Address` = '$AADDRESS',
                                   `AD_City` = '$ACITY', `AD_Pincode` = '$APINCODE', `AD_Status` = '$ASTATUS',
                                   `AD_Department` = '$ADEPARTMENT', `AD_Occupation` = '$AOCCUPATION'
                                    WHERE `AD_Id` = $Id";
    $query = $con->query($sql);
 
    if($query === TRUE) {  
        
        $msg = "Edit and Update Adhikari Detail of Id ".$Id;
        
        $sql_ul_d = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                        VALUES ('{$U_ID}','{$msg}')";

        if($con->query($sql_ul_d)){
            $validator['success'] = true;
            $validator['messages'] = "Successfully Updated Adhikari Detail"; 
        }else{
            $validator['success'] = false;
            $validator['messages'] = "Error to add user log".$con->error;
        }
 
        
        if($_FILES["adhikari_profile_up"]["name"] != "") {

            if($_FILES["adhikari_profile_up"]["size"] < 500000){
                $profileImageName = $Id."-".$_FILES["adhikari_profile_up"]["name"];
                $target_dir_visitor = "../image/Adhikari_Profile/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["adhikari_profile_up"]["tmp_name"], $target_file_visitor_img)) {                  

                    $sql_ap = "UPDATE `adhikari_info` SET `AD_Profile_img`= '{$profileImageName}' WHERE `AD_Id` = '{$Id}';";

                    $msg_ap = "Upload Profile Photo of Adhikari with id".$Id;

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