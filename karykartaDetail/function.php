<?php


require_once "config.php";

if($_POST['action'] == "karykartaDetail"){

    $karykartaId = $_POST['karykarta_Id'];   

    $sql = "SELECT * FROM `karykarta` WHERE `K_Id` = $karykartaId AND `K_Visibility` = 'visible'";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

}else if($_POST['action'] == "karykartaWorkList"){

    $karykartaId = $_POST['karykarta_Id'];

    $result = array();

    if(!empty($_POST['karykarta_Id'])){

        // $VID = $_POST['visitor_Id'];

        $sql = "SELECT * FROM `work_detail` WHERE `K_Id` = '$karykartaId' AND `Visibility` = 'visible'";

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


}else if($_POST['action'] == "karykartaWorkList"){
    
}




?>