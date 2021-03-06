<?php

    require_once "config.php";


    $validator = array('success' => false, 'VID' => '', 'WID' => '', 'messages' => array());

    $USERID = $_POST["user_id"];

    // print_r($_POST);
    $VVOTER = $_POST["visitor_voter"];
    $VTYPE = $_POST["visitor_type"];
    $VNAME = $_POST["visitor_name"];
    $VPHONE = $_POST["visitor_phone"];
    $VEMAIL = $_POST["visitor_email"];
    $VGENDER = $_POST["visitor_gender"];
    $VDOB = $_POST["visitor_dob"];
    $VADDR = $_POST["visitor_address"];
    $VCITY = $_POST["visitor_city"];
    $VPINCODE = $_POST["visitor_pincode"];

    $VCAT = $_POST["visitor_category"];
    $VADHARCARD = $_POST["v_adhar_card"];
    $VVOTERCARD = $_POST["v_voter_card"];
    $VPANCARD = $_POST["v_pan_card"];
    // $VPROIMG = $_POST["visitor_category"];


    $WTITLE = $_POST["work_title"];
    $WPRIORITY = $_POST["work_priority"];
    $WCATE = $_POST["work_category"];
    $WSUBCAT = $_POST["work_subcategory"];
    $WDETAIL = $_POST["work_detail"];
    $WSTATUS = "Pending";

    if($_POST["visitor_id"] != "" && isset($_POST["visitor_id"])){

        $VID = $_POST["visitor_id"];

        $SQL_VISITOR = "UPDATE `visitor_info` SET `V_Name`= '$VNAME',`V_Phone`='$VPHONE',`V_Email`='$VEMAIL',
                        `V_Dob`='$VDOB',`V_Gender`='$VGENDER',`V_Address`='$VADDR',`V_City`='$VCITY',
                        `V_Pincode`= '$VPINCODE',`V_Category`='$VCAT', `V_Type`='$VTYPE',
                        `V_Visibility`='visible', `V_Adhar_Card`='$VADHARCARD', `V_Voter`='$VVOTER',
                        `V_Voter_Card`='$VVOTERCARD',`V_Pan_Card`='$VPANCARD', `U_Id`='$USERID' WHERE `V_Id`='$VID'";

        if($con->query($SQL_VISITOR)){
            $last_vid = $VID;
        }else{
            $validator['messages'] = "Error For Data added ".$con->error;
        }

    }else{

        $SQL_VISITOR = "INSERT INTO `visitor_info`(`V_Name`, `V_Phone`, `V_Email`, `V_Dob`, `V_Gender`,
                        `V_Address`, `V_City`, `V_Pincode`, `V_Category`, `V_Visibility`,`V_Adhar_Card`, `V_Voter_Card`,
                         `V_Pan_Card`, `V_Type`, `V_Voter`, `U_Id`)
                        VALUES ('{$VNAME}','{$VPHONE}','{$VEMAIL}','{$VDOB}','{$VGENDER}','{$VADDR}','{$VCITY}','{$VPINCODE}',
                                '{$VCAT}', 'visible','{$VADHARCARD}','{$VVOTERCARD}','{$VPANCARD}','{$VTYPE}','{$VVOTER}','{$USERID}')";

        if($con->query($SQL_VISITOR)){
            $last_vid = mysqli_insert_id($con);
        }else{
            $validator['messages'] = "Error For Data added ".$con->error;
        }

    }

    // $SQL_VISITOR = "INSERT INTO `visitor_info`(`V_Name`, `V_Phone`, `V_Email`, `V_Dob`, `V_Gender`, `V_Address`, `V_City`, `V_Pincode`, `V_Category`, `V_Visibility`,`V_Adhar_Card`, `V_Voter_Card`, `V_Pan_Card`, `V_Type`, `V_Voter`)
    //                 VALUES ('{$VNAME}','{$VPHONE}','{$VEMAIL}','{$VDOB}','{$VGENDER}','{$VADDR}','{$VCITY}','{$VPINCODE}','{$VCAT}', 'visible','{$VADHARCARD}','{$VVOTERCARD}','{$VPANCARD}','{$VTYPE}','{$VVOTER}')";

    if($last_vid != "")
    {
        // $last_vid = mysqli_insert_id($con);
        // echo "Data Saved Successful ! with Id ".$last_vid;

        //Upload Profile Image
        if($_FILES["visitor_profile"]["name"] != "") {

            if($_FILES["visitor_profile"]["size"] < 3500000){

                $profileImageName = $last_vid."-".$_FILES["visitor_profile"]["name"];
                $target_dir_visitor = "../image/Visitor_Profile/";
                $target_file_visitor_img = $target_dir_visitor . basename($profileImageName);

                if(move_uploaded_file($_FILES["visitor_profile"]["tmp_name"], $target_file_visitor_img)) {

                    $sql_uvp = "UPDATE `visitor_info` SET `Visitor_Profile`= '{$profileImageName}' WHERE `V_Id`= '{$last_vid}'";

                    if($con->query($sql_uvp)){

                        $validator['success'] = true;
                        $validator['VID'] = $last_vid;
                        $validator['messages'] = "Data added sucessful and update ".$con->error;

                        // echo "Image uploaded and saved in the Database".$con->error;

                    } else {

                        $validator['success'] = false;
                        $validator['VID'] = $last_vid;
                        $validator['messages'] = "There was an error in the database".$con->error;

                        // echo "There was an error in the database".$con->error;
                    }
                }else {
                        $validator['success'] = false;
                        $validator['VID'] = $last_vid;
                        $validator['messages'] = "Visitor Image not uploaded to DataBase".$con->error;
                    // echo "Image not uploaded to DataBase".$con->error;
                }
            }else {
                    $validator['success'] = true;
                    $validator['VID'] = $last_vid;
                    $validator['messages'] = "Visitor Data Added.Image size should not be greated than 500kb with".$con->error;
                // echo "Image size should not be greated than 200Kb with".$con->error;

            }
        }


        if($_POST["work_id"] != "" && isset($_POST["work_id"])){

            $WID = $_POST["work_id"];

            $SQL_WORK = "UPDATE `work_detail` SET `Work_title`= '$WTITLE',`Priority`='$WPRIORITY',`Work_Category`='$WCATE',
                            `Work_Subcategory`='$WSUBCAT',`Work_detail`='$WDETAIL',`Status`='$WSTATUS',`Visibility`='visible',
                            `Work_From`= '$VTYPE',`U_Id`='$USERID' WHERE `V_Id`='$VID' AND `W_Id`='$WID'";

            if($con->query($SQL_WORK)){
                $last_wid = $WID;
            }else{
                $validator['messages'] = " Error For Data added ".$con->error;
            }

        }else{

          $SQL_WORK = "INSERT INTO `work_detail`(`V_Id`, `Work_title`, `Priority`, `Work_Category`,
                      `Work_Subcategory`, `Work_detail`, `Status`, `Visibility`, `Work_From`, `U_Id`)
                      VALUES ('{$last_vid}','{$WTITLE}','{$WPRIORITY}','{$WCATE}','{$WSUBCAT}','{$WDETAIL}',
                              '{$WSTATUS}', 'visible', '{$VTYPE}', '{$USERID}')";

            if($con->query($SQL_WORK)){
                $last_wid = mysqli_insert_id($con);
            }else{
                $validator['messages'] = " Error For Data added ".$con->error;
            }

        }


        // $SQL_WORK = "INSERT INTO `work_detail`(`V_Id`, `Work_title`, `Priority`, `Work_Category`, `Work_Subcategory`, `Work_detail`, `Status`, `Visibility`, `Work_From`, `U_Id`)
        // VALUES ('{$last_vid}','{$WTITLE}','{$WPRIORITY}','{$WCATE}','{$WSUBCAT}','{$WDETAIL}','{$WSTATUS}', 'visible', '{$VTYPE}', '{$USERID}')";

        if($last_wid != ""){

            // $last_wid = mysqli_insert_id($con);

            $validator['success'] = true;
            $validator['VID'] = $last_vid;
            $validator['WID'] = $last_wid;
            $validator['messages'] = "Data Saved Successful";

            // echo "Data Saved Successful ! with Visitor Id-".$last_vid." Work Id-".$last_wid;

            //Upload Work Image
            if($_FILES["work_file"]["name"] != "") {

                if($_FILES["work_file"]["size"] < 3500000){
                    $workImageName = $last_wid."-".$_FILES["work_file"]["name"];
                    $target_dir_work = "../image/Work_File/";
                    $target_file_work_img = $target_dir_work . basename($workImageName);

                    if(move_uploaded_file($_FILES["work_file"]["tmp_name"], $target_file_work_img)) {

                        $sql_work_doc = "UPDATE `work_detail` SET `Work_Doc`= '{$workImageName}' WHERE `W_Id`= '{$last_wid}'";

                        if($con->query($sql_work_doc)){

                            $validator['success'] = true;
                            $validator['messages'] = "Data Saved Successful";

                            // echo " also Work Image uploaded and saved in the Database".$con->error;

                        } else {
                            $validator['success'] = false;
                            $validator['messages'] = "Data Saved Successful".$con->error;
                            // echo "There was an error in the database".$con->error;
                        }
                    }else {
                        $validator['success'] = false;
                        $validator['messages'] = "Data Saved Successful.Work Image not uploaded to DataBase".$con->error;
                        // echo "Work Image not uploaded to DataBase".$con->error;
                    }
                }else {
                    $validator['success'] = false;
                    $validator['messages'] = "Data Saved Successful.Work Image size should not be greated than 500Kb".$con->error;
                    // echo "Work Image size should not be greated than 200Kb with".$con->error;

                }
            }



            //add from data
            switch($WSUBCAT){
                case "Medical Letter":

                    // INSERT INTO `medical_letter`(`W_Id`, `V_Id`, `ML_Hospital`, `ML_Ward`, `ML_Bed`, `ML_Disease`)

                    $HOSPITAL = $_POST["hospital_name"];
                    $WARD = $_POST["hospital_ward"];
                    $BED = $_POST["hospital_bed"];
                    $DISEASE = $_POST["Disease"];
                    $DATE_ADMIT = $_POST["admit_date"];
                    $PNAME = $_POST["patient_name"];
                    $PDOB = $_POST["patient_dob"];
                    $PGENDER = $_POST["patient_gender"];
                    $PRELATION = $_POST["patient_relation"];

                    if($_POST["medical_id"] != "" && isset($_POST["medical_id"])){

                        $MLID = $_POST["medical_id"];

                        $SQL_L = "UPDATE `medical_letter` SET `ML_Hospital`= '$HOSPITAL',`ML_Ward`='$WARD',`ML_Bed`='$BED',
                                        `ML_Disease`='$DISEASE',`ML_Admit_Date`='$DATE_ADMIT',`ML_PName`='$PNAME',`ML_Visibility`='visible',
                                        `ML_PDob`= '$PDOB',`ML_PGender`='$PGENDER',`ML_PRelation`='$PRELATION'
                                        WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `ML_Id` = '$MLID'";


                    }else{

                      $SQL_L = "INSERT INTO `medical_letter`(`W_Id`, `V_Id`, `ML_Hospital`, `ML_Ward`, `ML_Bed`,
                                `ML_Disease`, `ML_Admit_Date`, `ML_PName`, `ML_PDob`, `ML_PGender`, `ML_PRelation`, `ML_Visibility`)
                               VALUES ('{$last_wid}','{$last_vid}','{$HOSPITAL}','{$WARD}','{$BED}','{$DISEASE}','{$DATE_ADMIT}',
                                        '{$PNAME}','{$PDOB}','{$PGENDER}','{$PRELATION}', 'visible')";

                    }

                    // $SQL_L = "INSERT INTO `medical_letter`(`W_Id`, `V_Id`, `ML_Hospital`, `ML_Ward`, `ML_Bed`,
                    //           `ML_Disease`, `ML_Admit_Date`, `ML_PName`, `ML_PDob`, `ML_PGender`, `ML_PRelation`, `ML_Visibility`)
                    //          VALUES ('{$last_wid}','{$last_vid}','{$HOSPITAL}','{$WARD}','{$BED}','{$DISEASE}','{$DATE_ADMIT}',
                    //                   '{$PNAME}','{$PDOB}','{$PGENDER}','{$PRELATION}', 'visible')";

                    if($con->query($SQL_L)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Letter Data also Added Sucessfully";
                        // echo "Letter Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Letter Data Adding.".$con->error;
                        // echo "Error to Letter Data Adding.".$con->error;
                    }

                break;

                case ($WSUBCAT == "Opening" || $WSUBCAT == "Dashkriya" || $WSUBCAT == "Birthday" || $WSUBCAT == "Collage / School Program" || $WSUBCAT == "Government Program / Meeting" || $WSUBCAT == "Other Invitation" ):

                    $IDATE = $_POST["invitation_date"];
                    $ITIME = $_POST["invitation_time"];
                    $IADDRESS = $_POST["invitation_address"];
                    $ITITLE = $_POST["invitation_title"];

                    if($_POST["invitation_id"] != "" && isset($_POST["invitation_id"])){

                        $IN_ID = $_POST["invitation_id"];

                        $SQL_IO = "UPDATE `invitation` SET `I_Title`= '$ITITLE',`I_Address`='$IADDRESS',`I_Date`='$IDATE',
                                        `I_Time`='$ITIME',`I_Type`='$WSUBCAT',`I_Status`='Unknow',`I_Visibility`='visible'
                                        WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `I_Id` = '$IN_ID'";

                    }else{

                      $SQL_IO = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`,
                                  `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`)
                                  VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}',
                                    'visible','Unknow','{$last_wid}','{$last_vid}')";

                    }

                  // $SQL_IO = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`, `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`)
                  //             VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}','visible','Unknow','{$last_wid}','{$last_vid}')";


                    if($con->query($SQL_IO)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Invitation Data also Added Sucessfully";
                        // echo "Invitation Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Invitation Data Adding.".$con->error;
                        // echo "Error to Invitation Data Adding.".$con->error;
                    }

                break;

                // case "Dashkriya":
                //
                //     $IDATE = $_POST["invitation_date"];
                //     $ITIME = $_POST["invitation_time"];
                //     $IADDRESS = $_POST["invitation_address"];
                //     $ITITLE = $_POST["invitation_title"];
                //
                //     if($_POST["invitation_id"] != "" && isset($_POST["invitation_id"])){
                //
                //         $IN_ID = $_POST["invitation_id"];
                //
                //         $SQL_ID = "UPDATE `invitation` SET `I_Title`= '$ITITLE',`I_Address`='$IADDRESS',`I_Date`='$IDATE',
                //                         `I_Time`='$ITIME',`I_Type`='$WSUBCAT',`I_Status`='Unknow',`I_Visibility`='visible'
                //                         WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `I_Id` = '$IN_ID'";
                //
                //     }else{
                //
                //       $SQL_ID = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`,
                //                   `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`)
                //                   VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}',
                //                     'visible','Unknow','{$last_wid}','{$last_vid}')";
                //
                //     }
                //
                //
                //   // $SQL_ID = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`, `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`)
                //   //             VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}','visible','Unknow','{$last_wid}','{$last_vid}')";
                //
                //
                //     if($con->query($SQL_ID)){
                //         $validator['success'] = true;
                //         $validator['messages'] .= "Invitation Data also Added Sucessfully";
                //         // echo "Invitation Data also Added Sucessfully";
                //     }else{
                //         $validator['success'] = true;
                //         $validator['messages'] .= "Error to Invitation Data Adding.".$con->error;
                //         // echo "Error to Invitation Data Adding.".$con->error;
                //     }
                //
                // break;

                case "Wedding":

                    $IDATE = $_POST["invitation_date"];
                    $ITIME = $_POST["invitation_time"];
                    $IADDRESS = $_POST["invitation_address"];
                    $ITITLE = "Wedding ".$_POST["Wedding_Boy_Name"]." Vs ".$_POST["Wedding_Girl_Name"] ;
                    $WBNAME = $_POST["Wedding_Boy_Name"];
                    $WGNAME = $_POST["Wedding_Girl_Name"];

                    if($_POST["invitation_id"] != "" && isset($_POST["invitation_id"])){

                        $IN_ID = $_POST["invitation_id"];

                        $SQL_WI = "UPDATE `invitation` SET `I_Title`= '$ITITLE',`I_Address`='$IADDRESS',`I_Date`='$IDATE',
                                        `I_Time`='$ITIME',`I_Type`='$WSUBCAT',`I_Status`='Unknow',`I_Visibility`='visible',
                                        `WI_BName`='$WBNAME',`WI_GName`='$WGNAME'
                                        WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `I_Id` = '$IN_ID'";

                    }else{

                      $SQL_WI = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`,
                                `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`, `WI_BName`, `WI_GName`)
                                 VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}',
                                 'visible','Unknow','{$last_wid}','{$last_vid}','{$WBNAME}','{$WGNAME}')";

                    }

                    // $SQL_WI = "INSERT INTO `invitation`(`I_Title`, `I_Address`, `I_Date`, `I_Time`, `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`, `WI_BName`, `WI_GName`)
                    //            VALUES ('{$ITITLE}','{$IADDRESS}','{$IDATE}','{$ITIME}','{$WSUBCAT}','visible','Unknow','{$last_wid}','{$last_vid}','{$WBNAME}','{$WGNAME}')";


                    if($con->query($SQL_WI)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Invitation Data also Added Sucessfully";
                        // echo "Invitation Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Invitation Data Adding.".$con->error;
                        // echo "Error to Invitation Data Adding.".$con->error;
                    }

                break;


                case "Education":

                    $ESNAME = $_POST["student_name"];
                    $ECNAME = $_POST["collage_Name"];
                    $ESCLASS = $_POST["student_class"];
                    $ETFEE = $_POST["student_fee_total"];
                    $EDFEE = $_POST["student_discount_fee"];

                    if($_POST["education_id"] != "" && isset($_POST["education_id"])){

                        $ED_ID = $_POST["education_id"];

                        $SQL_EI = "UPDATE `education_info` SET `E_Student_Name`= '$ESNAME',`E_Collage_Name`='$ECNAME',
                                  `E_Class`='$ESCLASS',`E_T_Fee`='$ETFEE',`E_D_Fee`='$EDFEE',`E_Visibility`='visible'
                                  WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `E_Id` = '$ED_ID'";

                    }else{

                      $SQL_EI = "INSERT INTO `education_info`(`E_Student_Name`, `E_Collage_Name`, `E_Class`,
                                  `E_T_Fee`, `E_D_Fee`, `V_Id`, `W_Id`, `E_Visibility`)
                                 VALUES ('{$ESNAME}','{$ECNAME}','{$ESCLASS}','{$ETFEE}','{$EDFEE}',
                                   '{$last_vid}','{$last_wid}','visible')";

                    }

                  // $SQL_EI = "INSERT INTO `education_info`(`E_Student_Name`, `E_Collage_Name`, `E_Class`, `E_T_Fee`, `E_D_Fee`, `V_Id`, `W_Id`, `E_Visibility`)
                  //            VALUES ('{$ESNAME}','{$ECNAME}','{$ESCLASS}','{$ETFEE}','{$EDFEE}','{$last_vid}','{$last_wid}','visible')";


                    if($con->query($SQL_EI)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Education Data also Added Sucessfully";
                        // echo "Education Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Education Data Adding.".$con->error;
                        // echo "Error to Education Data Adding.".$con->error;
                    }

                break;

                case "Vacany":

                    $JNAME = $_POST["job_name"];
                    $JEMAIL = $_POST["job_email"];
                    $JPHONE = $_POST["job_phone"];
                    $JQUAL = $_POST["job_qualification"];
                    $JEXP = $_POST["job_exp"];
                    $JOLDCAMP = $_POST["job_company"];
                    $JDOB = $_POST["job_dob"];
                    $JGENDER = $_POST["job_gender"];
                    $JRELATIVE = $_POST["job_relation"];
                    $JTYPE = "Vacany";

                    if($_POST["job_id"] != "" && isset($_POST["job_id"])){

                        $JOB_ID = $_POST["job_id"];

                        $SQL_JVI = "UPDATE `job_info` SET `J_Name`= '$JNAME',`J_Dob`='$JDOB',
                                  `J_Gender`='$JGENDER',`J_Email`='$JEMAIL',`J_Phone`='$JPHONE',
                                  `J_Qualification`='$JQUAL',`J_Exp`='$JEXP',`J_Old_Company`='$JOLDCAMP',
                                  `J_Relative`='$JRELATIVE',`J_Type`='$JTYPE',`J_Visibility`='visible'
                                  WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `J_Id` = '$JOB_ID'";

                    }else{

                      $SQL_JVI = "INSERT INTO `job_info`(`J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`,
                                  `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`)
                                  VALUES ('{$JNAME}','{$JDOB}','{$JGENDER}','{$JEMAIL}','{$JPHONE}','{$JQUAL}','{$JEXP}','{$JOLDCAMP}',
                                  '{$last_vid}','{$last_wid}','{$JTYPE}','{$JRELATIVE}','visible')";

                    }

                    // $SQL_JVI = "INSERT INTO `job_info`(`J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`,
                    //             `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`)
                    //             VALUES ('{$JNAME}','{$JDOB}','{$JGENDER}','{$JEMAIL}','{$JPHONE}','{$JQUAL}','{$JEXP}','{$JOLDCAMP}',
                    //             '{$last_vid}','{$last_wid}','{$JTYPE}','{$JRELATIVE}','visible')";


                    if($con->query($SQL_JVI)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Job Data also Added Sucessfully";
                        // echo "Job Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Job Data Adding.".$con->error;
                        // echo "Error to Job Data Adding.".$con->error;
                    }

                break;


                case "Job Letter":

                    $JNAME = $_POST["job_name"];
                    $JEMAIL = $_POST["job_email"];
                    $JPHONE = $_POST["job_phone"];
                    $JQUAL = $_POST["job_qualification"];
                    $JEXP = $_POST["job_exp"];
                    $JOLDCAMP = $_POST["job_company"];
                    $JDOB = $_POST["job_dob"];
                    $JGENDER = $_POST["job_gender"];
                    $JRELATIVE = $_POST["job_relation"];
                    $JTYPE = "Job Letter";


                    if($_POST["job_id"] != "" && isset($_POST["job_id"])){

                        $JOB_ID = $_POST["job_id"];

                        $SQL_JLI = "UPDATE `job_info` SET `J_Name`= '$JNAME',`J_Dob`='$JDOB',
                                  `J_Gender`='$JGENDER',`J_Email`='$JEMAIL',`J_Phone`='$JPHONE',
                                  `J_Qualification`='$JQUAL',`J_Exp`='$JEXP',`J_Old_Company`='$JOLDCAMP',
                                  `J_Relative`='$JRELATIVE',`J_Type`='$JTYPE',`J_Visibility`='visible'
                                  WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `J_Id` = '$JOB_ID'";

                    }else{

                      $SQL_JLI = "INSERT INTO `job_info`(`J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`,
                                  `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`)
                                  VALUES ('{$JNAME}','{$JDOB}','{$JGENDER}','{$JEMAIL}','{$JPHONE}','{$JQUAL}','{$JEXP}','{$JOLDCAMP}',
                                  '{$last_vid}','{$last_wid}','{$JTYPE}','{$JRELATIVE}','visible')";

                    }


                    // $SQL_JLI = "INSERT INTO `job_info`(`J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`,
                    //             `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`)
                    //             VALUES ('{$JNAME}','{$JDOB}','{$JGENDER}','{$JEMAIL}','{$JPHONE}','{$JQUAL}','{$JEXP}','{$JOLDCAMP}',
                    //             '{$last_vid}','{$last_wid}','{$JTYPE}','{$JRELATIVE}','visible')";


                    if($con->query($SQL_JLI)){
                        $validator['success'] = true;
                        $validator['messages'] .= "Job Data also Added Sucessfully";
                        // echo "Job Data also Added Sucessfully";
                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to Job Data Adding.".$con->error;
                        // echo "Error to Job Data Adding.".$con->error;
                    }

                break;

                case "Complaint":
                        if(isset($_POST['complaint_type']) && $_POST['complaint_type'] != "" && isset($_POST['complaint_cat']) && $_POST['complaint_cat']){
                            $WCTYPE = $_POST['complaint_type'];
                            $WCCAT = $_POST['complaint_cat'];

                            $SQL_WC = "UPDATE `work_detail` SET `W_CType`= '{$WCTYPE}', `W_CCat` = '{$WCCAT}' WHERE `W_Id`= '{$last_wid}'";

                            if($con->query($SQL_WC)){
                                $validator['success'] = true;
                                $validator['messages'] .= " Complaint Data also Added Sucessfully";

                            }else{
                                $validator['success'] = true;
                                $validator['messages'] .= " Error to Update Complaint Data".$con->error;

                            }
                        }

                break;

                case "Letter":

                    switch($_POST["letter_type"]){

                        case "Ration Card":
                            $RCTM = $_POST["ration_l_tman"];
                            $RCTW = $_POST["ration_l_twoman"];
                            $RCTY = $_POST["ration_l_tlive"];

                            if($_POST["RC_Id"] != "" && isset($_POST["RC_Id"])){

                                $RCL_ID = $_POST["RC_Id"];

                                $SQL_L_RC = "UPDATE `ration_card_letter` SET `RC_TM`= '$RCTM',`RC_TW`='$RCTW',
                                          `RC_TY`='$RCTY',`RC_Visibility`='visible'
                                          WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `RC_Id` = '$RCL_ID'";

                            }else{

                              $SQL_L_RC = "INSERT INTO `ration_card_letter`(`RC_TM`, `RC_TW`, `RC_TY`, `V_Id`, `W_Id`, `RC_Visibility`)
                                           VALUES ('{$RCTM}','{$RCTW}','{$RCTY}','{$last_vid}','{$last_wid}','visible')";

                            }

                            // $SQL_L_RC = "INSERT INTO `ration_card_letter`(`RC_TM`, `RC_TW`, `RC_TY`, `V_Id`, `W_Id`, `RC_Visibility`)
                            //              VALUES ('{$RCTM}','{$RCTW}','{$RCTY}','{$last_vid}','{$last_wid}','visible')";

                            $SQL_UWL = "UPDATE `work_detail` SET `W_LType`='Ration Card' WHERE `W_Id`= '{$last_wid}'";


                            if($con->query($SQL_L_RC)){
                                if($con->query($SQL_UWL)){
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Ration Card Letter Data also Added Sucessfully";
                                    // echo "Ration Card Letter Data also Added Sucessfully";
                                }else{
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Error to Update Work letter Type".$con->error;
                                    // echo "Error to Update Work letter Type ".$con->error;
                                }
                            }else{
                                $validator['success'] = true;
                                $validator['messages'] .= "Error to Ration Card Letter Data Adding.".$con->error;
                                // echo "Error to Ration Card Letter Data Adding.".$con->error;
                            }


                        break;


                        case "Identity card":
                            $IDCTY = $_POST["identityC_Year"];

                            // INSERT INTO `ration_card_letter`(`RC_TM`, `RC_TW`, `RC_TY`, `V_Id`, `W_Id`, `RC_Visibility`)
                            // VALUES ('{$RCTM}','{$RCTW}','{$RCTY}','{$last_vid}','{$last_wid}','visible')

                            if($_POST["ID_Id"] != "" && isset($_POST["ID_Id"])){

                                $IDL_ID = $_POST["ID_Id"];

                                $SQL_L_ID = "UPDATE `identitycard_letter` SET `ID_TYear`= '$IDCTY',`ID_Visibility`='visible'
                                          WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `ID_Id` = '$IDL_ID'";

                            }else{

                              $SQL_L_ID = "INSERT INTO `identitycard_letter`(`ID_TYear`, `V_Id`, `W_Id`, `ID_Visibility`)
                                           VALUES ('{$IDCTY}','{$last_vid}','{$last_wid}','visible')";

                            }

                            // $SQL_L_ID = "INSERT INTO `identitycard_letter`(`ID_TYear`, `V_Id`, `W_Id`, `ID_Visibility`)
                            //              VALUES ('{$IDCTY}','{$last_vid}','{$last_wid}','visible')";

                            $SQL_UWL = "UPDATE `work_detail` SET `W_LType`='Identity card' WHERE `W_Id`= '{$last_wid}'";


                            if($con->query($SQL_L_ID)){
                                if($con->query($SQL_UWL)){
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Identity card Letter Data also Added Sucessfully";
                                    // echo "Identity card Letter Data also Added Sucessfully";
                                }else{
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Error to Update Work letter Type".$con->error;
                                    // echo "Error to Update Work letter Type ".$con->error;
                                }
                            }else{
                                $validator['success'] = true;
                                $validator['messages'] .= "Error to Identity card Letter Data Adding.".$con->error;
                                // echo "Error to Identity card Letter Data Adding.".$con->error;
                            }


                        break;


                        case "Residential Certificate":
                            $RC_FOR = $_POST["residentialL_For"];
                            $RC_TYEAR = $_POST["residentialL_Year"];

                            if($_POST["RC_Id"] != "" && isset($_POST["RC_Id"])){

                                $RCL_ID = $_POST["RC_Id"];

                                $SQL_L_ID = "UPDATE `residential_letter` SET `RL_For`= '$RC_FOR', `RL_TYear`= '$RC_TYEAR',`RL_Visibility`='visible'
                                          WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `RL_Id` = '$RCL_ID'";

                            }else{

                              $SQL_L_ID = "INSERT INTO `residential_letter`(`RL_For`,`RL_TYear`, `V_Id`, `W_Id`, `RL_Visibility`)
                                           VALUES ('{$RC_FOR}','{$RC_TYEAR}','{$last_vid}','{$last_wid}','visible')";

                            }

                            // $SQL_L_ID = "INSERT INTO `residential_letter`(`RL_For`,`RL_TYear`, `V_Id`, `W_Id`, `RL_Visibility`)
                            //              VALUES ('{$RC_FOR}','{$RC_TYEAR}','{$last_vid}','{$last_wid}','visible')";

                            $SQL_UWL = "UPDATE `work_detail` SET `W_LType`='Residential Certificate' WHERE `W_Id`= '{$last_wid}'";


                            if($con->query($SQL_L_ID)){
                                if($con->query($SQL_UWL)){
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Residential Certificate Data also Added Sucessfully";
                                    // echo "Identity card Letter Data also Added Sucessfully";
                                }else{
                                    $validator['success'] = true;
                                    $validator['messages'] .= "Error to Update Work letter Type".$con->error;
                                    // echo "Error to Update Work letter Type ".$con->error;
                                }
                            }else{
                                $validator['success'] = true;
                                $validator['messages'] .= "Error to Residential Certificate Data Adding.".$con->error;
                                // echo "Error to Identity card Letter Data Adding.".$con->error;
                            }


                        break;

                        case "Other Letter":

                            if($_POST["CUSTL_Id"] != "" && isset($_POST["CUSTL_Id"])){

                                $CUSTL_ID = $_POST["CUSTL_Id"];

                                $SQL_L_CU = "UPDATE `custom_letter` SET `CL_Visibility`='visible'
                                          WHERE `V_Id`='$last_vid' AND `W_Id`='$last_wid' AND `CL_Id` = '$CUSTL_ID'";

                            }else{

                              $SQL_L_CU = "INSERT INTO `custom_letter`(`CL_Visibility`, `V_Id`, `W_Id`)
                                           VALUES ('visible','{$last_vid}','{$last_wid}')";

                            }

                            // $SQL_L_CU = "INSERT INTO `custom_letter`(`CL_Visibility`, `V_Id`, `W_Id`)
                            //              VALUES ('visible','{$last_vid}','{$last_wid}')";

                            $SQL_UWL = "UPDATE `work_detail` SET `W_LType`='Other Letter' WHERE `W_Id`= '{$last_wid}'";


                            if($con->query($SQL_L_CU)){
                                if($con->query($SQL_UWL)){
                                    $validator['success'] = true;
                                    $validator['messages'] .= " Work letter Type Data also Added Sucessfully";
                                }else{
                                    $validator['success'] = true;
                                    $validator['messages'] .= " Error to Update Work letter Type".$con->error;
                                }
                            }else{
                                $validator['success'] = true;
                                $validator['messages'] .= " Error to Work letter Type Data Adding.".$con->error;

                            }


                        break;
                    }


                break;


            }

            // if($con->query($SQL_L)){
            //     echo "Letter Data also Added Sucessfully";
            // }else{
            //     echo "Error to Letter Data Adding.".$con->error;
            // }



            //Upload Group Details
            if(isset($_POST["gvisitor_name"]) && $VCAT == "Group" && $_POST["gvisitor_name"] != "" )
            {
                for($count = 0; $count < count($_POST["gvisitor_name"]); $count++)
                {
                    $query = "INSERT INTO `group_visitor`(`G_Name`, `G_Phone`, `V_Id`, `W_Id`, `G_Dob`, `G_Gender`) VALUES (?,?,?,?,?,?)";
                    $statement = $con->prepare($query);
                    $statement->bind_param('ssssss', $G_VISITOR_NAME, $G_VISITOR_PHONE, $G_VID, $G_WID, $G_DOB, $G_GENDER);
                        $G_VISITOR_NAME  = $_POST["gvisitor_name"][$count];
                        $G_VISITOR_PHONE = $_POST["gvisitor_phone"][$count];
                        $G_VID = $last_vid;
                        $G_WID = $last_wid;
                        $G_DOB = $_POST["gvisitor_dob"][$count];
                        $G_GENDER = $_POST["gvisitor_gender"][$count];
                    $result = $statement->execute();
                }
                $statement->close();

            }else if($VCAT == "Single") {

            }else{
                $validator['success'] = true;
                $validator['messages'] .= "Error in group: <br>".$con->error;
                echo "Error in group: <br>" . $con->error;
            }


            //Upload Refernce details
            if(isset($_POST["refernce_name"]) && isset($_POST["refernce_phone"]) && $_POST["refernce_name"] !="" && $_POST["refernce_phone"] !="" ){

                $RNAME = $_POST["refernce_name"];
                $RPHONE = $_POST["refernce_phone"];
                $RDOB = $_POST["refernce_dob"];
                $RGENDER = $_POST["refernce_gender"];
                $ROCCUPATION = $_POST["refernce_occupation"];
                $RADDRESS = $_POST["refernce_address"];

                $sql_ref = "INSERT INTO `reference_detail`(`R_Name`, `R_Phone`, `W_Id`, `V_Id`, `R_Dob`, `R_Gender`, `R_Occupation`, `R_Address`)
                            VALUES ('{$RNAME}','{$RPHONE}','{$last_wid}','{$last_vid}','{$RDOB}','{$RGENDER}','{$ROCCUPATION}','{$RADDRESS}')";

                if($con->query($sql_ref)){

                    // echo $con->error;
                    $validator['success'] = true;
                    $validator['messages'] .= " <br>Update Refernce Detail<br>".$con->error;

                    $last_rid = mysqli_insert_id($con);
                    $sql_work_ref = "UPDATE `work_detail` SET `R_Id`= '{$last_rid}' WHERE `W_Id`= '{$last_wid}'";

                    if($con->query($sql_work_ref)){

                        // echo $con->error;

                    }else{
                        $validator['success'] = true;
                        $validator['messages'] .= "Error to update Refernce id to work id<br>".$con->error;
                        // echo "Error to update Refernce id to work id".$con->error;
                    }

                } else {
                    $validator['success'] = true;
                    $validator['messages'] .= "Error to upload Refernce Details".$con->error;
                    // echo "Error to upload Refernce Details".$con->error;
                }
            }



            if(isset($_POST["user_id"]) && $USERID !=""){
                $sql_ul_ref = "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`, `V_Id`, `W_Id`)
                            VALUES ('{$USERID}','Add Detail Visitor and Work','{$last_vid}','{$last_wid}')";

                if($con->query($sql_ul_ref)){

                }else{
                    $validator['success'] = true;
                    $validator['messages'] .= "Error to update user Log to work id<br>".$con->error;
                    // echo "Error to update Refernce id to work id".$con->error;
                }

            }



        }else {
            $validator['success'] = false;
            $validator['messages'] .= "Error: " . $SQL_WORK . "<br>" . $con->error;
            // echo "Error: " . $SQL_WORK . "<br>" . $con->error;
        }


    }else{
        $validator['success'] = false;
        $validator['messages'] .= "Error: " . $SQL_VISITOR . "<br>" . $con->error;
        // echo "Error: " . $SQL_VISITOR . "<br>" . $con->error;
    }

    echo json_encode($validator);

    $con->close();


?>
