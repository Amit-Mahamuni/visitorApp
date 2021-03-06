<?php


require_once "config.php";

if($_POST['action'] == "adhikariDetail"){

    $AID = $_POST['adhikari_Id'];

    $sql = "SELECT * FROM `adhikari_info` WHERE `AD_Id` = '$AID' AND `AD_Visibility` = 'visible'";

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
