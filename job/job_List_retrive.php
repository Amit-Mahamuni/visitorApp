<?php

    require_once "config.php";

    $output = array('data' => array());

    $sql = "SELECT job_info.J_Id, job_info.J_Name, job_info.J_Dob, job_info.W_Id, job_info.J_Gender, job_info.J_Email,
            job_info.J_Phone, job_info.J_Qualification, job_info.J_Exp, job_info.J_Type,
            work_detail.Status FROM job_info INNER JOIN work_detail ON job_info.W_Id = work_detail.W_Id
            WHERE job_info.J_Visibility = 'visible' AND work_detail.Visibility = 'visible' ";


    if(isset($_POST["category"]) && $_POST["category"] != "" && $_POST["category"] != 'All'){
        $CAT = $_POST["category"];
        $sql .= " AND job_info.J_Type = '$CAT'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $STATUS = $_POST["status"];
        $sql .= " AND work_detail.Status = '$STATUS'";
    }

    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $DATEFROM = $_POST["dateform"];
        $DATEEND = $_POST["dateend"];

        $sql .= " AND work_detail.Work_add_date BETWEEN '$DATEFROM' AND '$DATEEND'";

    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $DATEFROM = $_POST["dateform"];
        $DATEEND = $_POST["dateend"];

        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){

            $sql .= " AND work_detail.Work_add_date > '$DATEFROM'";

        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){

            $sql .= " AND work_detail.Work_add_date < '$DATEEND'";

        }

    }

    $sql .= "ORDER BY job_info.J_Id";

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

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#JobModal" onclick="editJob('.$row['J_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#JobModal" onclick="rmoveJob('.$row['J_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick="detailWork('.$row['W_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['J_Id'],
            "<strong>".$row['J_Name']."</strong><br>".$row['J_Email']."|".$row['J_Phone'],
            $row['J_Qualification']." | <strong>Exp.: </strong>". $row['J_Exp'],
            $row['J_Dob']." | ".$row['J_Gender'],
            $status,
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

?>
