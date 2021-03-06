<?php
require_once "config.php";

if($_POST['action'] == "todayWorkEntry"){

    $output_t_visitor = array('success' => false, 'total' => '');   

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                        -- AND `Work_Category`='Government' AND `Work_Subcategory`='Complaint'
                        AND  work_detail.Work_add_date > CURRENT_DATE";
    
    $query_t_visitor = $con->query($sql_t_visitor);

    $result = $query_t_visitor->num_rows;

    $con->close();        
    echo json_encode($result);
    
}



?>