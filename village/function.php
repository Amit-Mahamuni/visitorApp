<?php
require_once "config.php";

if($_POST['action'] == "getData")
{
    $WI_ID = $_POST['invition_Id'];

    $output = array('data' => array());

    $sql = "SELECT invitation.I_Id, invitation.I_Title, invitation.I_Date, invitation.I_Time, 
            invitation.I_Address, invitation.WI_BName, invitation.WI_GName, invitation.I_Type,
            invitation.W_Id, invitation.V_Id, invitation.I_Status, work_detail.Work_Doc 
            FROM invitation INNER JOIN work_detail 
            ON invitation.W_Id = work_detail.W_Id 
            WHERE invitation.I_Visibility = 'visible' 
            AND invitation.I_Id =  $WI_ID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);


}else if($_POST['action'] == "removeInvitation"){

    $RM_WIID = $_POST['WI_Id'];
    $WID = $_POST['WID'];
    $VID = $_POST['VID'];

    if($RM_WIID != ""){

        $output_rm_visitor = array('success' => false, 'messages' => array());    

        // UPDATE `work_detail` SET `Visibility`=[value-11],WHERE `V_Id`= 
        
        $sql_rm_visitor =  "UPDATE `work_detail` SET `Visibility`='hidden' WHERE `W_Id` ={$WID} AND `V_Id`={$VID};";
        // UPDATE `invitation` SET `I_Visibility`='hidden' WHERE `I_Id`=7
        $sql_rm_visitor .=  "UPDATE `invitation` SET `I_Visibility`= 'hidden' WHERE `I_Id`={$RM_WIID} AND `W_Id`={$WID} AND`V_Id`={$VID}";
       

        $query_rm_visitor = $con->multi_query($sql_rm_visitor);
        if($query_rm_visitor === TRUE) {

            $output_rm_visitor['success'] = true;
            $output_rm_visitor['messages'] = 'Successfully removed Invitation Detail';
        } else {
            $output_rm_visitor['success'] = false;
            $output_rm_visitor['messages'] = 'Error while removing Invitation Detail'.$con->error;
        }
        
        // close database connection
        $con->close();        
        echo json_encode($output_rm_visitor);

    }else{
      
        $output_rm_visitor['success'] = false;
        $output_rm_visitor['messages'] = 'Error No ID Pass'.$con->error;
        $con->close();        
        echo json_encode($output_rm_visitor);  
    }

}else if($_POST['action'] == "todayWorkEntry_invitation"){

    $output_t_visitor = array('success' => false, 'total' => '');   

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                        AND `Work_Category`='Invitation'
                        AND  work_detail.Work_add_date > CURRENT_DATE";
    
    $query_t_visitor = $con->query($sql_t_visitor);

    $result = $query_t_visitor->num_rows;

    $con->close();        
    echo json_encode($result);
    
}else if($_POST['action'] == "invitation"){
    $CAT = $_POST["category"];
    $PRIORTY = $_POST["priorty"];
    $STATUS = $_POST["status"];
    $DATEFROM = $_POST["dateform"];
    $DATEEND = $_POST["dateend"];

    $output = array('data' => array());
    
    $sql = "SELECT invitation.I_Id, invitation.I_Title, invitation.I_Address, invitation.I_Date, 
            invitation.I_Time, invitation.I_Type, invitation.I_Visibility,
            invitation.I_Status, invitation.WI_BName, invitation.WI_GName, work_detail.Priority 
            FROM invitation INNER JOIN work_detail ON invitation.W_Id = work_detail.W_Id 
            WHERE invitation.I_Visibility = 'visible'";


    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $sql .= " AND invitation.I_Type = '$CAT'";
    }
    if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
        $sql .= " AND work_detail.Priority = '$PRIORTY'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= " AND invitation.I_Status = '$STATUS'";
    }


    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $sql .= " AND invitation.I_Date BETWEEN '$DATEFROM' AND '$DATEEND'";
        
    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

            $sql .= " AND invitation.I_Date > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= " AND invitation.I_Date < '$DATEEND'";
            
        }

    }



    $sql .= "ORDER BY `I_Id` DESC";


    $query = $con->query($sql);

    while($row = $query->fetch_assoc()){

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#InvitationModal" onclick="editInvitation('.$row['I_Id'].')"><i class="fa fa-edit"></i></button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#InvitationModal" onclick="rmoveInvitation('.$row['I_Id'].')"><i class="fa fa-trash"></i></button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailWork('.$row['I_Id'].')"><i class="fa fa-info"></i></button>';

        $output['data'][] = array(
            // $row['I_Id'],
            $row['I_Title'],
            $row['I_Address'],
            $row['I_Type'],
            $row['I_Date'].' | '.$row['I_Time'],              
            $actionButton
        );
        
    }

    $con->close();
 
    echo json_encode($output);
}

else{
    echo "No action selected".$con->error();
}


?>