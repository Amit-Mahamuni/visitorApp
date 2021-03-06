<?php

    require_once "config.php";


    $output = array('data' => array());
    $sql = "SELECT visitor_info.V_Id, visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob,
                    visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode, visitor_info.V_Category,
                    visitor_info.Visitor_Profile, visitor_info.V_Adhar_Card, visitor_info.V_Voter_Card, visitor_info.V_Pan_Card, visitor_info.V_Type,
                    visitor_info.V_Voter, work_detail.W_Id, work_detail.Work_title, work_detail.Priority, work_detail.Work_Category,
                    work_detail.Work_Subcategory, work_detail.Work_detail, work_detail.Status, work_detail.Work_Doc, work_detail.Work_From,
                    work_detail.W_LType, work_detail.W_CType, work_detail.W_CCat, work_detail.Work_add_date
                    FROM visitor_info INNER JOIN work_detail ON visitor_info.V_Id = work_detail.V_Id
                    WHERE work_detail.Visibility = 'visible'  ";


    // $sql = "SELECT * FROM `work_detail` WHERE `Visibility`='visible'";

    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
      $CAT = $_POST["category"];
        $sql .= " AND `Work_Category`='$CAT'";
    }
    if(isset($_POST["subcategory"]) && $_POST["subcategory"] != "" && $_POST["subcategory"] != 'All'){
      $SUBCAT = $_POST["subcategory"];
        $sql .= " AND `Work_Subcategory`='$SUBCAT'";
    }
    if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
      $PRIORTY = $_POST["priorty"];
        $sql .= " AND `Priority`='$PRIORTY'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
      $STATUS = $_POST["status"];
        $sql .= " AND `Status`='$STATUS'";
    }


    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

      $DATEFROM = $_POST["dateform"];
      $DATEEND = $_POST["dateend"];

        $sql .= " AND `Work_add_date` BETWEEN '$DATEFROM' AND '$DATEEND'";

    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

      $DATEFROM = $_POST["dateform"];
      $DATEEND = $_POST["dateend"];

        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

            $sql .= " AND `Work_add_date` > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= " AND `Work_add_date` < '$DATEEND'";

        }

    }



    $sql .= "ORDER BY work_detail.W_Id DESC";



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
            '<strong>'.$row['V_Name'].'</strong><br>'.$row['V_Phone'].' | '.$row['V_Address'].' - '.$row['V_City'].' - '.$row['V_Pincode'],
            '<strong>'.$row['Work_title'].'</strong><br>'.$row['Work_Category'].' | '.$row['Work_Subcategory'].' | '.$row['Work_add_date'],
            // $row['Priority'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
