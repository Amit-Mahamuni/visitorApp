<?php

    require_once "config.php";

    if(isset($_POST["Department"]) ){

    $DEPARTMENT = $_POST["Department"];
    $output = array('data' => array());
    $sql = "SELECT * FROM `karykarta` WHERE `K_Visibility` = 'visible' AND `K_Department` = '$DEPARTMENT'";
    $query = $con->query($sql);

    $i=1;
    while($row = $query->fetch_assoc()){
        $status = '';
        if($row['K_Status'] == 'Active'){
            $status = '<span class="badge badge-success p-1">Active</span>';
        }elseif($row['K_Status'] == 'In-Active'){
            $status = '<span class="badge badge-warning p-1">In-Active</span>';
        }else{
            $status = '<span class="badge badge-dark p-1">UnKnow</span>';   
        }

        $actionButton = '<button type="button" class="btn btn-primary btn-sm"  onclick="assignkarykarta('.$row['K_Id'].')">Assign</button>';

        $output['data'][] = array(
            $row['K_Id'],
            $row['K_Name'],
            $row['K_Phone'].'<br>'.$row['K_Email'],
            $row['K_Department'],             
            $status,           
            $actionButton
        );
        $i++;
    }

    $con->close();
 
    echo json_encode($output);

    }

    



    

?>