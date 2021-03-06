<?php

    require_once "config.php";

    if($_POST){

        $validator = array('success' => false, 'messages' => array());

        $U_ID= $_POST['user_id'];

        $UNAME= $_POST['karykarta_name'];
        $UPHONE= $_POST['karykarta_phone'];
        $UEMAIL= $_POST['karykarta_email'];
        $UADDRESS= $_POST['karykarta_address'];
        $UGENDER= $_POST['karykarta_gender'];
        $UDOB= $_POST['karykarta_dob'];
        $UCITY= $_POST['karykarta_city'];
        $UPINCODE= $_POST['karykarta_pincode'];
        $USTATUS= $_POST['karykarta_status'];
        $UDEPARTMENT= $_POST['karykarta_department'];
        $USERNAME = $_POST['user_name'];
        $UPASSWORD = $_POST['user_password'];  


        $SQL_INSERT = "INSERT INTO `user_info`(`U_Username`, `U_Password`, `U_Status`, `U_Department`, `U_Name`, `U_Phone`, 
                                `U_Email`, `U_Gender`, `U_Dob`, `U_Address`, `U_City`, `U_Pincode`, `U_Visibility`) 
                        VALUES ('$USERNAME', '$UPASSWORD', '$USTATUS', '$UDEPARTMENT', '$UNAME', '$UPHONE', '$UEMAIL', '$UGENDER', '$UDOB', 
                            '$UADDRESS', '$UCITY', '$UPINCODE', 'visible')";

        if($con->query($SQL_INSERT))
        {
            $last_kid = mysqli_insert_id($con);

            $Msg = "Add New User to Department ".$UDEPARTMENT;

            $SQL_UL = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `U_Id_On`) 
                        VALUES ('{$U_ID}','{$Msg}','{$last_kid}')";

            if($con->query($SQL_UL)){
                $validator['success'] = true;
                $validator['messages'] = "Data added sucessful and update with ID ".$last_kid;

            }else{
                $validator['success'] = false;
                $validator['messages'] = "Error to add user log".$con->error;
            }

            

            if($_FILES["karykarta_profile"]["name"] != "") {

                if($_FILES["karykarta_profile"]["size"] < 400000){
                    $profileImageName = $last_kid."-".$_FILES["karykarta_profile"]["name"];
                    $target_dir_visitor = "../image/User_Profile/";
                    $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);
    
                    if(move_uploaded_file($_FILES["karykarta_profile"]["tmp_name"], $target_file_visitor_img)) {                  
    
                        $sql = "UPDATE `user_info` SET `U_Profile_Img` = '{$profileImageName}' WHERE `U_Id`= '{$last_kid}'";
                    
                        if($con->query($sql)){
    
                            $validator['success'] = true;
                            $validator['messages'] = "Data and Profile Image added sucessful and update ".$last_kid;
    
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
                    $validator['messages'] = "Data added sucessful but Image size should not be greated than 400Kb with".$last_kid;
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