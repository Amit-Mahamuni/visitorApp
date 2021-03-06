<?php

    require_once "config.php";

    $KSTATUS = $_POST["status"];
    $CAT = $_POST["category"];


    $output = array('data' => array());

    // `CO_Id`, `CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`, `CO_Address`, `CO_City`,
    // `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`, `CO_Profile_img`

    $sql = "SELECT * FROM `connector_info` WHERE `CO_Visibility` = 'visible'";

    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $sql .= " AND `CO_Occupation` = '$CAT'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= " AND `CO_Status` = '$KSTATUS'";
    }

    $sql .= "ORDER BY `CO_Id` DESC";



    $query = $con->query($sql);


    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['CO_Status'] == 'Active'){
            $status = '<span class="badge badge-success p-1">Active</span>';
        }elseif($row['CO_Status'] == 'In-Active'){
            $status = '<span class="badge badge-warning p-1">In-Active</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">Other</span>';
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="editConnector('.$row['CO_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="rmoveConnector('.$row['CO_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="infoConnector('.$row['CO_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['CO_Id'],
            $row['CO_Name'],
            $row['CO_Phone'].' | <br/>'.$row['CO_Mail'],
            $row['CO_Occupation'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
