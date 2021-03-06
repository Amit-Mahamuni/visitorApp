<?php

    require_once "config.php";

    $CAT = $_POST["category"];
    $SUBCAT = $_POST["subcategory"];
    $VOTER = $_POST["voter"];
    $GENDER = $_POST["gender"];
    $PRIORTY = $_POST["priorty"];
    $STATUS = $_POST["status"];
    $DATEFROM = $_POST["dateform"];
    $DATEEND = $_POST["dateend"];

    $output = array('data' => array());

    $sql = "SELECT visitor_info.V_Id, visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email,
            visitor_info.V_Dob, visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode
            FROM visitor_info INNER JOIN work_detail
            ON visitor_info.V_Id = work_detail.V_Id WHERE visitor_info.V_Visibility = 'visible'
            AND work_detail.Visibility = 'visible' ";


if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
    $sql .= " AND work_detail.Work_Category = '$CAT'";
}
if(isset($_POST["subcategory"]) && $_POST["subcategory"] != "" && $_POST["subcategory"] != 'All'){
    $sql .= " AND work_detail.Work_Subcategory = '$SUBCAT'";
}
if(isset($_POST["voter"]) && $_POST["voter"] != "" && $_POST["voter"] != 'All'){
    $sql .= " AND visitor_info.V_Voter = '$VOTER'";
}
if(isset($_POST["gender"]) && $_POST["gender"] != "" && $_POST["gender"] != 'All'){
    $sql .= " AND visitor_info.V_Gender = '$GENDER'";
}
if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
    $sql .= " AND work_detail.Priority = '$PRIORTY'";
}
if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
    $sql .= " AND work_detail.Status = '$STATUS'";
}


if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

    $sql .= "AND work_detail.Work_add_date BETWEEN '$DATEFROM' AND '$DATEEND'";

}else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

    if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

        $sql .= "AND work_detail.Work_add_date > '$DATEFROM'";

    }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $sql .= "AND work_detail.Work_add_date < '$DATEEND'";

    }

}



$sql .= " ORDER BY `V_Id` DESC";














    $query = $con->query($sql);

    while($row = $query->fetch_assoc()){


        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#visitorModal" onclick="editVisitor('.$row['V_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#visitorModal" onclick="rmoveVisitor('.$row['V_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailvisitor('.$row['V_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['V_Id'],
            '<strong>'.$row['V_Name'].'</strong>',
            $row['V_Phone'].'<br>'.$row['V_Email'],
            $row['V_Gender'].'|'.$row['V_Dob'],
            $row['V_Address'].', '.$row['V_City'].' - '.$row['V_Pincode'],
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
