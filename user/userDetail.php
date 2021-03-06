<?php

session_start();

if(!isset($_SESSION['U_Id']))
{
 header("location:../login/logout.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Detail</title>
    <link rel="stylesheet" href="../css/bootstrap.css">    	
</head>
<body class="bg-secondary">


<!-- navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Visitor |</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="../visitorDetail/visitorDetail.php">User Profile Detail</a>
            </li>    
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#"><?php echo $_SESSION['userName']; ?></a>
                    <a class="dropdown-item" href="../user/userDetail.php">Profile</a>
                    <a class="dropdown-item" href="../login/logout.php">Log Out</a>                       
                </div>
            </li>
        </ul>
        </div>
    </div>        
</nav>

    <div class="container bg-white my-4">

        <!-- user detail -->
        <div class="row border border-secondary p-3">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-6">                         
                        <h6><strong>User Detail</strong> </h6>         
                    </div> 
                    <div class="form-group col-md-3">  
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>" disabled>                       
                        <input type="text" class="form-control form-control-sm" id="user_department" name="user_department" placeholder="User Department" disabled>
                        <small id="user_department" class="form-text text-muted">User Department</small>
                    </div>          
                    <div class="form-group col-md-3">                          
                        <input type="text" class="form-control form-control-sm" id="user_status" name="user_status" placeholder="User Status" disabled>
                        <small id="user_status" class="form-text text-muted">User Status</small>
                    </div>              
                </div> 

                <div class="form-group col-md-4">                                   
                    <input type="hidden" class="form-control" id="user_id">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">                         
                        <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="User Name" disabled> 
                        <small id="user_name" class="form-text text-muted">Name</small>                    
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="text" class="form-control form-control-sm" id="user_detail" name="user_detail" placeholder="Gender | DOB" disabled>
                        <small id="user_detail" class="form-text text-muted">Details: Gender | Date Of Birth</small>                   
                    </div>                        
                </div> 

                <div class="form-row">
                    <div class="form-group col-md-4">                         
                        <input type="text" class="form-control form-control-sm" id="user_contact" name="user_contact" placeholder="Phone & Email" disabled>
                        <small id="user_contact" class="form-text text-muted">Contact Details</small>                                 
                    </div>
                    <div class="form-group col-md-8">                          
                        <input type="text" class="form-control form-control-sm" id="user_address" name="user_address" placeholder="Address, city, pincode" disabled>
                        <small id="user_address" class="form-text text-muted">Address | City | Pincode</small>                   
                    </div>                        
                </div> 

                <div class="form-row">                    
                    <div class="form-group col-md-6"> 
                        <input type="text" class="form-control form-control-sm" id="login_user_name"   name="login_user_name"  placeholder="User Name" disabled>                                                        
                        <small id="user_name" class="form-text text-muted">User Name </small>
                    </div>
                </div> 

            </div>

            <div class="col-md-3">
                <img src="../image/default_img.png" class="img-thumbnail rounded mx-auto d-block" id="user_profile" name="user_profile" >
            </div>
        </div> 
        
    </div>



    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>  
    <script src="userDetail.js"></script>     
</body>
</html>