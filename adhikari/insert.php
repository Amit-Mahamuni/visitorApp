<?php

    require_once "config.php";

    if($_POST){

        $validator = array('success' => false, 'messages' => array());

        $U_ID= $_POST['user_id'];

        $ANAME = $_POST['adhikari_name'];
        $APHONE = $_POST['adhikari_phone'];
        $AEMAIL = $_POST['adhikari_email'];
        $AADDRESS = $_POST['adhikari_address'];
        $AGENDER = $_POST['adhikari_gender'];
        $ADOB = $_POST['adhikari_dob'];
        $ACITY = $_POST['adhikari_city'];
        $APINCODE = $_POST['adhikari_pincode'];
        $ASTATUS = $_POST['adhikari_status'];
        $ADEPARTMENT = $_POST['adhikari_department'];
        $AOCCUPATION = $_POST['adhikari_occupation']; 


        $SQL_INSERT = "INSERT INTO `adhikari_info`(`AD_Name`, `AD_Phone`, `AD_Email`, `AD_Address`, `AD_City`, `AD_Pincode`, 
                        `AD_Department`,`AD_Occupation`, `AD_Status`, `AD_Visibility`, `AD_GENDER`, `AD_Dob`) 
                        VALUES ('$ANAME','$APHONE','$AEMAIL','$AADDRESS','$ACITY','$APINCODE','$ADEPARTMENT','$AOCCUPATION',
                        '$ASTATUS','visible','$AGENDER','$ADOB')";

        // $query = $con->query($SQL_INSERT);

        if($con->query($SQL_INSERT))
        {
            $last_kid = mysqli_insert_id($con);

            $Msg = "Add New Adhikari to Department ".$ADEPARTMENT." with Id : ".$last_kid;

            $SQL_UL = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                        VALUES ('{$U_ID}','{$Msg}')";

            if($con->query($SQL_UL)){
                $validator['success'] = true;
                $validator['messages'] = "Successfully Add Adhikari Detail"; 

            }else{
                $validator['success'] = false;
                $validator['messages'] = "Error to add data".$con->error;
            }

            if($_FILES["adhikari_profile"]["name"] != "") {

                if($_FILES["adhikari_profile"]["size"] < 500000){
                    $profileImageName = $last_kid."-".$_FILES["adhikari_profile"]["name"];
                    $target_dir_visitor = "../image/Adhikari_Profile/";
                    $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);
    
                    if(move_uploaded_file($_FILES["adhikari_profile"]["tmp_name"], $target_file_visitor_img)) {                     
                        
                        $sql = "UPDATE `adhikari_info` SET `AD_Profile_img`= '{$profileImageName}' WHERE `AD_Id` = '{$last_kid}'";
                    
                        if($con->query($sql)){
    
                            $validator['success'] = true;
                            $validator['messages'] = "Data added sucessful and update ".$last_kid;
    
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
                    $validator['messages'] = "Data added sucessful but Image size should not be greated than 500Kb with".$last_kid;
                }            
            }


        }
        else{
            $validator['success'] = false;
            $validator['messages'] = "Error to add data".$con->error;
            
        }
        
    }


    $con->close();
    echo json_encode($validator);

?> 