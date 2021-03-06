<?php

require_once "config.php";



if(isset($_POST)){

    $validator = array('success' => false, 'messages' => array());

    // print_r($_POST);
//     // echo "file is ".;
    $U_ID = $_POST["user_id"];

    $VID = $_POST["visitor_id"];
    $VVOTERINFO = $_POST["visitor_voter"];
    $VTYPE = $_POST["visitor_type"];
    $VNAME = $_POST["visitor_name"];
    $VPHONE = $_POST["visitor_phone"];
    $VEMAIL = $_POST["visitor_email"];
    $VGENDER = $_POST["visitor_gender"];
    $VDOB = $_POST["visitor_dob"];
    $VADDR = $_POST["visitor_address"];
    $VCITY = $_POST["visitor_city"];  
    $VPINCODE = $_POST["visitor_pincode"];
    // $VCAT = $_POST["visitor_category"];
    $VADHARCARD = $_POST["v_adhar_card"];
    $VVOTERCARD = $_POST["v_voter_card"];
    $VPANCARD = $_POST["v_pan_card"];




 
    $sql =  "UPDATE `visitor_info` SET `V_Name`= '$VNAME',`V_Phone`='$VPHONE',`V_Email`='$VEMAIL',
            `V_Dob`='$VDOB',`V_Gender`='$VGENDER',`V_Address`='$VADDR',`V_City`='$VCITY',
            `V_Pincode`= '$VPINCODE',`V_Type`='$VTYPE', `V_Voter`='$VVOTERINFO',
            `V_Visibility`='visible', `V_Adhar_Card`='$VADHARCARD',
            `V_Voter_Card`='$VVOTERCARD',`V_Pan_Card`='$VPANCARD' WHERE `V_Id`='$VID'";

    $query = $con->query($sql);
 
    if($query === TRUE) {          
        // echo " sucessfully update data"; 

        if(isset($_POST["refernce_name"]) && $_POST["refernce_name"] != "" && isset($_POST["refernce_id"]) && $_POST["refernce_id"] != ""){

            $RID = $_POST["refernce_id"];
            $RNAME = $_POST["refernce_name"];
            $RDOB = $_POST["refernce_dob"];
            $RGENDER = $_POST["refernce_gender"];
            $ROCCUP = $_POST["refernce_occupation"];
            $RADDR = $_POST["refernce_address"];
            $RPHONE = $_POST["refernce_phone"];

            $sql_ref =  "UPDATE `reference_detail` SET `R_Name`= '$RNAME',`R_Phone`='$RPHONE',`R_Dob`='$RDOB',
            `R_Gender`='$RGENDER',`R_Occupation`='$ROCCUP',`R_Address`='$RADDR' WHERE `V_Id`='$VID' AND `R_Id`='$RID'";
    
            $query_ref = $con->query($sql_ref);

            if($query_ref === TRUE){
                $validator['success'] = true;
                $validator['messages'] = 'Successfully Update Visitor & Refernce Detail ';
    
            }else{
                $validator['success'] = false;
                $validator['messages'] = 'Error To Update Refernce Detail'.$con->error;
    
            }

        }

        $validator['success'] = true;
        $validator['messages'] = 'Successfully Update Visitor Detail';



  



        if($_FILES["visitor_profile"]["name"] != "" ){

            // print_r($_FILES["visitor_profile"]);

            $profileImageName = date("dmY")."-".$_FILES["visitor_profile"]["name"];
            $target_dir_visitor = "../image/Visitor_Profile/";
            $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

            if($_FILES["visitor_profile"]["size"] > 200000) {

                // echo "visitor Image size should not be greated than 200Kb";

                $validator['success'] = false;
                $validator['messages'] = 'Successfully Update Visitor Detail But visitor Image size should not be greated than 200Kb'.$con->error;
            }
            else{
                // echo "final file name".$profileImageName;

                if(move_uploaded_file($_FILES["visitor_profile"]["tmp_name"], $target_file_visitor_img)) {

                    $sql_upload_img = "UPDATE `visitor_info` SET `Visitor_Profile`= '{$profileImageName}' WHERE `V_Id`= '{$VID}'";
                   
                   if($con->query($sql_upload_img)){

                    //    echo "Image uploaded and saved in the Database".$con->error;
                       // echo $con->error;

                        $validator['success'] = true;
                        $validator['messages'] = 'Successfully Update Visitor Detail also Image uploaded and saved in the Database ';
                     
                   } else {
                    //    echo "There was an error in the database".$con->error;
                        $validator['success'] = false;
                        $validator['messages'] = 'Successfully Update Visitor Detail But There was an error in the database for Image Upload'.$con->error;
                     
                   }
                } else {
                //    echo "There was an erro uploading the file".$con->error;
                    $validator['success'] = false;
                    $validator['messages'] = 'There was an erro uploading the file'.$con->error;    

               }
            }

        }


        $sql_ul = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`) 
                    VALUES ('{$U_ID}','Edit and Update Visitor Details','{$VID}')";

        if($con->query($sql_ul)){

        }else{
            $validator['success'] = false;
            $validator['messages'] = 'There was an erro to '.$con->error;    
        }

     
    } else {  
//         echo " fail to update data".$con->error;      
        $validator['success'] = false;
        $validator['messages'] = "Error while Updating the Visitor information".$con->error;
    }
 

}
else{
    // echo " fail to get data".$con->error;
    $validator['success'] = false;
    $validator['messages'] = "Fail to get data".$con->error;
}

echo json_encode($validator);


$con->close();

?>