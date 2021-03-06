<?php

    require_once "config.php";

    $KSTATUS = $_POST["status"];
    $CAT = $_POST["category"];


    $output = array('data' => array());

    $sql = "SELECT * FROM `karykarta` WHERE `K_Visibility` = 'visible'";

    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $sql .= " AND `K_Department`='$CAT'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= " AND `K_Status`='$KSTATUS'";
    }

    $sql .= "ORDER BY K_Id DESC";



    $query = $con->query($sql);


    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['K_Status'] == 'Active'){
            $status = '<span class="badge badge-success p-1">Active</span>';
        }elseif($row['K_Status'] == 'In-Active'){
            $status = '<span class="badge badge-warning p-1">In-Active</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">Other</span>';
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="editKarykarta('.$row['K_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="rmoveKarykarta('.$row['K_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="infoKarykarta('.$row['K_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['K_Id'],
            '<strong>'.$row['K_Name'].'</strong>',
            $row['K_Phone'].'<br>'.$row['K_Email'],
            $row['K_Gender'].'|'.$row['K_Dob'],
            $row['K_Address'].'<br>'.$row['K_City'].' - '.$row['K_Pincode'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
