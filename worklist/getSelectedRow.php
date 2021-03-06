<?php

    require_once "config.php";

    $workId = $_POST['work_Id'];

    $output = array('data' => array());


    $sql = "SELECT work_detail.W_Id, work_detail.V_Id, work_detail.Work_title, work_detail.Priority, 
           work_detail.Work_Category, work_detail.Work_Subcategory, work_detail.Work_detail,
            work_detail.Work_add_date, work_detail.Work_end_date, work_detail.Status,visitor_info.V_Id, visitor_info.V_Name, 
            visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob, visitor_info.V_Gender 
            FROM work_detail INNER JOIN visitor_info on work_detail.V_Id = visitor_info.V_Id WHERE work_detail.W_Id = $workId";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();
 
    echo json_encode($result);

?>