<?php

    include "config.php";

    // print_r($_POST);

    $VTYPE = $_POST["visitor_type"];
    $VNAME = $_POST["visitor_name"];
    $VPHONE = $_POST["visitor_phone"];
    $VEMAIL = $_POST["visitor_email"];
    $VGENDER = $_POST["visitor_gender"];
    $VDOB = $_POST["visitor_dob"];
    $VADDR = $_POST["visitor_address"];
    $VCITY = $_POST["visitor_city"];  
    $VPINCODE = $_POST["visitor_pincode"];
    $RNAME = $_POST["refernce_name"];
    $RPHONE = $_POST["refernce_phone"];
    $VCAT = $_POST["visitor_category"];


    $WTITLE = $_POST["work_title"];
    $WPRIORITY = $_POST["work_priority"];
    $WCATE = $_POST["work_category"];
    $WSUBCAT = $_POST["work_subcategory"];
    $WDETAIL = $_POST["work_detail"];    
    $WSTATUS = "Pending";
    

    $SQL_VISITOR = "INSERT INTO `visitor_info`(`Name`, `Phone`, `Email`, `Dob`, `Gender`, `Address`, `City`, `Pincode`, `R_Name`, `R_Phone`, `V_Type`, `V_Category`) 
             VALUES ('{$VNAME}','{$VPHONE}','{$VEMAIL}','{$VDOB}','{$VGENDER}','{$VADDR}','{$VCITY}','{$VPINCODE}','{$RNAME}','{$RPHONE}','{$VTYPE}','{$VCAT}')";

    if($con->query($SQL_VISITOR))
    {
        $last_vid = mysqli_insert_id($con);
        // echo "Data Saved Successful ! with Id is ".$last_id;
        $SQL_WORK = "INSERT INTO `work_detail`(`V_Id`, `Work_title`, `Priority`, `Work_Category`, `Work_Subcategory`, `Work_detail`, `Status`) 
        VALUES ('{$last_vid}','{$WTITLE}','{$WPRIORITY}','{$WCATE}','{$WSUBCAT}','{$WDETAIL}','{$WSTATUS}')";

        if($con->query($SQL_WORK))
        {
            $last_wid = mysqli_insert_id($con);
            echo "Data Saved Successful ! with visitor id ". $last_vid ." Work Id ".$last_wid;

            if(isset($_POST["gvisitor_name"]) && $VCAT == "Group")
            {
                for($count = 0; $count < count($_POST["gvisitor_name"]); $count++)
                {          
                    $query = "INSERT INTO `group_visitor`(`Name`, `Phone`, `V_Id`, `W_Id`) VALUES (?,?,?,?)";
                    $statement = $con->prepare($query);
                    $statement->bind_param('ssss', $G_VISITOR_NAME, $G_VISITOR_PHONE, $G_VID, $G_WID);
                        $G_VISITOR_NAME  = $_POST["gvisitor_name"][$count];
                        $G_VISITOR_PHONE = $_POST["gvisitor_phone"][$count];  
                        $G_VID = $last_vid;  
                        $G_WID = $last_wid;                             
                    $result = $statement->execute();
                }
                $statement->close();
            }else{
                echo "Error in group: <br>" . $con->error;
            }

        }else {
            echo "Error: " . $SQL_WORK . "<br>" . $con->error;
        }

    }else{
        echo "Error: " . $SQL_VISITOR . "<br>" . $con->error;
    }    

    $con->close();

    
?>