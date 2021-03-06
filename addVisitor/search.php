<?php

require_once "config.php";

 if(isset($_POST["query"]))
 {
     $query_trim = trim($_POST["query"]);

     $output = '';
     $query = "SELECT V_Id, V_Name FROM visitor_info WHERE LOWER(V_Name) LIKE LOWER('%".$query_trim."%') AND visitor_info.V_Visibility = 'visible' LIMIT 5";

     $result = mysqli_query($con, $query);

    //   "SELECT `Voter_Id`, `Voter_name` FROM `voter_info` WHERE LOWER(`Voter_efirstname`)
    //   LIKE LOWER('%".$_POST["query"]."%') OR LOWER(`Voter_elastname`) LIKE LOWER('%".$_POST["query"]."%') OR `Voter_name`
    //   LIKE '%".$_POST["query"]."%' OR  LOWER(`Voter_cardno`) LIKE '%".$_POST["query"]."%' LIMIT 5"
     //  $query_voter = "SELECT `Voter_Id`, `Voter_name` FROM `voter_info` WHERE `Voter_name`
     //                    LIKE '%".$_POST["query"]."%' OR LOWER(`Voter_efirstname`)
     //                    LIKE LOWER('%".$_POST["query"]."%') OR LOWER(`Voter_elastname`)
     //                    LIKE LOWER('%".$_POST["query"]."%') LIMIT 5";
     // $query_voter = "SELECT `Voter_Id`, `Voter_name` FROM `voter_info` WHERE `Voter_name`
     //                LIKE '%".$query_trim."%' LIMIT 5";
     // $query_voter = "SELECT `Voter_Id`, `Voter_name` FROM `voter_info` WHERE `Voter_name`
     // CONTAINS(Voter_name,'$query_trim') LIMIT 5";
    //   $result_voter = mysqli_query($con, $query_voter);

      $output = '<ul class="class="list-group"">';

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $output .= '<li class="list-group-item list-group-item-sm d-flex justify-content-between align-items-center" onclick="selectVisitor('.$row['V_Id'].')">'.$row["V_Name"].'<span class="badge badge-primary badge-pill">'.$row["V_Id"].'</span></li>';
            }


        }

        $query_voter = "SELECT `Voter_Id`, `Voter_name` FROM `voter_info` WHERE `Voter_name`
        LIKE '%".$query_trim."%' LIMIT 5";

        $result_voter = mysqli_query($con, $query_voter);

        if(mysqli_num_rows($result_voter) > 0){

            while($row_voter = mysqli_fetch_array($result_voter))
            {
                $output .= '<li class="list-group-item list-group-item-sm d-flex justify-content-between align-items-center" onclick="selectVoter('.$row_voter['Voter_Id'].')">'.$row_voter["Voter_name"].'<span class="badge badge-info badge-pill">'.$row_voter["Voter_Id"].'</span></li>';
            }

        }

        $output .= '<li class="list-group-item d-flex justify-content-between align-items-center" id="clear_list" >Clear</li>';



      if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result_voter) == 0)
      {
          $output .= '<li class="list-group-item d-flex justify-content-between align-items-center" >Name Not Found</li>';
      }




      $output .= '</ul>';
      echo $output;

 }else if($_POST["action"] == "getVisitorData"){

    $VID = $_POST['VID'];

    $output = array('data' => array());

    $sql = "SELECT * FROM visitor_info WHERE visitor_info.V_Visibility = 'visible' AND visitor_info.V_Id = $VID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

 }else if($_POST["action"] == "getVoterData"){

    $VoerID = $_POST['VoterID'];

    $output = array('data' => array());


    $sql = "SELECT * FROM `voter_info` WHERE `Voter_Id`= $VoerID";

    $query = $con->query($sql);

    $result = $query->fetch_assoc();

    $con->close();

    echo json_encode($result);

 }

 ?>
