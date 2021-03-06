<?php

    require_once "config.php";

    $result = array();

    if(!empty($_POST['visitor_Id'])){

        $VID = $_POST['visitor_Id'];

        $sql = "SELECT * FROM `work_detail` WHERE `V_Id` = '$VID' AND `Visibility` = 'visible'";

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
    

?>