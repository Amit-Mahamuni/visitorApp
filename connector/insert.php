<?php

    require_once "config.php";

    if($_POST){

      // print_r($_POST);

        $validator = array('success' => false, 'messages' => array());

        $U_ID= $_POST['user_id'];

        $ANAME = $_POST['connector_name'];
        $APHONE = $_POST['connector_phone'];
        $AEMAIL = $_POST['connector_email'];
        $AADDRESS = $_POST['connector_address'];
        $AGENDER = $_POST['connector_gender'];
        $ADOB = $_POST['connector_dob'];
        $ACITY = $_POST['connector_city'];
        $APINCODE = $_POST['connector_pincode'];
        $ASTATUS = $_POST['connector_status'];
        // $ADEPARTMENT = $_POST['adhikari_department'];
        $AOCCUPATION = $_POST['connector_occupation'];

        // INSERT INTO `connector_info`(`CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`,
        //             `CO_Address`, `CO_City`, `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`)
        // VALUES ('$ANAME','$APHONE','$AEMAIL','$AGENDER','$ADOB','$AADDRESS','$ACITY','$APINCODE','$AOCCUPATION',
        //             '$ASTATUS','visible')


        $SQL_INSERT = "INSERT INTO `connector_info`(`CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`,
                            `CO_Address`, `CO_City`, `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`)
                        VALUES ('$ANAME','$APHONE','$AEMAIL','$AGENDER','$ADOB','$AADDRESS','$ACITY','$APINCODE',
                          '$AOCCUPATION','$ASTATUS','visible')";

        // $query = $con->query($SQL_INSERT);

        if($con->query($SQL_INSERT))
        {
            $last_kid = mysqli_insert_id($con);

            $Msg = "Add New Connector with Id : ".$last_kid;

            $SQL_UL = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                        VALUES ('{$U_ID}','{$Msg}')";

            if($con->query($SQL_UL)){
                $validator['success'] = true;
                $validator['messages'] = "Successfully Add Connector Detail";

            }else{
                $validator['success'] = false;
                $validator['messages'] = "Error to add data".$con->error;
            }

            if($_FILES["connector_profile"]["name"] != "") {

                if($_FILES["connector_profile"]["size"] < 500000){
                    $profileImageName = $last_kid."-".$_FILES["connector_profile"]["name"];
                    $target_dir_visitor = "../image/Connector_Profile/";
                    $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                    if(move_uploaded_file($_FILES["connector_profile"]["tmp_name"], $target_file_visitor_img)) {

                        $sql = "UPDATE `connector_info` SET `CO_Profile_img`= '{$profileImageName}' WHERE `CO_Id` = '{$last_kid}'";

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
