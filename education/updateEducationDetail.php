<?php

require_once "config.php";



if(isset($_POST)){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());


    $I_ID = $_POST["e_id"];
    $WID = $_POST["w_id"];
    $VID = $_POST["v_id"];
    $U_ID = $_POST["user_id"];
    $ESNAME = $_POST["student_name"];
    $ECNAME = $_POST["collage_Name"];
    $ESCLASS = $_POST["student_class"];
    $ETFEE = $_POST["student_fee_total"];
    $EDFEE = $_POST["student_discount_fee"];

    // UPDATE `education_info` SET `E_Student_Name`='$ESNAME',`E_Collage_Name`='$ECNAME',
    // `E_Class`='$ESCLASS',`E_T_Fee`='$ETFEE',`E_D_Fee`='$EDFEE',
    // WHERE `E_Id`='$I_ID' AND `W_Id`='$WID'


        $sql_e_u =  "UPDATE `education_info` SET `E_Student_Name`='$ESNAME', `E_Collage_Name`='$ECNAME',
                    `E_Class`='$ESCLASS', `E_T_Fee`='$ETFEE', `E_D_Fee`='$EDFEE'
                    WHERE `E_Id`='$I_ID' AND `W_Id`='$WID';";

        $sql_e_u .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                        VALUES ('{$U_ID}','Edit and Update Education Detail','{$VID}','{$WID}')";

    $query = $con->multi_query($sql_e_u);
 
    if($query === TRUE) {          

        $validator['success'] = true;
        $validator['messages'] = "Sucessfully Data Update";


        if($_FILES["student_profile"] != ""){

            // print_r($_FILES["visitor_profile"]);

            $profileImageName = "WI".$I_ID."-".$WID."-".$_FILES["student_profile"]["name"];
            $target_dir_visitor = "../image/Work_File/";
            $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

            if($_FILES["student_profile"]["size"] > 200000) {

                $validator['success'] = false;
                $validator['messages'] = 'Successfully Update Education Detail But Education Image size should not be greated than 200Kb'.$con->error;
            }
            else{

                if(move_uploaded_file($_FILES["student_profile"]["tmp_name"], $target_file_visitor_img)) {
                    

                    $sql_upload_img = "UPDATE `work_detail` SET `Work_Doc`= '$profileImageName' WHERE `W_Id`= '$WID'";
                   
                   if($con->query($sql_upload_img)){

                        $validator['success'] = true;
                        $validator['messages'] = 'Successfully Update Education Detail also Image uploaded and saved in the Database ';
                     
                   } else {

                        $validator['success'] = false;
                        $validator['messages'] = 'Successfully Update Education Detail But There was an error to update in table'.$con->error;
                     
                   }
                } else {

                    $validator['success'] = false;
                    $validator['messages'] = 'Successfully Update Education Detail '.$con->error;

           
               }
            }

        }




     
    } else {  
//         echo " fail to update data".$con->error;      
        $validator['success'] = false;
        $validator['messages'] = "Error while Updating the Invitation information".$con->error;
    }
 

}else{
    // echo " fail to get data".$con->error;
    $validator['success'] = false;
    $validator['messages'] = "Fail to get data".$con->error;
}

echo json_encode($validator);


$con->close();

?>