<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin" || $_SESSION['Department'] == "Letter")
{

}else {
    header("location:../../login/logout.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                <a class="nav-link" href="../letter/dashboard.php">DashBoard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../worklist/workList.php">All Work List</a>
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

    <div class="container bg-white border border-secondary my-5">
        <div class="row">
            <div class="col-12 p-4">
                <h5>All Letter List</h5>
                <hr>
                <div class="row">
                    <div class="col-md-3 m-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">Format Of Letter - Help In Medical Bill</h5>
                              <h6 class="card-subtitle mb-2 text-muted"></h6>
                              <p class="card-text">Get discount in Medical bill</p>
                              <a href="../MedicalLetter/medicalLetterFormat.php" target="_blank" rel="noopener noreferrer" class="card-link btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 m-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">Format Of Letter - Job Letter</h5>
                              <h6 class="card-subtitle mb-2 text-muted"></h6>
                              <p class="card-text">Provide Letter for Job Seeker</p>
                              
                              <a href="../job/jobLetterFormat.php" target="_blank" rel="noopener noreferrer" class="card-link btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 m-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">Format Of Letter - Ration Card</h5>
                              <h6 class="card-subtitle mb-2 text-muted"></h6>
                              <p class="card-text">Provide Letter for Ration Card Change or New Create</p>
                              <a href="../letter/rationCard/rationCardFormat.php" target="_blank" rel="noopener noreferrer" class="card-link btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 m-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">Format Of Letter - Identity Card</h5>
                              <h6 class="card-subtitle mb-2 text-muted"></h6>
                              <p class="card-text">Provide Letter for Identity Card</p>
                              <a href="../letter/identityCard/identityCardFormat.php" target="_blank" rel="noopener noreferrer" class="card-link btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 m-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title">Format Of Letter - Residential Letter</h5>
                              <h6 class="card-subtitle mb-2 text-muted"></h6>
                              <p class="card-text">Provide Letter for Residential</p>
                              <a href="../letter/residentialLetter/residentialLetterFormat.php" target="_blank" rel="noopener noreferrer" class="card-link btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>  
    
</body>
</html>