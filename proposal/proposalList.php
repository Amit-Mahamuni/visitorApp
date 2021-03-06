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
    <title>Proposal List</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.all.css"/>
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
            <li class="nav-item ">
                <a class="nav-link" href="../proposal/proposal.php">Add Proposal</a>
            </li>
            <li class="nav-item active">
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

<div class="container border bprder-secondary bg-white my-3 p-md-5">
    
    <div class="row">
        <div class="col-md-6 mb-2">
            <button type="button" class="btn btn-sm btn-primary">
                Notifications : Today Proposal <span  id="today_total_proposal" class="badge badge-light"></span>
            </button>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary my-auto"  data-toggle="modal" data-target="#exampleModal1">filter</button>
        </div>
    </div>

    <div class="row" id="complaint_div">
        <div class="col-md-12 bg-white">
            <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                <table id="proposal_datatable" class="table table-border table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="15%">Proposal To</th>
                            <th width="35%">Proposal Subject</th>
                            <th width="15%">Date</th>                                
                            <th width="10%">Status</th>                                
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div>
    </div>
    
</div>

 <!-- filter Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <form id="filter_frm" >
                <div class="modal-body px-4 py-2">                   
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <select id="proposal_priority_f" name="proposal_priority_f" class="form-control form-control-sm">  
                                <option selected>All</option>                               
                                <option >Low</option>
                                <option>Normal</option>
                                <option>High</option>
                            </select>
                            <small id="proposal_priority_f" class="form-text text-muted">Priority</small>                                 
                        </div>
                        <div class="form-group col-md-6">                                    
                            <select id="proposal_status_f" name="proposal_status_f" class="form-control form-control-sm">
                                <option selected>All</option> 
                                <option value="Pending">Pending</option>
                                <option value="Complete">Complete</option>
                                <option value="Under Process">Under Process</option>
                            </select>
                            <small id="proposal_status_f" class="form-text text-muted">Status</small>
                        </div>

                    </div>
                

                    <div class="form-row">
                        <div class="form-group col-md-6">  
                            <input type="date" class="form-control form-control-sm" id="proposal_date_from_f" name="proposal_date_from_f" > 
                            <small id="proposal_date_from_f" class="form-text text-muted">Date Form</small>                      
                        </div>
                        <div class="form-group col-md-6">                          
                            <input type="date" class="form-control form-control-sm" id="proposal_date_end_f" name="proposal_date_end_f"> 
                            <small id="proposal_date_end_f" class="form-text text-muted">Date End</small>       
                        </div>                        
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"  id="filter_fun" class="btn btn-sm btn-primary">Filter</button>
                    <button type="button"  id="clear_filter" class="btn btn-sm btn-danger">Clear</button>
                </div>
            </form>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ProposalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proposal Detail : <span id="proposal_id_txt"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="proposal_frm">

                <div class="modal-body p-4">       
                    <div id="messages"></div>
                    <div id="from_data">
                        <div class="form-row">
                            <div class="form-group col-md-8">    

                                <div class="form-row">
                                    <div class="form-group col-md-4">                     
                                        <input type="hidden" class="form-control form-control-sm" id="proposal_id" name="proposal_id"> 
                                        <select id="proposal_priority" name="proposal_priority" class="form-control form-control-sm">                                
                                            <option selected>Low</option>
                                            <option>Normal</option>
                                            <option>High</option>
                                        </select>
                                        <small id="proposal_priority" class="form-text text-muted">Proposal Priority</small>                         
                                    </div> 

                                    <div class="form-group col-md-4"> 
                                        <select id="proposal_status" name="proposal_status" class="form-control form-control-sm" required>                                
                                            <option value="Pending" selected>Pending</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Under Process">Under Process</option>
                                        </select> 
                                        <small id="proposal_status" class="form-text text-muted">Proposal Status</small>                                                
                                    </div>

                                    <div class="form-group col-md-4"> 
                                        <input type='text' class='form-control form-control-sm' id='proposal_add_date' name='proposal_add_date' disabled>
                                        <small id='proposal_add_date' class='form-text text-muted'>Proposal Add Date</small>                                                
                                    </div>
                                </div> 

                                <div class="form-group">                      
                                    <textarea class="form-control form-control-sm" id="proposal_to" name="proposal_to" placeholder="Proposal To" rows="1"></textarea>
                                    <small id='invitation_title' class='form-text text-muted'>Proposal To</small>                  
                                </div> 

                                <div class="form-group">                      
                                    <textarea class="form-control form-control-sm" id="proposal_subject" name="proposal_subject" placeholder="Proposal Subject" rows="1"></textarea> 
                                    <small id='invitation_title' class='form-text text-muted'>Proposal Subject</small>                  
                                </div> 

                                <div class="form-group">                      
                                    <textarea class="form-control form-control-sm" id="proposal_detail" name="proposal_detail" placeholder="Proposal Detail" rows="2"></textarea>
                                    <small id='invitation_title' class='form-text text-muted'>Proposal Detail</small>                  
                                </div> 

                                <!-- <div class="form-group">                      
                                    <textarea class="form-control form-control-sm" id="proposal_end" name="proposal_end" placeholder="Proposal End" rows="1"></textarea>
                                    <small id='invitation_title' class='form-text text-muted'>Proposal End</small>                  
                                </div>  -->

                                <div class="form-group">                      
                                    <textarea class="form-control form-control-sm" id="proposal_note" name="proposal_note" placeholder="Proposal Note" rows="1"></textarea>                         
                                    <small id='invitation_title' class='form-text text-muted'>Proposal Note</small>                  
                                </div> 

                                <div class="form-row">
                                    <div class="form-group col-md-6">                         
                                        <input type="text" class="form-control form-control-sm" id="proposal_name" name="proposal_name" placeholder="Name">
                                        <small id='invitation_date' class='form-text text-muted'>Name</small>                                
                                    </div>
                                    <div class="form-group col-md-6">                          
                                        <input type="text" class="form-control form-control-sm" id="proposal_phone" name="proposal_phone" minlength="10" maxlength="10" placeholder="Phone" >
                                        <small id='invitation_time' class='form-text text-muted'>Phone</small>
                                    </div>                        
                                </div> 

                            </div>
                            <div class="form-group col-md-4">   
                                <div class="form-group d-flex justify-content-end">                   
                                    <button type="button" id="create_letter" onclick="createLetter()" class="btn btn-sm btn-primary">Create Letter</button>
                                </div>

                                <img src="../image/default_img.png" id="doc_pre" class="img-thumbnail m-2">
                                <div class="form-group">                   
                                    <input type="file" id="doc_pre_file" name="doc_pre_file" class=" m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                </div>

                            </div>                        
                        </div>  

                    </div>                                           
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="updateBtn" class="btn btn-sm btn-primary">Update changes</button>
                    <button type="button" id="removeBtn" class="btn btn-sm btn-danger">Remove</button>
                </div>
        </form>
    </div>
    </div>
</div>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script> 
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="proposalList.js"></script>
    
</body>
</html>