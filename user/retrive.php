<?php

    require_once "config.php";

    $KSTATUS = $_POST["status"];
    $CAT = $_POST["category"];

    // `U_Id`, `U_Username`, `U_Password`, `U_Status`, `U_Department`, `U_Name`,
    // `U_Phone`, `U_Email`, `U_Gender`, `U_Dob`, `U_Address`, `U_City`, `U_Pincode`, `U_Visibility`, `U_Profile_Img`


    $output = array('data' => array());

    $sql = "SELECT * FROM `user_info` WHERE `U_Visibility` = 'visible'";

    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $sql .= " AND `U_Department`='$CAT'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= " AND `U_Status`='$KSTATUS'";
    }

    $sql .= "ORDER BY `U_Id` DESC";



    $query = $con->query($sql);


    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['U_Status'] == 'Active'){
            $status = '<span class="badge badge-success p-1">Active</span>';
        }elseif($row['U_Status'] == 'In-Active'){
            $status = '<span class="badge badge-warning p-1">In-Active</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">Other</span>';
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="editKarykarta('.$row['U_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="rmoveKarykarta('.$row['U_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="infoKarykarta('.$row['U_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['U_Id'],
            "<strong>".$row['U_Name']."</strong>",
            "<a href='tel:'".$row['U_Phone'].">".$row['U_Phone'].'</a><br>'.$row['U_Email'],
            $row['U_Gender'].'|'.$row['U_Dob'],
            $row['U_Address'].'<br>'.$row['U_City'].' - '.$row['U_Pincode'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
