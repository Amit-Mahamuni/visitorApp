<?php

require_once "config.php";



if(isset($_POST)){

    $validator = array('success' => false, 'messages' => array());

    // print_r($_FILES["visitor_profile"]);
    // echo "file is ".;

    $J_ID = $_POST["j_id"];
    $WID = $_POST["w_id"];
    $VID = $_POST["v_id"];
    $U_ID = $_POST["user_id"];
    $JNAME = $_POST["job_name"];
    $JEMAIL = $_POST["job_email"];
    $JPHONE = $_POST["job_phone"];
    $JQUAL = $_POST["job_qualification"];
    $JEXP = $_POST["job_exp"];
    $JOLDCAMP = $_POST["job_company"];
    $JDOB = $_POST["job_dob"];
    $JGENDER = $_POST["job_gender"];
    $JRELATIVE = $_POST["job_relation"];
    $WSTATUS = $_POST["work_status"];


    $sql_u_job =  "UPDATE `job_info` SET `J_Name`='$JNAME',`J_Dob`='$JDOB',`J_Gender`='$JGENDER',
                    `J_Email`='$JEMAIL',`J_Phone`='$JPHONE',`J_Qualification`='$JQUAL',`J_Exp`='$JEXP',
                    `J_Old_Company`='$JOLDCAMP',`J_Relative`='$JRELATIVE'
                    WHERE `J_Id`= '$J_ID'";

    $sql_w_status = "UPDATE `work_detail` SET `Status`='$WSTATUS' WHERE `W_Id`='$WID';";

    $sql_w_status .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                        VALUES ('{$U_ID}','Edit and Update Job Details','{$VID}','{$WID}')";
   
 
    $query = $con->query($sql_u_job);
 
    if($query === TRUE) {  
        
        if($con->multi_query($sql_w_status)){
            $validator['success'] = true;
            $validator['messages'] = "Sucessfully Data Update";
        }


        if($_FILES["job_profile"]["name"] != ""){

            $profileImageName = "JOB".$J_ID."-".$WID."-".$_FILES["job_profile"]["name"];
            $target_dir_visitor = "../image/Work_File/";
            $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

            if($_FILES["job_profile"]["size"] > 200000) {

                $validator['success'] = false;
                $validator['messages'] = 'Successfully Update Job Detail But Job Image size should not be greated than 200Kb'.$con->error;
            }
            else{

                if(move_uploaded_file($_FILES["job_profile"]["tmp_name"], $target_file_visitor_img)) {
                    

                    $sql_upload_resume= "UPDATE `work_detail` SET `Work_Doc`= '$profileImageName' WHERE `W_Id`= '$WID'";


                    $result = $con->query($sql_upload_resume);
                   
                   if($result === true){

                        $validator['success'] = true;
                        $validator['messages'] = 'Successfully Update Job Detail also Image uploaded and saved in the Database ';
                     
                   } else {

                        $validator['success'] = false;
                        $validator['messages'] = 'Successfully Update Job Detail But There was an error to update in table'.$con->error;
                     
                   }
                } else {

                    $validator['success'] = false;
                    $validator['messages'] = 'Successfully Update Job Detail '.$con->error;

           
               }
            }

        }




     
    } else {  
//         echo " fail to update data".$con->error;      
        $validator['success'] = false;
        $validator['messages'] = "Error while Updating the Job information".$con->error;
    }
 

}else{
    // echo " fail to get data".$con->error;
    $validator['success'] = false;
    $validator['messages'] = "Fail to get data".$con->error;
}

echo json_encode($validator);


$con->close();

?>