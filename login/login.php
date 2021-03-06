<?php

include("config.php");

session_start();

if(isset($_SESSION['U_Id']))
{
 header('location:../addVisitor/addvisitor.html');
}

if(isset($_POST['login'])){

  $USERNAME = $_POST['userName'];
  $PASSWORD = $_POST['Password'];
  $DEPARTMENT = $_POST['user_department'];

  $sql = "SELECT * FROM `user_info` WHERE `U_Username` = '$USERNAME' AND `U_Password` = '$PASSWORD' AND `U_Department` = '$DEPARTMENT'";

  $query = $con->query($sql);

  // $row = $query->fetch_assoc();

  // $result = $query->num_rows;

  if($query->num_rows == 1)
  {

    while($row = $query->fetch_assoc())
    {        
      // echo "sucess".$row['U_Id'];

      $_SESSION['U_Id'] = $row['U_Id'];
      $_SESSION['userName'] = $row['U_Username'];

    }



    // $result = $statment->fetchAll();

    // foreach($result as $row)
    // {

    //   if(password_verify($_POST['Password'], $row['U_Password']))
    //   {

    //     $_SESSION['U_Id'] = $row['U_Id'];
    //     $_SESSION['userName'] = $row['U_Username'];

    //   }
    //   // else{

    //   //   $meassage = "<label>Wrong Password</label>";

    //   // }

    // }

  }
  else{

    echo "error".$USERNAME;

  }

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>    
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body class="bg-secondary">

    <div class="container my-5 ">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 border border-secondary p-5 bg-white">
                <h3>Login</h3>
                <hr>
                <form method="post" action="login.php">
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
                            <option value="Government">Government</option>
                            <option value="Personal">Personal</option>
                            <option value="Invitation">Invitation</option>
                            <option value="Job">Job</option>
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

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>     
</body>
</html>