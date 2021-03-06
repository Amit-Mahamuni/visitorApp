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

    // `U_Id`, `U_Username`, `U_Password`, `U_Status`, `U_Department`, `U_Name`, `U_Phone`, 
    // `U_Email`, `U_Gender`, `U_Dob`, `U_Address`, `U_City`, `U_Pincode`, `U_Visibility`, `U_Profile_Img`
 
    $sql = "UPDATE `user_info` SET `U_Name` = '$KNAME', `U_Phone` = '$KPHONE', `U_Email` = '$KEMAIL',
                                   `U_Gender` = '$KGENDER', `U_Dob` = '$KDOB', `U_Address` = '$KADDRESS',
                                   `U_City` = '$KCITY', `U_Pincode` = '$KPINCODE', `U_Status` = '$KSTATUS',
                                   `U_Department` = '$KDEPARTMENT'
                                    WHERE `U_Id` = $Id";
    $query = $con->query($sql);
 
    if($query === TRUE) {  
        
        $sql_ul_d = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `U_Id_On`) 
        VALUES ('{$U_ID}','Edit and Update User Detail','{$Id}')";

        if($con->query($sql_ul_d)){
            $validator['success'] = true;
            $validator['messages'] = "Successfully Update User Detail"; 
        }else{
            $validator['success'] = false;
            $validator['messages'] = "Error to add user log".$con->error;
        } 
        
        if($_FILES["karykarta_profile"]["name"] != "") {

            if($_FILES["karykarta_profile"]["size"] < 500000){
                $profileImageName = $Id."-".$_FILES["karykarta_profile"]["name"];
                $target_dir_visitor = "../image/User_Profile/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["karykarta_profile"]["tmp_name"], $target_file_visitor_img)) {                  

                    $sql_up = "UPDATE `user_info` SET `U_Profile_Img` = '{$profileImageName}' WHERE `U_Id`= '{$Id}';";

                    $sql_up .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `U_Id_On`) 
                                VALUES ('{$U_ID}','Upload Profile Photo of User','{$Id}')";
                
                    if($con->multi_query($sql_up)){

                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and update ".$Id;

                    }else{   
                            $validator['success'] = true;
                            $validator['messages'] = "Data added sucessful and not update profile ".$con->error;

                    }
                }else{
                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and not upload profile ".$con->error;
                }
            }else{

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