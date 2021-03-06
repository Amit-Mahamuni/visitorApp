<?php

include("login/config.php");

$message = '';

session_start(); 

if(isset($_SESSION['U_Id']) && isset($_SESSION['Department']))
{

//  header('location:addVisitor/addvisitor.php');

departmentLink($_SESSION['Department']);

}

if(isset($_POST['login'])){

  $USERNAME = $_POST['userName'];
  $PASSWORD = $_POST['Password'];
  $DEPARTMENT = $_POST['user_department'];

  if($_POST['user_department'] != "Karykarta"){

    $sql = "SELECT * FROM `user_info` WHERE `U_Username` = '$USERNAME' AND `U_Password` = '$PASSWORD' AND `U_Department` = '$DEPARTMENT'";

  }else if($_POST['user_department'] == "Karykarta"){

    $sql = "SELECT * FROM `karykarta` WHERE `U_Username` = '$USERNAME' AND `U_Password` = '$PASSWORD' AND `K_Visibility` = 'visible'";

  }

  // $sql = "SELECT * FROM `user_info` WHERE `U_Username` = '$USERNAME' AND `U_Password` = '$PASSWORD' AND `U_Department` = '$DEPARTMENT'";

  $query = $con->query($sql);

  if($query->num_rows == 1)
  {

    while($row = $query->fetch_assoc())
    {    
      
      if($_POST['user_department'] != "Karykarta"){

        $_SESSION['U_Id'] = $row['U_Id'];
        $_SESSION['userName'] = $row['U_Username'];
        $_SESSION['Department'] = $row['U_Department'];
  
        departmentLink($row['U_Department']);

      }else{

        $_SESSION['U_Id'] = $row['K_Id'];
        $_SESSION['userName'] = $row['K_Name'];
        $_SESSION['Department'] = 'Karykarta';
  
        departmentLink('Karykarta');

      }         

    }

  }
  else{

    $message = "Wrong UserName Or Password";

  }

}

function departmentLink($department){

    switch($department){
        case "Reception":
          header('location:addVisitor/addvisitor.php');
        break;

        case "Government":
          header('location:government/government.php');
        break;

        case "Personal":
          header('location:education/education.php');
        break;

        case "Invitation":
          header('location:invitation/invitation.php');
        break;

        case "Job":
          header('location:job/job.php');
        break;

        case "Admin":
            header('location:admin/admindashboard.php');
        break;

        case "Letter":
          header('location:letter/dashboard.php');
        break;

        case "Karykarta":
          header('location:karykartaDetail/karykartaDetail.php');
        break;
    }
    
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>    
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body class="bg-secondary">

    <div class="container my-5 ">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 border border-secondary p-5 bg-white">
                <h3>Login</h3>
                <hr>
                
                <form method="post" action="index.php">
                     <p class="text-danger"><?php echo $message; ?></p>
                    <div class="form-group ">
                      <label for="exampleInputEmail1">User ID </label>
                      <input type="text" class="form-control form-control-sm" id="userName" name="userName">
                      <small id="userName" class="form-text text-muted">Enter Your User Id</small>
                    </div>
                    <div class="form-group form-group-sm">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control form-control-sm" id="Password" name="Password">
                      <small id="Password" class="form-text text-muted">Enter Your Password</small>
                    </div>
                    <div class="form-group ">
                        <select id="user_department" name="user_department" class="form-control form-control-sm"> 
                            <option value="Admin">Admin</option>
                            <option value="Reception">Reception</option>
                            <option value="Karykarta">Karykarta</option>
                            <option value="Letter">Letter</option>                          
                            <option value="Government">Department - Government</option>
                            <option value="Personal">Department - Personal</option>
                            <option value="Invitation">Department - Invitation</option>
                            <option value="Job">Department - Job</option>
                        </select>
                        <small id="user_department" class="form-text text-muted">User Department</small>
                    </div>

                    <button type="submit" name="login" class="btn btn-sm btn-primary">Log In</button>
                  </form>
                  <hr>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>     
</body>
</html>