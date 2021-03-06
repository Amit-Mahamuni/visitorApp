<?php

include "config.php";

    if(isset($_POST["gvisitor_name"]))
    {
        // $validator = array('success' => false, 'messages' => array());
        // $connect = new PDO("mysql:host=localhost;dbname=visit", "root", "");
        // // $order_id = uniqid();
        for($count = 0; $count < count($_POST["gvisitor_name"]); $count++)
        {  
            // INSERT INTO `group_visitor`(`Id`, `Name`, `Phone`) VALUES ([value-1],[value-2],[value-3])
            // $query = "INSERT INTO group_visitor ( Name, Phone ) VALUES (:gvisitor_name, :gvisitor_phone)";
            $query = "INSERT INTO `group_visitor`(`Name`, `Phone`) VALUES (?,?)";

            $statement = $con->prepare($query);
            $statement->bind_param('ss', $G_VISITOR_NAME, $G_VISITOR_PHONE);
            // array(
                // ':order_id'   => $order_id,
                // ':gvisitor_name'  => $_POST["gvisitor_name"][$count], 
                // ':gvisitor_phone' => $_POST["gvisitor_phone"][$count], 
                $G_VISITOR_NAME  = $_POST["gvisitor_name"][$count];
                $G_VISITOR_PHONE = $_POST["gvisitor_phone"][$count];                                     
                
            // );
            $result = $statement->execute();
        }
        // $result = $statement->fetch_assoc();
        // if(isset($result))
        // {
        //     echo 'ok';
        // }else{
        //     echo 'php error'.$con->error();
        // }

        $statement->close();

        // if(isset($result))
        // {
        //     echo 'ok';
        //     // $validator['success'] = true;
        //     // $validator['messages'] = "data added sucessful";
        // }else{
        //     echo 'php error'.$con->error();
        //     // $validator['success'] = false;
        //     // $validator['messages'] = "Error to add data".$con->error;
        // }
    }


    $con->close();
    // echo json_encode($validator);

?>