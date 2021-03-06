<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin" || $_SESSION['Department'] == "Letter")
{

}else {
    header("location:../login/logout.php");
}

?>
<!DOCTYPE html>
<html lang="mr">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Medical Letter Format</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Letter | </a>            
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../letter/dashboard.php">All Letter Fromat <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../worklist/workList.php">Work List </a>
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

    <div class="container">
        <div id="messages_ml"></div>
    </div>
    

    <form id="medical_letter_frm">
        <div class="container my-4">
            <div class="row">
                <div class="col-12">
                    <h6>Medical Letter Format</h6>
                    <div class=" d-flex justify-content-end">
                        <button type="submit" id="updateML" class="btn btn-primary btn-sm mr-4"  id="save_letter">Save</button>
                        <button class="btn btn-info btn-sm" id="print_letter">Print</button>
                    </div>            
                </div>
            </div>
        </div>

        <!-- letter layout -->
        <div class="container border border-dark my-5 p-5">
            <div class="row">
                <div class="col-12 px-1">
                    <div class="d-flex justify-content-between">
                        <h6>ID : <span id="work_id"></span></h6>
                        <h6>Date : 12/06/2020</h6>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                    </div>                 
                </div>
            </div> 
            <br>
    
                <div class="row">
                    <div class="col-12 px-1">
                        <div class="d-flex justify-content-between">
                            <textarea name="medicalletter_to" id="medicalletter_to" cols="30" rows="5"></textarea>                    
                        </div>                 
                    </div>
                </div>          
                
                <div class="row my-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <h6>विषय :  </h6>
                            <textarea name="medicalletter_subject" id="medicalletter_subject" cols="100%" rows="1"></textarea>                    
                        </div> 
                    </div>
                </div>

                <div class="row my-2">            
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <textarea name="medicalletter_detail" id="medicalletter_detail" cols="210" rows="10"></textarea>
                        </div>                
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 py-3">
                        <div class="d-flex justify-content-end">
                            <textarea name="medicalletter_sign" id="medicalletter_sign" cols="30" rows="5"></textarea>                    
                        </div>                 
                    </div>
                </div>             
        </div>

    </form>


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script> 
    <script src="medicalLetterFormat.js"></script>     
</body>
</html>