<?php

    require_once "config.php";

    $output = array('data' => array());
    $sql = "SELECT * FROM `education_info` WHERE `E_Visibility`='visible' ORDER BY E_Id DESC ";
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