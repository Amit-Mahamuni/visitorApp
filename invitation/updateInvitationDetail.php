<?php

require_once "config.php";



if(isset($_POST)){

    $validator = array('success' => false, 'messages' => array());

    $I_ID = $_POST["i_id"];
    $WID = $_POST["w_id"];
    $VID = $_POST["v_id"];
    $U_ID = $_POST["user_id"];
    $IDATE = $_POST["invitation_date"];
    $ITIME = $_POST["invitation_time"];
    $IADDRESS = $_POST["invitation_address"];
    $ITYPE = $_POST["invitation_type"];
    $ISTATUS = $_POST["invitation_status"];
    $ITITLE = $_POST["invitation_title"];

    if($ITYPE == "Wedding"){

        $WBOYNAME = $_POST["Wedding_Boy_Name"];
        $WGNAME = $_POST["Wedding_Girl_Name"];

        $sql =  "UPDATE `invitation` SET `I_Title`='$ITITLE',`I_Address`='$IADDRESS',
                `I_Date`='$IDATE',`I_Time`='$ITIME',`I_Status`='$ISTATUS',`WI_BName`='$WBOYNAME',
                `WI_GName`='$WGNAME' WHERE `I_Id`= '$I_ID' AND `W_Id`= '$WID';";

    }else{

        $sql =  "UPDATE `invitation` SET `I_Title`='$ITITLE',`I_Address`='$IADDRESS',
                `I_Date`='$IDATE',`I_Time`='$ITIME',`I_Status`='$ISTATUS' WHERE `I_Id`= '$I_ID' AND `W_Id`= '$WID';";
    }

    $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`)
                VALUES ('{$U_ID}','Edit and Update Invitation Details','{$VID}','{$WID}')";



    $query = $con->multi_query($sql);

    if($query === TRUE) {

        $validator['success'] = true;
        $validator['messages'] = "Sucessfully Data Update";


        if($_FILES["invitation_profile"] != ""){

            $profileImageName = "WI".$I_ID."-".$WID."-".$_FILES["invitation_profile"]["name"];
            $target_dir_visitor = "../image/Work_File/";
            $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

            if($_FILES["invitation_profile"]["size"] > 200000) {

                $validator['success'] = false;
                $validator['messages'] = 'Successfully Update Invitation Detail But Invitation Image size should not be greated than 200Kb'.$con->error;
            }
            else{

                if(move_uploaded_file($_FILES["invitation_profile"]["tmp_name"], $target_file_visitor_img)) {


                    $sql_upload_img = "UPDATE `work_detail` SET `Work_Doc`= '$profileImageName' WHERE `W_Id`= '$WID'";

                   if($con->query($sql_upload_img)){

                        $validator['success'] = true;
                        $validator['messages'] = 'Successfully Update Invitation Detail also Image uploaded and saved in the Database ';

                   } else {

                        $validator['success'] = false;
                        $validator['messages'] = 'Successfully Update Invitation Detail But There was an error to update in table'.$con->error;

                   }
                } else {

                    $validator['success'] = false;
                    $validator['messages'] = 'Successfully Update Invitation Detail '.$con->error;


               }
            }

        }


    } else {

        $validator['success'] = false;
        $validator['messages'] = "Error while Updating the Invitation information".$con->error;
    }


}else{

    $validator['success'] = false;
    $validator['messages'] = "Fail to get data".$con->error;
}

echo json_encode($validator);

$con->close();

?>
