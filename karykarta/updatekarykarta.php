<?php

require_once 'config.php';

//if form is submitted
if($_POST) {

    $validator = array('success' => false, 'messages' => array());

    $Id = $_POST['karykarta_Id'];
    $U_ID = $_POST['user_id'];
    $KNAME= $_POST['karykarta_name'];
    $KPHONE= $_POST['karykarta_phone'];
    $KEMAIL= $_POST['karykarta_email'];
    $KADDRESS= $_POST['karykarta_address'];
    $KGENDER= $_POST['karykarta_gender'];
    $KDOB= $_POST['karykarta_dob'];
    $KCITY= $_POST['karykarta_city_up'];
    $KPINCODE= $_POST['karykarta_pincode'];
    $KSTATUS= $_POST['karykarta_status'];
    $KDEPARTMENT= $_POST['karykarta_department'];

    // `Id`, `Name`, `Phone`, `Email`, `Gender`, `Dob`, `Address`, `City`, `Pincode`, `Status`, `Department`

    $sql = "UPDATE `karykarta` SET `K_Name` = '$KNAME', `K_Phone` = '$KPHONE', `K_Email` = '$KEMAIL',
                                   `K_Gender` = '$KGENDER', `K_Dob` = '$KDOB', `K_Address` = '$KADDRESS',
                                   `K_City` = '$KCITY', `K_Pincode` = '$KPINCODE', `K_Status` = '$KSTATUS',
                                   `K_Department` = '$KDEPARTMENT'
                                    WHERE `K_Id` = '$Id'";

    $query = $con->query($sql);

    if($query === TRUE) {

        $sql_ul_d = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `K_Id`)
        VALUES ('{$U_ID}','Edit and Update Karykarta Detail','{$Id}')";

        if($con->query($sql_ul_d)){
            $validator['success'] = true;
            $validator['messages'] = "Successfully Updated Detail";
        }else{
            $validator['success'] = false;
            $validator['messages'] = "Error to add user log".$con->error;
        }

        if($_FILES["karykarta_profile"]["name"] != "") {

            if($_FILES["karykarta_profile"]["size"] < 500000){
                $profileImageName = $Id."-".$_FILES["karykarta_profile"]["name"];
                $target_dir_visitor = "../image/Karykarta_Profile/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["karykarta_profile"]["tmp_name"], $target_file_visitor_img)) {

                    $sql_kp = "UPDATE `karykarta` SET `K_Profile_Img` = '{$profileImageName}' WHERE `K_Id`= '{$Id}';";

                    $sql_kp .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `K_Id`)
                            VALUES ('{$U_ID}','Upload Profile Photo of Karykarta','{$Id}')";

                    if($con->multi_query($sql_kp)){

                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and update user Profile for ID ".$Id;

                    }else {
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
