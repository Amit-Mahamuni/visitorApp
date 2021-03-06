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
    <title>Identity Card Letter</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    
</head>
<body>

    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="../../letter/dashboard.html">Letter | </a>            
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../../letter/dashboard.php">All Letter Fromat <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../worklist/workList.php">Work List </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#"><?php echo $_SESSION['userName']; ?></a>
                        <a class="dropdown-item" href="../../user/userDetail.php">Profile</a>
                        <a class="dropdown-item" href="../../login/logout.php">Log Out</a>                      
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </nav> 

    <div class="container">
        <div id="messages_ml"></div>
    </div>
    

    <form id="identity_letter_frm">
        <div class="container my-4">
            <div class="row">
                <div class="col-md-6">
                    <h6>Identity Card Letter Format</h6>
                </div>
                <div class="col-md-6">
                    <div class=" d-flex justify-content-end">
                        <button type="submit" id="updateJL" class="btn btn-primary btn-sm mr-4"  id="save_letter">Save</button>
                        <button class="btn btn-info btn-sm" id="print_letter">Print</button>
                    </div> 
                </div>    
            </div>
        </div>

        <!-- letter layout -->
        <div class="container border border-dark my-5 p-5" >
            <div class="row">
                <div class="col-12 px-1">
                    <div class="d-flex justify-content-between">
                        <h6>ID : <span id="work_id"></span></h6>
                        <h6>Date :</h6>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                    </div>                 
                </div>
            </div> 
            <br>
    
                <div class="row my-4">
                    <div class="col-12 px-1">
                        <div class="d-flex justify-content-center">
                            <textarea name="identityL_to" id="identityL_to" cols="30" rows="1"></textarea>                    
                        </div>                 
                    </div>
                </div>          
                <br><br><br>
                <div class="row my-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <textarea name="identitycardL_subject" id="identitycardL_subject" cols="100%" rows="1"></textarea>                    
                        </div> 
                    </div>
                </div>

                <div class="row my-2">            
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <textarea name="identitycardL_detail" id="identitycardL_detail" cols="210" rows="10"></textarea>
                        </div>                
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 py-3">
                        <div class="d-flex justify-content-end">
                            <textarea name="identitycardL_sign" id="identitycardL_sign" cols="30" rows="5"></textarea>                    
                        </div>                 
                    </div>
                </div>             
        </div>

    </form>



    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>    
    <script src="identityCardFormat.js"></script>

    
</body>
</html>