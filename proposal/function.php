<?php

require_once "config.php";

if($_POST['action'] == 'getProposalList'){    

    $output = array('data' => array());
   
    $sql = "SELECT * FROM `proposal_info` WHERE `P_Visibility` = 'visible'";

    if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
        $PRIORTY = $_POST["priorty"];
        $sql .= " AND `P_Priority` = '$PRIORTY'";
    }

    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $STATUS = $_POST["status"];
        $sql .= " AND `P_Status` = '$STATUS' ";
    }

    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){
        
        $DATEFROM = $_POST["proposal_info,dateform"];
        $DATEEND = $_POST["proposal_info,dateend"];

        $sql .= " AND `P_Add_Date` BETWEEN '$DATEFROM' AND '$DATEEND'";
        
    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $DATEFROM = $_POST["proposal_info,dateform"];
        $DATEEND = $_POST["proposal_info,dateend"];

        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

            $sql .= " AND DATE(`proposal_info.P_Add_Date`) > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= " AND DATE(`proposal_info.P_Add_Date`) < '$DATEEND'";
            
        }

    }

    $sql .= "ORDER BY proposal_info.P_Id DESC";
    $query = $con->query($sql);
    
    while($row = $query->fetch_assoc()){

        $status = '';

        if($row['P_Status'] == 'Complete'){

            $status = '<span class="badge badge-success p-1">Complete</span>';

        }elseif($row['P_Status'] == 'Under Process'){

            $status = '<span class="badge badge-warning p-1">Under Process</span>';

        }else{

            $status = '<span class="badge badge-dark p-1">Pending</span>';

        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ProposalModal" onclick="editProposal('.$row['P_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ProposalModal" onclick="rmoveProposal('.$row['P_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailProPosal('.$row['P_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['P_Id'],
            $row['P_To'],
            $row['P_Subject'],
            $row['P_Add_Date'],
            $status,           
            $actionButton
        );        
    }

    $con->close();
 
    echo json_encode($output);

}else if($_POST['action'] =='todaytotalProposal'){

    $sql_t_proposal =  "SELECT `P_Id` FROM `proposal_info` WHERE `P_Visibility` = 'visible' AND `P_Add_Date` > CURRENT_DATE";
    
    $output_t_proposal = $con->query($sql_t_proposal);

    $result = $output_t_proposal->num_rows;

    $con->close();   

    echo json_encode($result);

}else if($_POST['action'] == 'getData'){

    $P_ID = $_POST['proposal_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `proposal_info` WHERE `P_Id` = $P_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST['action'] == 'removeProposal'){

    $P_ID = $_POST['P_Id'];

    if($P_ID != ""){

        $output_rm_proposal = array('success' => false, 'messages' => array()); 
        
        $sql_rm_proposal =  "UPDATE `proposal_info` SET `P_Visibility`= 'hidden' WHERE `P_Id` = {$P_ID}";       

        $query_rm_proposal = $con->multi_query($sql_rm_proposal);

        if($query_rm_proposal === TRUE) {

            $output_rm_proposal['success'] = true;
            $output_rm_proposal['messages'] = 'Successfully removed Proposal Detail';

        } else {

            $output_rm_proposal['success'] = false;
            $output_rm_proposal['messages'] = 'Error while removing Proposal Detail'.$con->error;

        }
        
        $con->close();        
        echo json_encode($output_rm_proposal);

    }else{
      
        $output_rm_proposal['success'] = false;
        $output_rm_proposal['messages'] = 'Error No ID Pass'.$con->error;

        $con->close();   

        echo json_encode($output_rm_proposal);  
    }

}else if($_POST['action'] == 'getdefaultData'){

    $P_ID = '1';

    $output = array('data' => array());

    $sql_dfd = "SELECT `P_To`, `P_Subject`, `P_Detail`, `P_Sign`  FROM `proposal_info` WHERE `P_Id`= $P_ID";

    $query_dfd = $con->query($sql_dfd);

    $result_dfd = $query_dfd->fetch_assoc();

    $con->close();
 
    echo json_encode($result_dfd);

}else if($_POST['action'] == 'updateDefaultProposalLetterFormat'){

    $validator_update = array('success' => false, 'messages' => array());

    $PL_TO = $_POST["letter_to"];
    $PL_SUBJECT = $_POST["letter_subject"];
    $PL_DETAIL = $_POST["letter_detail"];
    $PL_SIGN = $_POST["letter_sign"];
    $PL_Id = '1';

    $sql_update = "UPDATE `proposal_info` SET `P_To`='$PL_TO',`P_Subject`='$PL_SUBJECT',
            `P_Detail`='$PL_DETAIL',`P_Sign`='$PL_SIGN' WHERE `P_Id` = '$PL_Id'";

    $query_ml = $con->query($sql_update);           
  
    if($query_ml === TRUE) { 

        $validator_update['success'] = true;
        $validator_update['messages'] = 'Successfully Update Default Proposal Letter Format Detail';

    }else{

        $validator_update['success'] = false;
        $validator_update['messages'] = 'Error Update Default Proposal Letter Format Detail'.$con->error; 

    }

    $con->close();

    echo json_encode($validator_update);

}else if($_POST['action'] == 'getProposalData'){

    $P_ID = $_POST['Proposal_Id'];

    $output = array('data' => array());

    $sql_dfd = "SELECT * FROM `proposal_info` WHERE `P_Id`= $P_ID";

    $query_dfd = $con->query($sql_dfd);

    $result_dfd = $query_dfd->fetch_assoc();

    $con->close();
 
    echo json_encode($result_dfd);

}else if($_POST['action'] == 'updateProposalLetter'){

    $validator_update = array('success' => false, 'messages' => array());

    $PL_TO = $_POST["letter_to"];
    $PL_SUBJECT = $_POST["letter_subject"];
    $PL_DETAIL = $_POST["letter_detail"];
    $PL_SIGN = $_POST["letter_sign"];
    $PL_Id = $_POST["Proposal_Id"];

    $sql_update = "UPDATE `proposal_info` SET `P_To`='$PL_TO',`P_Subject`='$PL_SUBJECT',
            `P_Detail`='$PL_DETAIL',`P_Sign`='$PL_SIGN',`P_Status`='Under Process'  WHERE `P_Id`='$PL_Id'";

    $query_ml = $con->query($sql_update);           
  
    if($query_ml === TRUE) { 

        $validator_update['success'] = true;
        $validator_update['messages'] = 'Successfully Update Proposal Letter Detail';

    }else{

        $validator_update['success'] = false;
        $validator_update['messages'] = 'Error Update Proposal Letter Detail'.$con->error; 

    }

    $con->close();

    echo json_encode($validator_update);

}else if($_POST["action"] == "uploadProposalFile"){

    $P_Id = $_POST["P_Id"];
    $C_DATE = date("Y-m-d");

    $documentName = "ProposalLetter-".$P_Id."-".$_FILES["final_document"]["name"];
    $target_dir_ml_letter = "../image/proposal/final_Letter/";
    $target_file_ml_letter = $target_dir_ml_letter . basename($documentName);

    if($_FILES["final_document"]["size"] > 400000) {

        echo "File size should not be greated than 400Kb";  

    }else{

        if(move_uploaded_file($_FILES["final_document"]["tmp_name"], $target_file_ml_letter)) {

            $sql_upload = "UPDATE `proposal_info` SET `P_Status`='Complete',`P_FLetter`='{$documentName}', 
                            `P_CDate` = '{$C_DATE}' WHERE `P_Id` = '{$P_Id}'";
            
            if($con->query($sql_upload)){

                echo "Image uploaded and saved in the Database".$C_DATE;  

            } else {

                echo "There was an erro uploading the file".$con->error; 

            }

        }else {

            echo "There was an erro uploading the file".$con->error;   

        }

    }

}


?>