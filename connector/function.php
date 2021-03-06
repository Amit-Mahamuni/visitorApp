<?php


require_once "config.php";

if($_POST['action'] == "connectorDetail"){

    $ID = $_POST['connector_Id'];

    $sql = "SELECT * FROM `connector_info` WHERE `CO_Visibility` = 'visible' AND `CO_Id` = '$ID'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

}else if($_POST['action'] == "adhikariWorkList"){

    $A_Id = $_POST['adhikari_Id'];

    $result = array();

    if(!empty($_POST['adhikari_Id'])){

        // $VID = $_POST['visitor_Id'];

        $sql = "SELECT * FROM `work_detail` WHERE `AD_Id` = '$A_Id' AND `Visibility` = 'visible'";

        $query = $con->query($sql);

        $total_work = $query->num_rows;

        if($query->num_rows > 0){

            // $workData = $query->fetch_assoc();

            $result['status'] = 'ok';
            $result['total'] = $total_work;

            // $i=1;
            while($row = mysqli_fetch_assoc($query) )
            {
                $result['workdata'][] = $row;
                // $result[] = $row;
                // $i++;
            }


        }else{

            $result['status'] = 'error'.$con->error;
            $result['total'] = $total_work;
            $result['workdata'] = 'Not Data Find at this ID - '.$VID;

        }

        echo json_encode($result);

    }else{

        $result['status'] = 'error';
        $result['workdata'] = 'No Id Pass';

        echo json_encode($result);
    }

    $con->close();


}else if($_POST['action'] == "getOccupationsDetail"){

    $DEPARTMENT = $_POST["adhikari_department"];

    $occupation = "<option value='' selected>Select</option>";

    $query_d = "SELECT `ADE_Occupation` FROM `adhikari_department` WHERE `ADE_Department` = '$DEPARTMENT'
                AND `ADE_Occupation` != '' GROUP BY `ADE_Occupation` ORDER BY `ADE_Occupation` ASC";

    $result_d = $con->query($query_d);

    while($row_d = mysqli_fetch_array($result_d))
    {
        $occupation .='<option value="'.$row_d["ADE_Occupation"].'">'.$row_d["ADE_Occupation"].'</option>';

    }

    echo $occupation;

}else if($_POST['action'] == "getOccputionList"){

    $output = array('data' => array());

    // `CN_Id`, `CN_Occupation_mr`, `CN_Occupation_en`, `ADD_Id`, `CN_Detail`

    $query = "SELECT * FROM `connector_occupation`";

    $result = $con->query($query);

    $i=1;

    while($row = $result->fetch_assoc()){

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" onclick="editOccupation('.$row['CN_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm"  onclick="rmoveOccupation('.$row['CN_Id'].')">Rmove</button>';

        $output['data'][] = array(
            $i,
            $row['CN_Occupation_mr']." <br /> ( ".$row['CN_Occupation_en']." )",
            $row['CN_Detail'],
            $actionButton
        );
        $i++;
    }

    $con->close();

    echo json_encode($output);

}else if($_POST['action'] == "getSingleOccupationData"){

  // print_r($_POST);

  $OID = $_POST["occupation_id"];

  $output = array('data' => array());

  $sql = "SELECT * FROM `connector_occupation` WHERE `CN_Id`='$OID' ";

  $query = $con->query($sql);

  $result = $query->fetch_assoc();

  $con->close();

  echo json_encode($result);

}else if($_POST['action'] == "addConnectorOccupation"){

//   print_r($_POST);
$validator = array('success' => false, 'messages' => array());

  $U_ID= $_POST['user_id'];

  $OCCMR = $_POST['Occupation_name_mr'];
  $OCCEN = $_POST['Occupation_name_en'];
  $OCCDETAIL = $_POST['Occupation_detail'];


  if($_POST['occupation_id'] != "" && isset($_POST['occupation_id'])){

    $OCCID = $_POST['occupation_id'];

    $sql = "UPDATE `connector_occupation` SET `CN_Occupation_mr`='$OCCMR',
            `CN_Occupation_en`='$OCCEN',`CN_Detail`='$OCCDETAIL' WHERE `CN_Id` = '$OCCID';";

    $msg = "Update the Occupation Detail of ".$OCCMR;

  }else{

    $sql = "INSERT INTO `connector_occupation`(`CN_Occupation_mr`, `CN_Occupation_en`, `CN_Detail`)
                VALUES ('$OCCMR','$OCCEN','$OCCDETAIL');";

    $msg = "Insert new the Occupation for Connector";

  }

    $sql .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
    VALUES ('{$U_ID}','{$msg}')";

    if($con->multi_query($sql)){

    $validator['success'] = true;
    $validator['messages'] = "Occupation Add and Update sucessful ";

    } else {
    $validator['success'] = false;
    $validator['messages'] = "Error to Add or Update Occupation ".$con->error;

    }

    $con->close();

    echo json_encode($validator);

}else if($_POST['action'] == "deleteConnectorOccupation"){

//   print_r($_POST);
    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];
    $OCCID = $_POST['occupation_id'];

    $sql = "DELETE FROM `connector_occupation` WHERE `CN_Id` = '$OCCID';";

    $msg = "Delete the Occupation for Connector with Occupation id ".$OCCID;

    $sql .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
    VALUES ('{$U_ID}','{$msg}')";

    if($con->multi_query($sql)){

    $validator['success'] = true;
    $validator['messages'] = "Data Delete sucessful ";

    } else {
    $validator['success'] = false;
    $validator['messages'] = "Error to Delete Occupation".$con->error;

    }

    $con->close();

    echo json_encode($validator);

}else if($_POST['action'] == "getAddressDetail"){

//   print_r($_POST);

    $result = array();

    $sql = "SELECT `ADD_Id`,`ADD_Pincode`,`ADD_Address` FROM `address_detail` WHERE `ADD_Address` != '' GROUP BY `ADD_Address` ORDER BY `ADD_Address` ASC";

    $query = $con->query($sql);

    while($row = mysqli_fetch_assoc($query) )
    {
        $result[] = $row;
        // $result[] = $row;
        // $i++;
    }

    $con->close();

    echo json_encode($result);

}




?>
