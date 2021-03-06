<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin")
{

}else {
    header("location:../login/logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
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
                <a class="nav-link" href="../proposal/proposal.php">Add Proposal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../proposal/proposalList.php">Proposal List</a>
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

<div class="container p-4 bg-white my-2">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h5>Proposal Letter</h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end ">
                    <h6 class="alert alert-info" id="status_txt"></h6>
                </div>
            </div>

            <hr>
            <form id="proposal_frm">

                <div class="form-row">
                    <div class="form-group col-md-6">  
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">  
                        <input type="hidden" class="form-control form-control-sm" id="proposal_id" name="proposal_id">
                        <input type="hidden" class="form-control form-control-sm" id="proposal_status" name="proposal_status">
                        <input type="hidden" class="form-control form-control-sm" id="proposal_priority" name="proposal_priority">                     
                        <input type="text" class="form-control form-control-sm" id="proposal_name" name="proposal_name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">                          
                        <input type="text" class="form-control form-control-sm" id="proposal_phone" name="proposal_phone" minlength="10" maxlength="10" placeholder="Phone" >
                    </div> 
                </div> 
    
                <div class="form-row">
                    <div class="form-group col-md-6">    
                        <textarea class="form-control form-control-sm" id="proposal_to" name="proposal_to" placeholder="Proposal To" rows="2"></textarea>                     
                    </div> 
                </div> 
                
                <div class="form-row">
                    <div class="form-group col-md-12"> 
                        <textarea class="form-control form-control-sm" id="proposal_subject" name="proposal_subject" placeholder="Proposal Subject" rows="1"></textarea>                                                 
                    </div>
                </div>
                 
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control form-control-sm" id="proposal_detail" name="proposal_detail" placeholder="Proposal Detail" rows="3"></textarea>                         
                    </div>
                </div> 
    
                <!-- <div class="form-row p-2" id="group_row">
                    <span id="error"></span>
                    <table class="table table-sm table-bordered" id="group_table">
                        <thead>
                            <tr>
                                <th width="30%">Village/City</th>
                                <th width="20%">Problem</th>
                                <th width="15%">Solution</th>
                                <th width="15%">Fund require</th>
                                <th width="10%"><button type="button" name="add" class="btn btn-primary btn-sm add">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div> -->
    
                <div class="form-row">
                    <div class="form-group col-md-6 m-auto pr-5">  
                        <div class="row">
                            <div class="col-3">
                                <a href="#" target="_blank" rel="noopener noreferrer" id="doc_link">
                                    <img src="../image/default_document.png" id="doc_pre"  class="rounded mx-auto d-block m-4" width="50%" height="auto">
                                </a>
                            </div>
                            <div class="col-9">
                                <div class="form-group">                   
                                    <input type="file" id="doc_pre_file" class="m-2 pb-5 form-control" capture="camera" name="doc_pre_file" accept=".jpg, .jpeg, .png, .pdf">                       
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="form-group col-md-6">                          
                        <textarea class="form-control form-control-sm" id="proposal_note" name="proposal_note" placeholder="Proposal Note" rows="2"></textarea>                         
                    </div> 
                </div> 
    
                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-primary" id="add_proposal">Submit</button>
                        <button type="button" class="btn btn-sm btn-danger" id="cancle_proposal">Cancle</button>
                    </div>
                </div>

            </form>

            

    
 
        </div>
    </div>
</div>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script> 
    <script src="proposal.js"></script>
    
</body>
</html>