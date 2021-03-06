<?php

    require_once "config.php";

    if($_POST["action"] == "getData"){

        $ML_Id = '1';

        $sql = "SELECT * FROM `medical_letter` WHERE `ML_Id`= '$ML_Id' ";

        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);
        
    }else if($_POST["action"] == "updateML"){

        $validator_ml_update = array('success' => false, 'messages' => array());

        $U_Id = $_POST["user_id"];
        $ML_TO = $_POST["medicalletter_to"];
        $ML_SUBJECT = $_POST["medicalletter_subject"];
        $ML_DETAIL = $_POST["medicalletter_detail"];
        $ML_SIGN = $_POST["medicalletter_sign"];
        $ML_Id = '1';

        $sql_update = "UPDATE `medical_letter` SET `ML_To`='$ML_TO',`ML_Subject`='$ML_SUBJECT',
                `ML_Detail`='$ML_DETAIL',`ML_Sign`='$ML_SIGN' WHERE `ML_Id`='$ML_Id';";

        $sql_update .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`) 
                        VALUES ('{$U_Id}','Update Medical Letter Format')";

        $query_ml = $con->multi_query($sql_update);           
      
        if($query_ml === TRUE) { 
            $validator_ml_update['success'] = true;
            $validator_ml_update['messages'] = 'Successfully Update Medical Letter Detail';
        }else{
            $validator_ml_update['success'] = false;
            $validator_ml_update['messages'] = 'Error Update Medical Letter Detail'.$con->error; 
        }

        $con->close();

        echo json_encode($validator_ml_update);


    }else if($_POST["action"] == "getVisitorData"){

        $WORKID = $_POST["Work_Id"];

        $sql = "SELECT visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, 
                visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City,visitor_info.V_Pincode, 
                medical_letter.ML_Hospital, medical_letter.ML_To, medical_letter.ML_Subject, 
                medical_letter.ML_Detail, medical_letter.ML_Sign, medical_letter.ML_Ward, 
                medical_letter.ML_Bed, medical_letter.ML_Disease, medical_letter.ML_Admit_Date, 
                medical_letter.ML_Id, medical_letter.V_Id, medical_letter.ML_PName, medical_letter.ML_PDob, 
                medical_letter.ML_PGender, medical_letter.ML_PRelation FROM visitor_info INNER JOIN 
                medical_letter ON visitor_info.V_Id = medical_letter.V_Id 
                WHERE medical_letter.W_Id ='$WORKID'";

        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "updateML_ID"){

        $validator_ml_update_id = array('success' => false, 'messages' => array());

        $ML_TO = $_POST["medicalletter_to"];
        $ML_SUBJECT = $_POST["medicalletter_subject"];
        $ML_DETAIL = $_POST["medicalletter_detail"];
        $ML_SIGN = $_POST["medicalletter_sign"];
        $VId = $_POST["visitor_id"];
        $WId = $_POST["work_id"];
        $U_ID = $_POST["U_ID"];
        $ML_Id = $_POST["ml_id"];

        $sql_update = "UPDATE `medical_letter` SET `ML_To`='$ML_TO',`ML_Subject`='$ML_SUBJECT',
                `ML_Detail`='$ML_DETAIL',`ML_Sign`='$ML_SIGN' WHERE `ML_Id`='$ML_Id';";

        $sql_update .="UPDATE `work_detail` SET `Status`='Under Process' WHERE `W_Id` = '$WId';";  
        
        $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                        VALUES ('{$U_ID}','Edit and Update Medical Letter','{$VId}','{$WId}')";

        $query_ml = $con->multi_query($sql_update);           
      
        if($query_ml === TRUE) { 
            $validator_ml_update_id['success'] = true;
            $validator_ml_update_id['messages'] = 'Successfully Update Medical Letter Detail';
        }else{
            $validator_ml_update_id['success'] = false;
            $validator_ml_update_id['messages'] = 'Error Update Medical Letter Detail'.$con->error; 
        }

        $con->close();

        echo json_encode($validator_ml_update_id);

    }else if($_POST["action"] == "uploadFile"){

        $MLID = $_POST["ML_Id"];
        $WId = $_POST["W_ID"];
        $VId = $_POST["visitor_id"];
        $U_ID = $_POST["U_ID"];
        $C_DATE = date("Y-m-d");


        $documentName = $MLID."-".$_FILES["ml_final_document"]["name"];
        $target_dir_ml_letter = "../image/Work_File/ml_letter/";
        $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

        if($_FILES["ml_final_document"]["size"] > 500000) {
            echo "File size should not be greated than 500Kb";       
        }else{
            //Upload Profile Image
            if(move_uploaded_file($_FILES["ml_final_document"]["tmp_name"], $target_file_ml_letter)) {

                // UPDATE `medical_letter` SET `ML_Final_Letter`='{$documentName}' WHERE `ML_Id`= '{$MLID}'

                    $sql_upload = "UPDATE `medical_letter` SET `ML_C_Date`= '{$C_DATE}', 
                                    `ML_Final_Letter`='{$documentName}' WHERE `ML_Id`= '{$MLID}';";
                    $sql_upload .="UPDATE `work_detail` SET `Status`='Complete' WHERE `W_Id` = '$WId';";

                    $sql_upload .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                                    VALUES ('{$U_ID}','Upload Complete Medical Letter','{$VId}','{$WId}')";
                
                if($con->multi_query($sql_upload)){
                    echo "Image uploaded and saved in the Database".$C_DATE;
                    // echo $con->error;              
                } else {
                    echo "There was an erro uploading the file".$con->error;              
                }
            }else {
                echo "There was an erro uploading the file".$con->error;    
            }

        }

    }else if($_POST["action"] == "medical_List_retrive"){


        $output = array('data' => array());
    
        $sql = "SELECT medical_letter.ML_Id, medical_letter.ML_Hospital, medical_letter.ML_Ward , 
                        medical_letter.ML_Bed, medical_letter.ML_Disease, 
                        medical_letter.ML_Admit_Date, medical_letter.ML_PName, medical_letter.ML_PDob, 
                        medical_letter.ML_PGender, work_detail.W_Id, work_detail.Priority, work_detail.Status 
                FROM medical_letter INNER JOIN work_detail ON medical_letter.W_Id = work_detail.W_Id 
                WHERE work_detail.Visibility = 'visible'";
    
    
        if(isset($_POST["priority"]) && $_POST["priority"] != "" && $_POST["priority"] != 'All'){
            $PRIORITY = $_POST["priority"];
            $sql .= " AND work_detail.Priority = '$PRIORITY'";
        }
        if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
            $STATUS = $_POST["status"];
            $sql .= " AND work_detail.Status = '$STATUS'";
        }
    
        if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){
            
            $DATEFROM = $_POST["dateform"];
            $DATEEND = $_POST["dateend"];
    
            $sql .= " AND work_detail.Work_add_date BETWEEN '$DATEFROM' AND '$DATEEND'";
            
        }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){
            
            $DATEFROM = $_POST["dateform"];
            $DATEEND = $_POST["dateend"];
    
            if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){
    
                $sql .= " AND work_detail.Work_add_date > '$DATEFROM'";
    
            }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){
    
                $sql .= " AND work_detail.Work_add_date < '$DATEEND'";
                
            }
    
        }
    
        $sql .= "ORDER BY medical_letter.ML_Id DESC";
    
        $query = $con->query($sql);
    
        while($row = $query->fetch_assoc()){
    
            $status = '';
            if($row['Status'] == 'Complete'){
                $status = '<span class="badge badge-success p-1">Complete</span>';
            }elseif($row['Status'] == 'Under Process'){
                $status = '<span class="badge badge-warning p-1">Under Process</span>';
            }else{
                $status = '<span class="badge badge-dark p-1">Pending</span>';   
            }
    
            $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#MedicalModal" onclick="editML('.$row['ML_Id'].')">Edit</button>
                             <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#MedicalModal" onclick="rmoveML('.$row['ML_Id'].')">Rmove</button>
                             <button type="button" class="btn btn-info btn-sm" onclick="detailWork('.$row['W_Id'].')">Info</button>';
    
            $output['data'][] = array(
                $row['ML_Id'],
                $row['ML_PName']."<br>".$row['ML_PGender']."|".$row['ML_PDob'],
                $row['ML_Hospital']."<br>".$row['ML_Ward']." | ".$row['ML_Bed'],
                $row['ML_Disease'],
                $status,              
                $actionButton
            );
            
        }
    
        $con->close();
     
        echo json_encode($output);

    }else if($_POST["action"] == "getMedicalData"){

        $ML_Id = $_POST["M_Id"];

        $sql = "SELECT medical_letter.ML_Id, medical_letter.ML_Hospital, medical_letter.ML_Ward, medical_letter.ML_Bed, 
                medical_letter.ML_Disease, medical_letter.ML_Admit_Date, medical_letter.ML_PName, medical_letter.ML_PDob, 
                medical_letter.ML_PGender, medical_letter.ML_PRelation,  medical_letter.ML_Final_Letter, work_detail.Work_Doc,
                work_detail.W_Id, work_detail.Priority, work_detail.Status, work_detail.Work_title, work_detail.Work_detail,
                visitor_info.V_Id, visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, visitor_info.V_Gender, 
                visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode, visitor_info.Visitor_Profile
                FROM medical_letter INNER JOIN work_detail ON medical_letter.W_Id = work_detail.W_Id 
                INNER JOIN visitor_info ON medical_letter.V_Id = visitor_info.V_Id WHERE work_detail.Visibility = 'visible' 
                AND visitor_info.V_Visibility = 'visible' AND medical_letter.ML_Id = '$ML_Id' ";

        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "updateMedicalSingleData"){

        // print_r($_POST);

        $validator = array('success' => false, 'messages' => array());

        $VID = $_POST['v_id'];
        $UID = $_POST['user_id'];

        $WId = $_POST['w_id'];
        $WSTATUS = $_POST['work_status'];
        $WTITLE = $_POST['work_title'];
        $WDETAIL = $_POST['work_detail'];
        $WPRPIORITY = $_POST['work_priority'];

        $ML_ID = $_POST["m_Id"];
        $HOSPITAL = $_POST["hospital_name"];
        $WARD = $_POST["hospital_ward"];
        $BED = $_POST["hospital_bed"];
        $DISEASE = $_POST["Disease"];
        $DATE_ADMIT = $_POST["admit_date"];
        $PNAME = $_POST["patient_name"];
        $PDOB = $_POST["patient_dob"];
        $PGENDER = $_POST["patient_gender"];
        $PRELATION = $_POST["patient_relation"];

        // `ML_Hospital`, `ML_Ward`, `ML_Bed`, `ML_Disease`, `ML_Admit_Date`, `ML_C_Date`, `ML_Final_Letter`, 
        // `ML_PName`, `ML_PDob`, `ML_PGender`, `ML_PRelation`


        $sql_update = "UPDATE `medical_letter` SET `ML_Hospital`='$HOSPITAL',`ML_Ward`='$WARD',
                `ML_Bed`='$BED',`ML_Disease`='$DISEASE',`ML_Admit_Date`='$DATE_ADMIT',`ML_PName`='$PNAME'
                ,`ML_PDob`='$PDOB',`ML_PGender`='$PGENDER',`ML_PRelation`='$PRELATION'
                 WHERE `ML_Id`='$ML_ID' AND `W_Id`= '$WId';";

        $sql_update .="UPDATE `work_detail` SET `Work_title`='$WTITLE',`Priority`='$WPRPIORITY',
                        `Work_detail`='$WDETAIL',`Status`='$WSTATUS' WHERE `W_Id`= '$WId';"; 

        $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$UID}','Edit and Update Medical Detail','{$VID}','{$WId}')";
        

        $query_ml = $con->multi_query($sql_update);           
      
        if($query_ml === TRUE) { 
            $validator['success'] = true;
            $validator['messages'] = 'Successfully Update Medical Detail';
        }else{
            $validator['success'] = false;
            $validator['messages'] = 'Error Update Medical Detail'.$con->error; 
        }

        $con->close();

        echo json_encode($validator);

    }else if($_POST["action"] == "removeMedicalDetail"){

        // print_r($_POST);

        $validator = array('success' => false, 'messages' => array());

        $VID = $_POST['VID'];
        $UID = $_POST['UID'];
        $WId = $_POST['WID'];
        $ML_ID = $_POST["M_Id"];

        $sql_update = "UPDATE `medical_letter` SET `ML_Visibility`='hidden'
                 WHERE `ML_Id`='$ML_ID' AND `W_Id`= '$WId';";

        $sql_update .="UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id`= '$WId';"; 

        $sql_update .="INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`) 
                    VALUES ('{$UID}','Delete Medical and work Detail','{$VID}','{$WId}')";
        

        $query_ml = $con->multi_query($sql_update);           
      
        if($query_ml === TRUE) { 
            $validator['success'] = true;
            $validator['messages'] = 'Successfully Delete Medical and Work Detail';
        }else{
            $validator['success'] = false;
            $validator['messages'] = 'Error to Delete Medical and Work Detail'.$con->error; 
        }

        $con->close();

        echo json_encode($validator);

    }else if($_POST['action'] == "todayMedicalEntry"){
        // print_r($_POST);

        $sql_t_visitor =  "SELECT medical_letter.ML_Id, work_detail.Work_add_date FROM medical_letter 
                            INNER JOIN work_detail ON medical_letter.W_Id = work_detail.W_Id 
                            WHERE medical_letter.ML_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                            AND work_detail.Work_add_date > CURRENT_DATE";
    
        $query_t_visitor = $con->query($sql_t_visitor);
    
        $result = $query_t_visitor->num_rows;
    
        $con->close();      
          
        echo json_encode($result);

    }

?>