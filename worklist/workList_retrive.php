<?php

    require_once "config.php";

    $CAT = $_POST["category"];
    $SUBCAT = $_POST["subcategory"];
    $PRIORTY = $_POST["priorty"];
    $STATUS = $_POST["status"];
    $DATEFROM = $_POST["dateform"];
    $DATEEND = $_POST["dateend"];


    $output = array('data' => array());
    // $sql = "SELECT * FROM `work_detail` WHERE `Visibility`='visible' AND `Work_Category`='Government' AND `Work_Subcategory`='Complaint' ORDER BY W_Id DESC ";


    $sql = "SELECT * FROM `work_detail` WHERE `Visibility`='visible'";

    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $sql .= "AND `Work_Category`='$CAT'";
    }
    if(isset($_POST["subcategory"]) && $_POST["subcategory"] != "" && $_POST["subcategory"] != 'All'){
        $sql .= "AND `Work_Subcategory`='$SUBCAT'";
    }
    if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
        $sql .= "AND `Priority`='$PRIORTY'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= "AND `Status`='$STATUS'";
    }


    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $sql .= "AND `Work_add_date` BETWEEN '$DATEFROM' AND '$DATEEND'";

    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

            $sql .= "AND `Work_add_date` > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= "AND `Work_add_date` < '$DATEEND'";

        }

    }



    $sql .= "ORDER BY W_Id DESC";



    $query = $con->query($sql);


    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['Status'] == 'Complete'){
            $status = '<span class="badge badge-success p-1">Complete</span>';
        }elseif($row['Status'] == 'Under Process'){
            $status = '<span class="badge badge-warning p-1">Under Process</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">Pending</span>';
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="editWork('.$row['W_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeMemberModal" onclick="removeWork('.$row['W_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailWork('.$row['W_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['W_Id'],
            '<strong>'.$row['Work_title'].'</strong>',
            $row['Work_Category'].'<br> - '.$row['Work_Subcategory'],
            $row['Work_add_date'],
            // $row['Priority'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
