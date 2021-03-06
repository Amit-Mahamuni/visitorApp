<?php


require_once "../config.php";

if($_POST['action'] == "departmentList"){

    // $KSTATUS = $_POST["status"];
    // $CAT = $_POST["category"];


    $output = array('data' => array());

    $sql = "SELECT * FROM adhikari_department LEFT JOIN address_detail ON adhikari_department.ADD_Id = address_detail.ADD_Id WHERE adhikari_department.ADE_Department != ''";

    if(isset($_POST["department"]) && $_POST["department"] != "" && $_POST["department"] != 'All'){
      $DEP = $_POST['department'];
      $sql .= " AND `ADE_Department` = '$DEP'";
    }
    // if(isset($_POST["status"]) && $_POST["status"] != "" && $_POST["status"] != 'All'){
    //   $STATS = $_POST['status'];
    //   $sql .= " AND `AD_Status` = '$STATS'";
    // }

    $sql .= "ORDER BY `ADE_Id` DESC";

    $query = $con->query($sql);

    while($row = $query->fetch_assoc()){

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#update_department_Modal" onclick="editDepartment('.$row['ADE_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeDepartmentModal" onclick="rmoveDepartment('.$row['ADE_Id'].')">Rmove</button>';

        $output['data'][] = array(
            $row['ADE_Id'],
            $row['ADE_Department'],
            $row['ADE_Occupation'],
            $row['ADD_Address'].' - '.$row['ADD_Pincode'],
            $actionButton
        );

    }

    $con->close();

    echo json_encode($output);

}else if($_POST['action'] == "getAddressDetail"){
    $ADDTYPE = $_POST["address_type"];

    if($_POST["address_type"] != "")
    {
     $output = '<option value="0">Select</option>';
     $query = "SELECT `ADD_Id`, `ADD_Address` FROM `address_detail` WHERE `ADD_Type` = '$ADDTYPE' GROUP BY `ADD_Address` ORDER BY `ADD_Address` ASC";
     $result = $con->query($query);
     while($row = mysqli_fetch_array($result))
     {
      $output .= '<option value="'.$row["ADD_Id"].'">'.$row["ADD_Address"].'</option>';
     }
    }
    echo $output;

}else if($_POST['action'] == "addDepartment"){
    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];

    $ADEPDETAIL = $_POST['department_detail'];
    $AADDNAME = $_POST['address_name'];
    $ADEPARTMENT = $_POST['department_name'];

    $Msg = "Add New Adhikari Department ".$ADEPARTMENT;


    $SQL_INSERT = "INSERT INTO `adhikari_department`(`ADE_Department`, `ADD_Id`, `ADE_Detail`)
                    VALUES ('$ADEPARTMENT','$AADDNAME','$ADEPDETAIL');";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Add Adhikari Department";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to add data".$con->error;

    }
    $con->close();
    echo json_encode($validator);

}else if($_POST['action'] == "addOccupation"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];

    $ADEPDETAIL = $_POST['occupation_detail'];
    $AADDNAME = $_POST['address_name_occ'];
    $ADEPARTMENT = $_POST['department_occ'];
    $AOCCUPATION = $_POST['occupation_name'];

    $Msg = "Add New Adhikari Occupation ".$AOCCUPATION." In Department ".$ADEPARTMENT;


    $SQL_INSERT = "INSERT INTO `adhikari_department`(`ADE_Department`, `ADE_Occupation`, `ADD_Id`, `ADE_Detail`)
                    VALUES ('$ADEPARTMENT','$AOCCUPATION','$AADDNAME','$ADEPDETAIL');";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Add Adhikari Occupation";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to add data".$con->error;

    }
    $con->close();
    echo json_encode($validator);

}else if($_POST['action'] == "removeDepartment"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];
    $ADE_ID = $_POST['department_id'];


    $Msg = "Delete Adhikari Department of Id ".$ADE_ID;


    $SQL_INSERT = "DELETE FROM `adhikari_department` WHERE `ADE_Id` = '{$ADE_ID}';";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Delete Adhikari Department";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to Delete Adhikari Department".$con->error;

    }
    $con->close();
    echo json_encode($validator);

}else if($_POST['action'] == "updateDepartment"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];
    $ADE_ID = $_POST['department_up_id'];
    $ADEPDETAIL = $_POST['department_detail_up'];
    $AADDNAME = $_POST['address_name_up'];

    $Msg = "Update Adhikari Department of Id ".$ADE_ID;

    $SQL_INSERT = "UPDATE `adhikari_department` SET `ADD_Id` = '$AADDNAME', `ADE_Detail` = '$ADEPDETAIL' WHERE `ADE_Id` = '$ADE_ID';";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Update Adhikari Department";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to Update Adhikari Department".$con->error;

    }
    $con->close();

    echo json_encode($validator);

}else if($_POST['action'] == "getSingleDepartmentData"){
    // print_r($_POST);

    $ADE_Id = $_POST['Department_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM adhikari_department LEFT JOIN address_detail
        ON adhikari_department.ADD_Id = address_detail.ADD_Id WHERE adhikari_department.ADE_Id = $ADE_Id ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

}


?>
