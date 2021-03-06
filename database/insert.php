<?php

    include "config.php";

    $VNAME = $_POST["visitor_name"];
    $VPHONE = $_POST["visitor_phone"];
    $VEMAIL = $_POST["visitor_email"];
    $VGENDER = $_POST["visitor_gender"];
    $VDOB = $_POST["visitor_dob"];
    $VADDR = $_POST["visitor_address"];
    $VCITY = $_POST["visitor_city"];
    $VSTATE = $_POST["visitor_state"];
    $VPINCODE = $_POST["visitor_pincode"];
    $RNAME = $_POST["refernce_name"];
    $RPHONE = $_POST["refernce_phone"];
    

    $SQL = "INSERT INTO `visitor_info`(`Name`, `Phone`, `Email`, `Dob`,  `Gender`, `Address`, `City`, `State`, `Pincode`, `R_Name`, `R_Phone`) 
             VALUES ('{$VNAME}','{$VPHONE}','{$VEMAIL}','{$VDOB}','{$VGENDER}','{$VADDR}','{$VCITY}','{$VSTATE}','{$VPINCODE}','{$RNAME}','{$RPHONE}')";

    if($con->query($SQL))
    {
        $last_id = mysqli_insert_id($con);
        echo "Data Saved Successful ! with Id is ".$last_id;
    }

    
?>