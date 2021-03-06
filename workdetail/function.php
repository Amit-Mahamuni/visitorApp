<?php

require_once "config.php";
if(isset($_POST)){

    if($_POST["action"] == "Education"){


        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());
    
        $sql = "SELECT education_info.E_Id, education_info.E_Student_Name, education_info.E_Collage_Name, 
                education_info.E_Class, education_info.E_T_Fee, education_info.E_D_Fee, 
                education_info.E_Visibility, work_detail.Work_Doc 
                FROM education_info INNER JOIN work_detail ON education_info.W_Id = work_detail.W_Id 
                WHERE education_info.E_Visibility = 'visible' AND work_detail.Visibility = 'visible' AND work_detail.W_Id = $W_ID";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
        
        echo json_encode($result);

    }else if($_POST["action"] == "invitation"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());
    
        $sql = "SELECT invitation.I_Id, invitation.I_Title, invitation.I_Date, invitation.I_Time, 
                invitation.I_Address, invitation.WI_BName, invitation.WI_GName, invitation.I_Type,
                invitation.W_Id, invitation.V_Id, invitation.I_Status, work_detail.Work_Doc 
                FROM invitation INNER JOIN work_detail 
                ON invitation.W_Id = work_detail.W_Id 
                WHERE invitation.I_Visibility = 'visible' 
                AND work_detail.W_Id =  $W_ID";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);


    }else if($_POST["action"] == "Medical_Letter"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());        

    
        $sql = "SELECT medical_letter.ML_Id, medical_letter.W_Id, medical_letter.V_Id, medical_letter.ML_Hospital,
                medical_letter.ML_Ward, medical_letter.ML_Bed, medical_letter.ML_Disease, medical_letter.ML_Admit_Date,
                medical_letter.ML_Final_Letter, medical_letter.ML_PName, medical_letter.ML_PDob, 
                medical_letter.ML_PGender, medical_letter.ML_PRelation, work_detail.Work_Doc FROM medical_letter INNER JOIN work_detail 
                ON medical_letter.W_Id = work_detail.W_Id WHERE work_detail.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "Job"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());  
        
        // SELECT job_info.J_Id, job_info.J_Name, job_info.J_Dob, job_info.J_Gender, job_info.J_Email, 
        //     job_info.J_Phone, job_info.J_Qualification, job_info.J_Exp, job_info.J_Type, job_info.V_Id, job_info.W_Id, 
        //     job_info.J_Old_Company, job_info.J_Relative, job_info.J_Type, 
        //     work_detail.Status, work_detail.Work_Doc FROM job_info INNER JOIN work_detail ON job_info.W_Id = work_detail.W_Id 
        //     WHERE job_info.J_Visibility = 'visible' AND work_detail.Visibility = 'visible' AND work_detail.W_Id = '$W_ID'

    
        $sql = "SELECT job_info.J_Id, job_info.J_Name, job_info.J_Dob, job_info.J_Gender, job_info.J_Email, 
        job_info.J_Phone, job_info.J_Qualification, job_info.J_Exp, job_info.J_Type, job_info.J_LFinal, 
        job_info.J_Old_Company, job_info.J_Relative, job_info.J_Type, 
        work_detail.Status, work_detail.Work_Doc FROM job_info INNER JOIN work_detail ON job_info.W_Id = work_detail.W_Id 
        WHERE job_info.J_Visibility = 'visible' AND work_detail.Visibility = 'visible' AND work_detail.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "RationCard"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());  
        
        $sql = "SELECT ration_card_letter.RC_Id, ration_card_letter.RC_TM, ration_card_letter.RC_TW, ration_card_letter.RC_TY,
        ration_card_letter.RC_FLetter,ration_card_letter.RC_CDate,
        work_detail.Status, work_detail.Work_Doc       
        FROM ration_card_letter INNER JOIN work_detail ON ration_card_letter.W_Id = work_detail.W_Id 
        WHERE ration_card_letter.RC_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
        AND ration_card_letter.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "IdentityCard"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());  
        
        $sql = "SELECT identitycard_letter.ID_Id, identitycard_letter.ID_TYear, identitycard_letter.ID_FLetter, identitycard_letter.ID_CDate,
        work_detail.Status, work_detail.Work_Doc       
        FROM identitycard_letter INNER JOIN work_detail ON identitycard_letter.W_Id = work_detail.W_Id 
        WHERE identitycard_letter.ID_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
        AND identitycard_letter.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "ResidentailLetter"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());  

        // residential_letter `RL_Id`, `RL_For`, `RL_TYear`, `RL_To`, `RL_Subject`, `RL_Detail`,
        //  `RL_Sign`, `V_Id`, `W_Id`, `RL_FLetter`, `RL_C_Date`, `RL_Visibility`
        
        $sql = "SELECT residential_letter.RL_Id, residential_letter.RL_For, residential_letter.RL_TYear, 
                residential_letter.RL_FLetter, residential_letter.RL_C_Date,
                work_detail.Status, work_detail.Work_Doc       
                FROM residential_letter INNER JOIN work_detail ON residential_letter.W_Id = work_detail.W_Id 
                WHERE residential_letter.RL_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                AND residential_letter.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "CutomLetter"){

        $W_ID = $_POST['work_Id'];

        $output = array('data' => array());  
        
        $sql = "SELECT custom_letter.CL_FLetter, custom_letter.CL_CDate,
                work_detail.Status, work_detail.Work_Doc       
                FROM custom_letter INNER JOIN work_detail ON custom_letter.W_Id = work_detail.W_Id 
                WHERE custom_letter.CL_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                AND custom_letter.W_Id = '$W_ID'";
    
        $query = $con->query($sql);
    
        $result = $query->fetch_assoc();
    
        $con->close();
     
        echo json_encode($result);

    }else if($_POST["action"] == "adhikariDetail"){


        // $DEPARTMENT = $_POST["Department"];
        $output = array('data' => array());

        $KSTATUS = $_POST["status"];
        $CAT = $_POST["category"];
    
    
        $output = array('data' => array());
    
        $sql = "SELECT * FROM `adhikari_info` WHERE `AD_Visibility`= 'visible'";
    
        if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
            $sql .= " AND `AD_Department` = '$CAT'";
        }
        if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
            $sql .= " AND `AD_Status` = '$KSTATUS'";
        }
    
        $sql .= "ORDER BY `AD_Id` DESC";

        $query = $con->query($sql);
    
        $i=1;
        while($row = $query->fetch_assoc()){
            $status = '';
            if($row['AD_Status'] == 'Active'){
                $status = '<span class="badge badge-success p-1">Active</span>';
            }elseif($row['AD_Status'] == 'In-Active'){
                $status = '<span class="badge badge-warning p-1">In-Active</span>';
            }else{
                $status = '<span class="badge badge-dark p-1">UnKnow</span>';   
            }
    
            $actionButton = '<button type="button" class="btn btn-primary btn-sm"  onclick="assignAdhikari('.$row['AD_Id'].')">Assign</button>';
    
            $output['data'][] = array(
                $row['AD_Id'],
                $row['AD_Name'],
                $row['AD_Department'].'<br>'.$row['AD_Occupation'],
                $row['AD_Phone'].'<br>'.$row['AD_Email'],            
                $status,           
                $actionButton
            );
            $i++;
        }
    
        $con->close();
        
        echo json_encode($output);
        
            

    }else if($_POST["action"] == "get_Adhikari_detail"){

        $A_Id = $_POST['AID'];

        $output = array('data' => array());

        $sql = "SELECT * FROM `adhikari_info` WHERE `AD_Id` = $A_Id ";

        $query = $con->query($sql);

        $result = $query->fetch_assoc();

        $con->close();
    
        echo json_encode($result);

    }

}else{
    echo "No Data Get Pass";
}


?>
