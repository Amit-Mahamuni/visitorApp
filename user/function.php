<?php

    require_once "config.php";

    if($_POST['action'] == "getSingleDetail"){

        $userId = $_POST['user_Id'];

        $output = array('data' => array());

        $sql = "SELECT * FROM `user_info` WHERE `U_Visibility`= 'visible' AND `U_Id` = $userId ";

        $query = $con->query($sql);

        $result = $query->fetch_assoc();

        $con->close();

        echo json_encode($result);

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
