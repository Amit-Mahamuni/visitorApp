<?php

    require_once "config.php";

    $PRIORTY = $_POST["priorty"];
    $STATUS = $_POST["status"];
    $DATEFROM = $_POST["dateform"];
    $DATEEND = $_POST["dateend"];

    $output = array('data' => array());

    $sql = "SELECT education_info.E_Id, education_info.E_Student_Name, education_info.E_Collage_Name, 
                    education_info.E_Class, education_info.E_T_Fee, education_info.E_D_Fee, education_info.W_Id 
            FROM education_info INNER JOIN work_detail ON education_info.W_Id = work_detail.W_Id 
            WHERE work_detail.Visibility = 'visible' AND education_info.E_Visibility = 'visible'";


    if(isset($_POST["priorty"]) && $_POST["priorty"] != "" && $_POST["priorty"] != 'All'){
        $sql .= "AND  work_detail.Priority ='$PRIORTY'";
    }
    if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
        $sql .= "AND  work_detail.Status ='$STATUS'";
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

    $sql .= "ORDER BY E_Id DESC";





    $query = $con->query($sql);

    
    while($row = $query->fetch_assoc()){

        // `E_Id`, `E_Student_Name`, `E_Collage_Name`, `E_Class`, `E_T_Fee`, `E_D_Fee`, `V_Id`, `W_Id`, `E_Visibility`

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#educationModal" onclick="editEducation('.$row['E_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#educationModal" onclick="removeEducation('.$row['E_Id'].')">Rmove</button>
                         <button type="button" class="btn btn-info btn-sm" onclick="detailWork('.$row['W_Id'].')">Info</button>';

        $output['data'][] = array(
            $row['E_Id'],
            $row['E_Student_Name'],
            $row['E_Collage_Name'],
            $row['E_Class'],
            $row['E_D_Fee']." | ".$row['E_T_Fee'],         
            $actionButton
        );
        
    }

    $con->close();
 
    echo json_encode($output);

?>