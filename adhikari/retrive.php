<?php

    require_once "config.php";

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


    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['AD_Status'] == 'Active'){
            $status = '<span class="badge badge-success p-1">Active</span>';
        }elseif($row['AD_Status'] == 'In-Active'){
            $status = '<span class="badge badge-warning p-1">In-Active</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">Other</span>';
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="editKarykarta('.$row['AD_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="rmoveAdhikari('.$row['AD_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="infoAdhikari('.$row['AD_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['AD_Id'],
            '<strong>'.$row['AD_Name'].'</strong>',
            $row['AD_Department'].'<br>'.$row['AD_Occupation'],
            $row['AD_Phone'].'<br>'.$row['AD_Email'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
