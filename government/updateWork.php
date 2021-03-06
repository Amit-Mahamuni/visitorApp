<?php

require_once 'config.php';

if($_POST) {    
 
    $validator = array('success' => false, 'messages' => array());
 
    $U_ID = $_POST['user_id'];
    $VID = $_POST['visitor_id'];
    $WId = $_POST['work_id'];
    $WSTATUS = $_POST['work_status'];
    $WTITLE = $_POST['work_title'];
    $WCAT = $_POST['work_category'];
    $WSUBCAT = $_POST['work_subcat'];
    $WDETAIL = $_POST['work_detail'];
    $WPRPIORITY = $_POST['work_priority'];

    $WCDATE = date("Y-m-d");

    if($_POST['work_status'] == "Complete"){
        $sql = "UPDATE `work_detail` SET `Work_title`='$WTITLE', `Priority`='$WPRPIORITY',`Work_Category`='$WCAT',
                `Work_end_date`='$WCDATE',`Work_Subcategory`='$WSUBCAT',`Work_detail`='$WDETAIL',`Status`='$WSTATUS' WHERE `W_Id`= $WId;"; 
    }else{
        $sql = "UPDATE `work_detail` SET `Work_title`='$WTITLE', `Priority`='$WPRPIORITY',`Work_Category`='$WCAT',
                `Work_Subcategory`='$WSUBCAT',`Work_detail`='$WDETAIL',`Status`='$WSTATUS' WHERE `W_Id`= $WId;";
    }

    $sql .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                VALUES ('{$U_ID}','Edit and Update Goverment Work details','{$VID}','{$WId}')";

    $query = $con->multi_query($sql);
 
    if($query === TRUE) {           
        $validator['success'] = true;
        $validator['messages'] = "Successfully Update Detail";      
    } else {        
        $validator['success'] = false;
        $validator['messages'] = "Error while Updating the Work information".$con->error;
    }
 
    // close the database connection
    $con->close();
 
    echo json_encode($validator);
 
}

?>