<?php

require_once "config.php";

    $validator = array('success' => false, 'messages' => array());

    $PNAME = $_POST["proposal_name"];
    $PPHONE = $_POST["proposal_phone"];
    $PTO = $_POST["proposal_to"];
    $PSUBJECT = $_POST["proposal_subject"];
    $PDETAIL = $_POST["proposal_detail"];
    $PNOTE = $_POST["proposal_note"];
    $USERID = $_POST["user_id"];

    if(isset($_POST["proposal_id"]) && $_POST["proposal_id"] != ""){

        $PID = $_POST["proposal_id"];
        $PSTATUS = $_POST["proposal_status"];
        $PPRIORITY = $_POST["proposal_priority"];  

        if($_POST["proposal_status"] == 'Complete'){

            $DATE = date("Y-m-d");

            $SQL_PROPOSAL = "UPDATE `proposal_info` SET `P_Name`= '$PNAME',`P_Phone`='$PPHONE',`P_To`='$PTO',
            `P_Subject`='$PSUBJECT',`P_Detail`='$PDETAIL',`P_End`='$PEND',`P_Note`='$PNOTE', `P_CDate`='$DATE',
            `P_Status`='$PSTATUS', `P_Priority`='$PPRIORITY' WHERE  `P_Id` = '$PID'";

        }else{

            $SQL_PROPOSAL = "UPDATE `proposal_info` SET `P_Name`= '$PNAME',`P_Phone`='$PPHONE',`P_To`='$PTO',
            `P_Subject`='$PSUBJECT',`P_Detail`='$PDETAIL',`P_End`='$PEND',`P_Note`='$PNOTE',
            `P_Status`='$PSTATUS', `P_Priority`='$PPRIORITY' WHERE  `P_Id` = '$PID'";

        }

        if($con->query($SQL_PROPOSAL)){

            $last_pid = $PID;

        }else{

            $validator['messages'] = "Error For Data added ".$con->error;
        }

    }else{

        $SQL_PROPOSAL = "INSERT INTO `proposal_info`(`P_Name`, `P_Phone`, `P_To`, `P_Subject`, `P_Detail`, `P_Note`, `P_Status`, `P_Visibility`, `P_Priority` )  
                    VALUES ('{$PNAME}','{$PPHONE}','{$PTO}','{$PSUBJECT}','{$PDETAIL}','{$PNOTE}', 'Pending', 'visible', 'Low')";

        if($con->query($SQL_PROPOSAL)){

            $last_pid = mysqli_insert_id($con);

        }else{

            $validator['messages'] = "Error For Data added ".$con->error;
        }

    }

    if($last_pid != ""){

        if($_FILES["doc_pre_file"]["name"] != "") {

            if($_FILES["doc_pre_file"]["size"] < 500000){

                $profileImageName = $last_pid."-".$_FILES["doc_pre_file"]["name"];
                $target_dir_visitor = "../image/proposal/document/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["doc_pre_file"]["tmp_name"], $target_file_visitor_img)) {              

                    $sql_up = "UPDATE `proposal_info` SET `P_Doc`= '{$profileImageName}' WHERE `P_Id`= '{$last_pid}'";
                
                    if($con->query($sql_up)){

                        $validator['success'] = true;
                        $validator['messages'] = "Data added sucessful and update ".$con->error;

                    } else {   

                        $validator['success'] = false;
                        $validator['messages'] = "There was an error in the database".$con->error;

                    }

                } else {

                        $validator['success'] = false;
                        $validator['messages'] = "Visitor Image not uploaded to DataBase".$con->error;  

                }
            }else {

                    $validator['success'] = true;
                    $validator['messages'] = "Visitor Data Added.Image size should not be greated than 500Kb with".$con->error;
               
            }            
        }

        if(isset($_POST["user_id"]) && $USERID !=""){

            $sql_ul_ref = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `P_Id`) 
                            VALUES ('{$USERID}','Create a New Proposal Letter', '{$last_pid}')";

            if($con->query($sql_ul_ref)){

            }else{
                $validator['success'] = true;
                $validator['messages'] .= "Error to update user Log to work id<br>".$con->error;
            }
            
        }

        $validator['success'] = true;
        $validator['messages'] = "Data added sucessful ".$con->error;

    }else{
        $validator['success'] = false;
        $validator['messages'] = "Error For Data added ".$con->error;
    }

    echo json_encode($validator);

    $con->close();

?>