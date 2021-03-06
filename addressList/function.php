<?php


require_once "config.php";

if($_POST['action'] == "addressList"){

    $output = array('data' => array());

    $sql = "SELECT * FROM `address_detail` WHERE `ADD_Address` != '' ";

    if(isset($_POST["Goverment"]) && $_POST["Goverment"] != "" && $_POST["Goverment"] != 'All'){
        $GOV = $_POST["Goverment"];
        $sql .= " AND `ADD_Gov` = '$GOV'";
    }

    if(isset($_POST["Type"]) && $_POST["Type"] != "" && $_POST["Type"] != 'All'){
        $type = $_POST["Type"];
        $sql .= " AND `ADD_Type` = '$type'";
    }

    $sql .= " GROUP BY `ADD_Address` ORDER BY `ADD_Address` ASC";

    // `ADD_Id`, `ADD_Type`, `ADD_Pincode`, `ADD_Detail`, `ADD_Address`

    $query = $con->query($sql);

    $i =1;
    while($row = $query->fetch_assoc()){

        $actionButton = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="editAddress('.$row['ADD_Id'].')">Edit</button>
                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#removeModal" onclick="rmoveAddress('.$row['ADD_Id'].')">Rmove</button>';

        $output['data'][] = array(
            $i,
            '<strong>'.$row['ADD_Address'].'</strong>',
            $row['ADD_Pincode'],
            $row['ADD_Type'],
            $row['ADD_Gov'],
            $row['ADD_Detail'],
            $actionButton
        );

        $i++;

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

}else if($_POST['action'] == "addAddress"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];

    $ADDRESS = $_POST['address'];
    $TYPE = $_POST['address_type'];
    $PINCODE = $_POST['address_pincode'];
    $GOV = $_POST['address_gov'];
    $DETAIL = $_POST['address_detail'];

    $Msg = "Add New Address ".$ADDRESS." - ".$PINCODE;


    $SQL_INSERT = "INSERT INTO `address_detail`(`ADD_Type`, `ADD_Pincode`, `ADD_Detail`, `ADD_Address`, `ADD_Gov`)
                  VALUES ('$TYPE','$PINCODE','$DETAIL','$ADDRESS','$GOV');";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Add Address";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to add Address".$con->error;

    }
    $con->close();
    echo json_encode($validator);

}else if($_POST['action'] == "removeAddress"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];
    $ADD_ID = $_POST['Address_Id'];


    $Msg = "Delete Address of Id ".$ADD_ID;


    $SQL_INSERT = "DELETE FROM `address_detail` WHERE `ADD_Id` = '{$ADD_ID}';";

    $SQL_INSERT .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_INSERT))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Delete Address";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to Delete Address".$con->error;

    }
    $con->close();
    echo json_encode($validator);

}else if($_POST['action'] == "updateAddress"){

    // print_r($_POST);

    $validator = array('success' => false, 'messages' => array());

    $U_ID= $_POST['user_id'];
    $ADD_ID = $_POST['address_Id_up'];
    $ADDRESS = $_POST['address_up'];
    $TYPE = $_POST['address_type_up'];
    $PINCODE = $_POST['address_pincode_up'];
    $DETAIL = $_POST['address_detail_up'];

    $Msg = "Update Address ".$ADDRESS." with Id ".$ADD_ID;

    $SQL_UPDATE = "UPDATE `address_detail` SET `ADD_Type`='$TYPE',`ADD_Pincode`='$PINCODE',
                  `ADD_Detail`='$DETAIL',`ADD_Address`='$ADDRESS' WHERE `ADD_Id` = '$ADD_ID';";

    $SQL_UPDATE .= "INSERT INTO `user_log_detail`(`U_Id`, `UL_Msg`)
                    VALUES ('{$U_ID}','{$Msg}')";

    // $query = $con->query($SQL_INSERT);

    if($con->multi_query($SQL_UPDATE))
    {
        $validator['success'] = true;
        $validator['messages'] = "Successfully Update Address";

    }
    else{
        $validator['success'] = false;
        $validator['messages'] = "Error to Update Address ".$con->error;

    }
    $con->close();

    echo json_encode($validator);

}else if($_POST['action'] == "getSingleAddressData"){
    // print_r($_POST);

    $ADD_Id = $_POST['Address_Id'];

    $output = array('data' => array());

    $sql = "SELECT * FROM `address_detail` WHERE `ADD_Id` = $ADD_Id ";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

}


?>
