<?php

    require_once "config.php";

    // print_r($_POST);

    $VID =$_POST["visitor_id"];
    $VTYPE = $_POST["visitor_type"];
    $VNAME = $_POST["visitor_name"];
    $VPHONE = $_POST["visitor_phone"];
    $VEMAIL = $_POST["visitor_email"];
    $VGENDER = $_POST["visitor_gender"];
    $VDOB = $_POST["visitor_dob"];
    $VADDR = $_POST["visitor_address"];
    $VCITY = $_POST["visitor_city"];  
    $VPINCODE = $_POST["visitor_pincode"];
    $RNAME = $_POST["refernce_name"];
    $RPHONE = $_POST["refernce_phone"];
    $VCAT = $_POST["visitor_category"];
    $VADHARCARD = $_POST["v_adhar_card"];
    $VVOTERCARD = $_POST["v_voter_card"];
    $VPANCARD = $_POST["v_pan_card"];
    // $VPROIMG = $_POST["visitor_category"];

    $profileImageName = date("dmY")."-".$_FILES["visitor_profile"]["name"];
    $target_dir_visitor = "../image/Visitor_Profile/";
    $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

    $WTITLE = $_POST["work_title"];
    $WPRIORITY = $_POST["work_priority"];
    $WCATE = $_POST["work_category"];
    $WSUBCAT = $_POST["work_subcategory"];
    $WDETAIL = $_POST["work_detail"];    
    $WSTATUS = "Pending";

    $workImageName = date("dmY")."-".$_FILES["work_file"]["name"];
    $target_dir_work = "../image/Work_File/";
    $target_file_work_img = $target_dir_work . basename($workImageName);




    if($_FILES["visitor_profile"]["size"] > 200000) {
        echo "visitor Image size should not be greated than 200Kb";
       
    }

    if($_FILES["work_file"]["size"] > 200000) {
        echo "work Image size should not be greated than 200Kb";
       
    }


    // if(file_exists($target_file)) {
    //     echo "File already exists";
        
    // }
    

    $SQL_VISITOR = "UPDATE `visitor_info` SET `V_Name`= '$VNAME',`V_Phone`='$VPHONE',`V_Email`='$VEMAIL',
                    `V_Dob`='$VDOB',`V_Gender`='$VGENDER',`V_Address`='$VADDR',`V_City`='$VCITY',
                    `V_Pincode`= '$VPINCODE',`R_Name`='$RNAME',`R_Phone`='$RPHONE',`V_Type`='$VTYPE',
                    `V_Visibility`='visible', `V_Adhar_Card`='$VADHARCARD',
                    `V_Voter_Card`='$VVOTERCARD',`V_Pan_Card`='$VPANCARD' WHERE `V_Id`='$VID'";

    if($con->query($SQL_VISITOR))
    {
        // $last_vid = mysqli_insert_id($con);
        // echo "Data Saved Successful ! with Id is ".$last_id;

        if(move_uploaded_file($_FILES["visitor_profile"]["tmp_name"], $target_file_visitor_img)) {

             $sql = "UPDATE `visitor_info` SET `Visitor_Profile`= '{$profileImageName}' WHERE `V_Id`= '{$VID}'";
            
            if($con->query($sql)){
                echo "Image uploaded and saved in the Database".$con->error;
                // echo $con->error;
              
            } else {
                echo "There was an error in the database".$con->error;
              
            }
        }else {
            echo "There was an erro uploading the file".$con->error;
    
        }


        $SQL_WORK = "INSERT INTO `work_detail`(`V_Id`, `Work_title`, `Priority`, `Work_Category`, `Work_Subcategory`, `Work_detail`, `Status`, `Visibility`) 
        VALUES ('{$VID}','{$WTITLE}','{$WPRIORITY}','{$WCATE}','{$WSUBCAT}','{$WDETAIL}','{$WSTATUS}', 'visible')";

        if($con->query($SQL_WORK))
        {
            $last_wid = mysqli_insert_id($con);
            echo "Data Saved Successful ! with visitor id ". $last_vid ." Work Id ".$last_wid;

            if(move_uploaded_file($_FILES["work_file"]["tmp_name"], $target_file_work_img)) {

                $sql_work_doc = "UPDATE `work_detail` SET `Work_Doc`= '{$workImageName}' WHERE `W_Id`= '{$last_wid}'";
               
               if($con->query($sql_work_doc)){
                //    echo "Image uploaded and saved in the Database".$con->error;
                   echo $con->error;
                 
               } else {
                   echo "There was an error in the database".$con->error;
                 
               }
           }else {
               echo "There was an erro uploading the file".$con->error;
       
           }



            if(isset($_POST["gvisitor_name"]) && $VCAT == "Group")
            {
                for($count = 0; $count < count($_POST["gvisitor_name"]); $count++)
                {          
                    $query = "INSERT INTO `group_visitor`(`Name`, `Phone`, `V_Id`, `W_Id`) VALUES (?,?,?,?)";
                    $statement = $con->prepare($query);
                    $statement->bind_param('ssss', $G_VISITOR_NAME, $G_VISITOR_PHONE, $G_VID, $G_WID);
                        $G_VISITOR_NAME  = $_POST["gvisitor_name"][$count];
                        $G_VISITOR_PHONE = $_POST["gvisitor_phone"][$count];  
                        $G_VID = $VID;  
                        $G_WID = $last_wid;                             
                    $result = $statement->execute();
                }
                $statement->close();
            }else if($VCAT == "Single") {
                
            }else{
                echo "Error in group: <br>" . $con->error;
            }

        }else {
            echo "Error: " . $SQL_WORK . "<br>" . $con->error;
        }

    }else{
        echo "Error: " . $SQL_VISITOR . "<br>" . $con->error;
    }    

    $con->close();

    
?>