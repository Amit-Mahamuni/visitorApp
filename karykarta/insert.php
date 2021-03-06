<?php

    require_once "config.php";

    if($_POST){

        $validator = array('success' => false, 'messages' => array());

        $U_ID= $_POST['user_id'];

        $KNAME= $_POST['karykarta_name'];
        $KPHONE= $_POST['karykarta_phone'];
        $KEMAIL= $_POST['karykarta_email'];
        $KADDRESS= $_POST['karykarta_address'];
        $KGENDER= $_POST['karykarta_gender'];
        $KDOB= $_POST['karykarta_dob'];
        $KCITY= $_POST['karykarta_city'];
        $KPINCODE= $_POST['karykarta_pincode'];
        $KSTATUS= $_POST['karykarta_status'];
        $KDEPARTMENT= $_POST['karykarta_department'];
        $USERNAME= $_POST['user_name'];
        $PASSWORD= $_POST['user_password'];  


        $SQL_INSERT = "INSERT INTO `karykarta`(`K_Name`, `K_Phone`, `K_Email`, `K_Gender`, `K_Dob`, `K_Address`, `K_City`, `K_Pincode`, `K_Status`, `K_Department`, `K_Visibility`, `U_Username`, `U_Password`)
                       VALUES ('$KNAME','$KPHONE','$KEMAIL','$KGENDER','$KDOB','$KADDRESS','$KCITY','$KPINCODE','$KSTATUS','$KDEPARTMENT','visible','$USERNAME','$PASSWORD')";

        // $query = $con->query($SQL_INSERT);

        if($con->query($SQL_INSERT))
        {
            $last_kid = mysqli_insert_id($con);

            $Msg = "Add New Karykarta to Department".$KDEPARTMENT;

            $SQL_UL = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `K_Id`) 
                        VALUES ('{$U_ID}','{$Msg}','{$last_kid}')";

            if($con->query($SQL_UL)){

            }else{
                $validator['success'] = false;
                $validator['messages'] = "Error to add data".$con->error;
            }

            if($_FILES["karykarta_profile"]["name"] != "") {

                if($_FILES["karykarta_profile"]["size"] < 200000){
                    $profileImageName = $last_kid."-".$_FILES["karykarta_profile"]["name"];
                    $target_dir_visitor = "../image/Karykarta_Profile/";
                    $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);
    
                    if(move_uploaded_file($_FILES["karykarta_profile"]["tmp_name"], $target_file_visitor_img)) {                  
    
                        $sql = "UPDATE `karykarta` SET `K_Profile_Img` = '{$profileImageName}' WHERE `K_Id`= '{$last_kid}'";
                    
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
                    $validator['messages'] = "Data added sucessful but Image size should not be greated than 200Kb with".$last_kid;
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