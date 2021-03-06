<?php

    require_once "config.php";

    $CAT = $_POST["category"];
    $PRIORTY = $_POST["priorty"];
    $STATUS = $_POST["status"];
    $DATEFROM = $_POST["dateform"];
    $DATEEND = $_POST["dateend"];

    $output = array('data' => array());
    
    $sql = "SELECT invitation.I_Id, invitation.I_Title, invitation.I_Address, invitation.I_Date, 
            invitation.I_Time, invitation.I_Type, invitation.I_Visibility,
            invitation.I_Status, invitation.WI_BName, invitation.WI_GName, work_detail.Priority, work_detail.W_Id 
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

            $sql .= " AND DATE(invitation.I_Date) > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= " AND DATE(invitation.I_Date) < '$DATEEND'";
            
        }
    }

    $sql .= "ORDER BY `I_Id` DESC";

    $query = $con->query($sql);

    while($row = $query->fetch_assoc()){

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#InvitationModal" onclick="editInvitation('.$row['I_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#InvitationModal" onclick="rmoveInvitation('.$row['I_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailWork('.$row['W_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['I_Id'],
            $row['I_Title'],
            $row['I_Address'],
            $row['I_Type'],
            $row['I_Date'].' | '.$row['I_Time'],              
            $actionButton
        );
        
    }

    $con->close();
 
    echo json_encode($output);

?>