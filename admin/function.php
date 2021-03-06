<?php

require_once "config.php";

if($_POST['action'] == "totalWorkDetail")
{   
    $output = array();

    $sql = "SELECT `W_Id`, `Work_Category`, `Work_add_date`, `Status` FROM `work_detail` WHERE Visibility = 'visible'";

    if(isset($_POST["dateform"]) && $_POST["dateform"] != "" && isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $DATEFROM = $_POST["dateform"];
        $DATEEND = $_POST["dateend"];

        $sql .= " AND work_detail.Work_add_date BETWEEN '$DATEFROM' AND '$DATEEND'";
        
    }else if(isset($_POST["dateform"]) && $_POST["dateform"] != "" || isset($_POST["dateend"]) && $_POST["dateend"] != ""){

        $DATEFROM = $_POST["dateform"];
        $DATEEND = $_POST["dateend"];
    
        if(isset($_POST["dateform"]) && $_POST["dateform"] != ""){
    
            $sql .= " AND work_detail.Work_add_date > '$DATEFROM'";
    
        }else if(isset($_POST["dateend"]) && $_POST["dateend"] != ""){
    
            $sql .= " AND work_detail.Work_add_date < '$DATEEND'";
            
        }
    
    }

    $query = $con->query($sql);

    // $result = $query->fetch_assoc();

    while($row = $query->fetch_assoc()){

        $output[] = $row;
            
        
    }

    $con->close();
 
    echo json_encode($output);

}else if($_POST['action'] == "totalVisitorDetail"){   
    $output = array();

    $sql = "SELECT visitor_info.V_Id, visitor_info.V_Voter, work_detail.Work_add_date 
            FROM visitor_info INNER JOIN work_detail ON visitor_info.V_Id = work_detail.V_Id 
            WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' ";

    $query = $con->query($sql);

    // $result = $query->fetch_assoc();

    while($row = $query->fetch_assoc()){

        $output[] = $row;
            
        
    }

    $con->close();
 
    echo json_encode($output);

}else if($_POST['action'] == "totalVisitor"){   
    $output_t_visitor = array('success' => false, 'total' => '');   

    $sql_t_visitor =  "SELECT visitor_info.V_Id, work_detail.Work_add_date 
                        FROM visitor_info INNER JOIN  work_detail ON visitor_info.V_Id = work_detail.V_Id 
                        WHERE visitor_info.V_Visibility = 'visible' AND work_detail.Visibility = 'visible' 
                        AND  work_detail.Work_add_date > CURRENT_DATE";
    
    $query_t_visitor = $con->query($sql_t_visitor);

    $result = $query_t_visitor->num_rows;

    $con->close(); 

    echo json_encode($result);

}else if($_POST['action'] == "getUserLog"){

    $sql_uld = "SELECT user_info.U_Name, user_log_detail.UL_Msg, user_log_detail.UL_Date, user_log_detail.W_Id 
                FROM user_log_detail INNER JOIN user_info ON user_log_detail.U_Id = user_info.U_Id
                WHERE user_log_detail.UL_Date > CURRENT_DATE ORDER BY user_log_detail.UL_Id DESC";

    $query = $con->query($sql_uld);
    
    while($row = $query->fetch_assoc()){

        $output['data'][] = array(
            $row['U_Name'],
            $row['UL_Msg']." for Work-Id is ".$row['W_Id'],
            $row['UL_Date'] 
        );        
    }

    $con->close();
 
    echo json_encode($output);

}


?>