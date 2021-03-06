<?php

require_once "config.php";

if($_POST['action'] == "getVisitorData"){

  if(isset($_POST)){

      $VID = $_POST['V_ID'];
      $WID = $_POST['W_ID'];

      $output = array('data' => array());

      $sql = "SELECT visitor_info.V_Name, visitor_info.V_Phone, visitor_info.V_Email, visitor_info.V_Dob,
                      visitor_info.V_Gender, visitor_info.V_Address, visitor_info.V_City, visitor_info.V_Pincode,
                      visitor_info.Visitor_Profile, work_detail.W_Id, work_detail.Work_title, work_detail.Work_Category,
                      work_detail.Work_Subcategory,
                      work_detail.Work_detail, work_detail.Work_add_date, work_detail.W_LType
              FROM visitor_info INNER JOIN work_detail ON visitor_info.V_Id = work_detail.V_Id
              WHERE visitor_info.V_Id = $VID  AND work_detail.W_Id = $WID AND work_detail.V_Id = $VID ";

      $query = $con->query($sql);

      $result = $query->fetch_assoc();

      $con->close();

      echo json_encode($result);

  }

}else if ($_POST['action'] == "getAddressDetail") {
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

}else if ($_POST['action'] == "getWorkData") {
  //   print_r($_POST);

  $WID = $_POST['WID'];

  $result = array();

  // $output = array('data' => array());

  $sql = "SELECT * FROM work_detail INNER JOIN visitor_info on work_detail.V_Id = visitor_info.V_Id WHERE work_detail.W_Id = '$WID'";

  $query = $con->query($sql);

  if ($query->num_rows > 0) {

    while($row = mysqli_fetch_assoc($query) )
    {
      $Refrence = $row['R_Id'];
      $SUBCAT = $row['Work_Subcategory'];
      $CAT = $row['Work_Category'];
      $LETTER_TYPE = $row['W_LType'];
      $result['workdata'] = $row;

    }

    if ($Refrence != 0) {
      $sql_ref = "SELECT * FROM `reference_detail` WHERE `W_Id` = '$WID'";
      $query_ref = $con->query($sql_ref);
      $result['refernce'] = $query_ref->fetch_assoc();
    }

    switch ($CAT) {
      case 'Personal':
              switch ($SUBCAT) {
                case 'Education':
                    $sql_education = "SELECT * FROM `education_info` WHERE `W_Id` = '$WID'";
                    $query_edu = $con->query($sql_education);
                    $result['Education'] = $query_edu->fetch_assoc();
                  break;

                case 'Medical Letter':
                    $sql_med = "SELECT `ML_Id`, `W_Id`, `V_Id`, `ML_Hospital`, `ML_Ward`, `ML_Bed`,
                                `ML_Disease`, `ML_Admit_Date`, `ML_PName`, `ML_PDob`, `ML_PGender`,
                                 `ML_PRelation`, `ML_Visibility` FROM `medical_letter`
                                 WHERE `W_Id` = '$WID'";
                    $query_med = $con->query($sql_med);
                    $result['Medical'] = $query_med->fetch_assoc();
                  break;

              }
        break;

      case 'Job':
          $sql_job = "SELECT `J_Id`, `J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`, `J_Qualification`,
                      `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`
                      FROM `job_info` WHERE `W_Id` = '$WID'";
          $query_job = $con->query($sql_job);
          $result['Job'] = $query_job->fetch_assoc();
        break;

      case 'Invitation':
          $sql_inv = "SELECT * FROM `invitation` WHERE `W_Id` = '$WID'";
          $query_inv = $con->query($sql_inv);
          $result['Invitation'] = $query_inv->fetch_assoc();
        break;

    case 'Government':
          if ($SUBCAT == 'Letter') {
            switch ($LETTER_TYPE) {
              case 'Ration Card':
                  $sql_ratcard = "SELECT `RC_Id`, `RC_TM`, `RC_TW`, `RC_TY`, `V_Id`, `W_Id` FROM `ration_card_letter` WHERE `W_Id` = '$WID'";
                  $query_ratcard = $con->query($sql_ratcard);
                  $result['Ration_Card'] = $query_ratcard->fetch_assoc();
                break;

            case 'Identity card':
                $sql_icard = "SELECT `ID_Id`, `ID_TYear`, `V_Id`, `W_Id` FROM `identitycard_letter` WHERE `W_Id` = '$WID'";
                $query_icard = $con->query($sql_icard);
                $result['Identity_card'] = $query_icard->fetch_assoc();
              break;

            case 'Residential Certificate':
                $sql_rescer = "SELECT `RL_Id`, `RL_For`, `RL_TYear`, `V_Id`, `W_Id` FROM `residential_letter` WHERE `W_Id` = '$WID'";
                $query_rescer = $con->query($sql_rescer);
                $result['Residential_Certificate'] = $query_rescer->fetch_assoc();
              break;

          case 'Other Letter':
              $sql_Custl = "SELECT `CL_Id`, `V_Id`, `W_Id` FROM `custom_letter` WHERE `W_Id` = '$WID'";
              $query_Custl = $con->query($sql_Custl);
              $result['Other_Letter'] = $query_Custl->fetch_assoc();
            break;

            }
          }
      break;

    }




  }

  // $result = $query->fetch_assoc();
  //
  // while ($row = mysqli_fetch_assoc($query) {
  //   $result[] = $row;
  // }

  $con->close();

  echo json_encode($result);

}




?>
