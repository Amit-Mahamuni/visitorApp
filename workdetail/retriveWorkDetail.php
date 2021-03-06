<?php

    require_once "config.php";

    if($_POST['action'] == "workdetail"){

        $workId = $_POST['work_Id'];

        $output = array('data' => array());
    
        $sql = "SELECT  work_detail.W_Id, work_detail.V_Id, work_detail.Work_title, work_detail.Priority, 
                        work_detail.Work_Category, work_detail.Work_Subcategory, work_detail.Work_detail,
                        work_detail.Work_add_date, work_detail.Work_end_date, work_detail.Status, work_detail.W_LType,
                        work_detail.AD_Id, work_detail.W_CType, work_detail.W_CCat,
                        visitor_info.V_Id, visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, 
                        visitor_info.V_Dob, visitor_info.V_Gender,visitor_info.V_Address, visitor_info.V_City,
                        visitor_info.V_Pincode, visitor_info.Visitor_Profile, visitor_info.V_Type,
                        visitor_info.V_Adhar_Card, visitor_info.V_Voter_Card, visitor_info.V_Pan_Card, visitor_info.V_Voter,
                        karykarta.K_Id, karykarta.K_Name, karykarta.K_Phone, karykarta.K_Email, karykarta.K_Status,
                        karykarta.K_Department
                FROM work_detail INNER JOIN visitor_info on work_detail.V_Id = visitor_info.V_Id 
                LEFT JOIN karykarta ON karykarta.K_Id = work_detail.K_Id WHERE work_detail.W_Id = $workId";

        // $sql = "SELECT `R_Id`, `R_Name`, `R_Phone`,`R_Dob`, `R_Gender`, `R_Occupation`, 
        //         `R_Address` FROM `reference_detail` WHERE `W_Id`= $workId";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);
    
    }else if($_POST['action'] == "refernceDetail"){

        $workId = $_POST['work_Id'];

        $sql = "SELECT `R_Id`, `R_Name`, `R_Phone`,`R_Dob`, `R_Gender`, `R_Occupation`, 
                `R_Address` FROM `reference_detail` WHERE `W_Id`= $workId";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST['action'] == "updateWork"){

        $workId = $_POST['work_Id'];
        $KID = $_POST['KID'];
        $VId = $_POST['VID'];
        $U_ID = $_POST['UID'];
        
        // echo "workId ".$workId." karykarta Id ". $KID ;
        $output = array('success' => false, 'messages' => array());
        
        $sql =  "UPDATE `work_detail` SET `K_Id`= {$KID}  WHERE `W_Id` =  {$workId};";
        $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Assign Karykarta to Work','{$VId}','{$workId}')";

        $query = $con->multi_query($sql);

        if($query === TRUE) {

            $output['success'] = true;
            $output['messages'] = 'Successfully Assign work to Karykarta';

        } else {

            $output['success'] = false;
            $output['messages'] = 'Error Assign work to Karykarta'.$con->error;

        }
        
        // close database connection
        $con->close();        
        echo json_encode($output);

    }
    else if($_POST['action'] == "removeKarykarta"){
        
        $workId = $_POST['work_Id'];
        $VId = $_POST['visitor_Id'];
        $U_ID = $_POST['UID'];
        $KID = $_POST['KID'];

        // echo "Work id is".$workId;

        $output = array('success' => false, 'messages' => array());
        
        $sql =  "UPDATE `work_detail` SET `K_Id`= null  WHERE `W_Id` =  {$workId};";

        $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`, `K_Id`) 
                    VALUES ('{$U_ID}','Remove Karykarta from Work','{$VId}','{$workId}','{$KID}')";

        $query = $con->multi_query($sql);

        if($query === TRUE) {

            $output['success'] = true;
            $output['messages'] = 'Successfully Remove Karykarta from Work';

        } else {

            $output['success'] = false;
            $output['messages'] = 'Error To Remove Karykarta from Work'.$con->error();

        }
        
        // close database connection
        $con->close();        
        echo json_encode($output);
    }else if($_POST['action'] == "updateWork_assignAdhikari"){

        $workId = $_POST['work_Id'];
        $AID = $_POST['AID'];
        $VId = $_POST['VID'];
        $U_ID = $_POST['UID'];
        $MSG = "Assign Work New Adhikari of Id is ".$AID;
        
        // echo "workId ".$workId." karykarta Id ". $KID ;
        $output = array('success' => false, 'messages' => array());
        
        $sql =  "UPDATE `work_detail` SET `AD_Id` = {$AID}  WHERE `W_Id` =  {$workId};";
        $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                    VALUES ('{$U_ID}','{$MSG}')";

        $query = $con->multi_query($sql);

        if($query === TRUE) {

            $output['success'] = true;
            $output['messages'] = 'Successfully Assign work to new Adhikari';

        } else {

            $output['success'] = false;
            $output['messages'] = 'Error Assign work to new Adhikari'.$con->error;

        }
        
        // close database connection
        $con->close();        
        echo json_encode($output);

    }
    else if($_POST['action'] == "removeAdhikari"){
        
        $workId = $_POST['work_Id'];
        $VId = $_POST['VID'];
        $U_ID = $_POST['UID'];

        // echo "Work id is".$workId;

        $output = array('success' => false, 'messages' => array());
        
        $sql =  "UPDATE `work_detail` SET `AD_Id`= null  WHERE `W_Id` = '{$workId}';";

        $sql .=  "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$U_ID}','Remove Adhikari from Work','{$VId}','{$workId}')";

        $query = $con->multi_query($sql);

        if($query === TRUE) {

            $output['success'] = true;
            $output['messages'] = 'Successfully Remove Adhikari from Work';

        } else {

            $output['success'] = false;
            $output['messages'] = 'Error To Remove Adhikari from Work'.$con->error();

        }
        
        // close database connection
        $con->close();        
        echo json_encode($output);
    }



?>