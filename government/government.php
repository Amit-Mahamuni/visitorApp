<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Government" || $_SESSION['Department'] == "Admin")
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
    <title>Government</title>
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
            <li class="nav-item active ">
                <a class="nav-link" href="../government/government.html">Government</a>
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
                Notifications : Today Work <span  id="today_total_work" class="badge badge-light"></span>
            </button>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary my-auto"  data-toggle="modal" data-target="#exampleModal1">filter</button>
        </div>
    </div>

    <div class="row" id="complaint_div">
        <div class="col-md-12 bg-white">
            <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                <table id="government_datatable" class="table table-border table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="35%">Work</th>
                            <th width="15%">Category</th>
                            <th width="15%">Add Date</th>                                
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
                            <select id="work_priority_f" name="work_priority_f" class="form-control form-control-sm"> 
                                <option selected>All</option>                               
                                <option >Low</option>
                                <option>Normal</option>
                                <option>High</option>
                            </select>
                            <small id="work_priority_f" class="form-text text-muted">Work Priority</small>                                 
                        </div>
                        <div class="form-group col-md-6">                                    
                            <select id="work_status_f" name="work_status_f" class="form-control form-control-sm">
                                <option selected>All</option>
                                <option value="Pending">Pending</option>
                                <option value="Complete">Complete</option>
                                <option value="Under Process">Under Process</option>
                            </select>
                            <small id="work_status_f" class="form-text text-muted">Work Status</small>
                        </div>

                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">  
                            <select id="work_subcat_f" name="work_subcat_f" class="form-control form-control-sm">                           
                                <option selected>All</option>
                                <option>Complaint</option>
                                <option>Letter</option>
                            </select>
                            <small id="work_subcat_f" class="form-text text-muted">Category</small>                      
                        </div>                   
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">  
                            <input type="date" class="form-control form-control-sm" id="work_date_from_f" name="work_date_from_f" > 
                            <small id="work_date_from_f" class="form-text text-muted">Work Date Form</small>                      
                        </div>
                        <div class="form-group col-md-6">                          
                            <input type="date" class="form-control form-control-sm" id="work_date_end_f" name="work_date_end_f"> 
                            <small id="work_date_end_f" class="form-text text-muted">Work Date End</small>       
                        </div>                        
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Save changes</button> -->
                    <button type="button"  id="filter_fun" class="btn btn-sm btn-primary">Filter</button>
                    <button type="button"  id="clear_filter" class="btn btn-sm btn-danger">Clear</button>
                </div>
            </form>
      </div>
    </div>
  </div>

 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Work Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="work_frm" >
                <div class="modal-body px-4 py-2">
                    <div id="messages"></div>

                    <div id="work_update_div">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <h6 id="work_id_txt"></h6>                                   
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                <input type="hidden" class="form-control" name= "work_id" id="work_id" >
                            </div>
                            <div class="form-group col-md-4">                                   
                                <input type="hidden" class="form-control" id="work_complete_date" >
                            </div>
                            <div class="form-group col-md-4">                                    
                                <select id="work_status" name="work_status" class="form-control form-control-sm">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Complete">Complete</option>
                                    <option value="Under Process">Under Process</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">                         
                            <input type="text" class="form-control form-control-sm" id="work_title" name="work_title" placeholder="Work Title" > 
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">  
                                <select id="work_category" name="work_category" class="form-control form-control-sm">                           
                                    <option selected>Government</option>
                                    <option>Personal</option>
                                    <option>Invitation</option>
                                    <option>Job</option>
                                    <option>Other</option>
                                    </select>
                                <small id="work_category" class="form-text text-muted">Category</small>                      
                            </div>
                            <div class="form-group col-md-6">     
                                <select id="work_subcat" name="work_subcat" class="form-control form-control-sm">                           
                                    <option  value='Complaint' selected>Complaint</option>
                                    <option  value='Letter'>Letter</option>
                                    <option  value='Medical Letter'>Medical Letter</option>
                                    <option  value='Wedding'>Wedding</option>
                                    <option  value='Opening'>Opening</option>
                                    <option  value='Education'>Education</option>
                                    <option  value='Vacany'>Vacany</option>
                                    <option  value='Job Letter'>Job Letter</option>
                                    <option  value='Other'>Other</option>                                   
                                    </select>
                                <small id="work_subcat" class="form-text text-muted">Sub Category</small>                        
                            </div>                        
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">  
                                <input type="text" class="form-control form-control-sm" id="work_add_date" name="work_add_date" placeholder="Work Add Date" disabled> 
                                <small id="work_add_date" class="form-text text-muted">Work Add Date</small>                      
                            </div>
                            <div class="form-group col-md-6">                          
                                <select id="work_priority" name="work_priority" class="form-control form-control-sm">                                
                                    <option selected>Low</option>
                                    <option>Normal</option>
                                    <option>High</option>
                                </select>
                                <small id="work_priority" class="form-text text-muted">Work Priority</small>
                            </div>                        
                        </div>

                        <div class="form-group">                   
                            <textarea class="form-control form-control-sm" name="work_detail" id="work_detail" rows="2" cols="100%" placeholder="Work Note" ></textarea>
                            <small id="work_detail" class="form-text text-muted">Work Detail</small>                    
                        </div>  
                        
                        <hr>
                        <h6>Visitor Detail</h6>
                        <div class="form-group col-md-4">                                   
                            <input type="hidden" class="form-control" id="visitor_id" name="visitor_id">
                        </div>
                        <div class="form-group">                   
                            <input type="text" class="form-control form-control-sm" id="visitor_name" name="visitor_name" placeholder="Visitor Name" disabled> 
                            <small id="visitor_name" class="form-text text-muted">Visitor Name</small>                    
                        </div>  

                        <div class="form-row">
                            <div class="form-group col-md-8">                         
                                <input type="text" class="form-control form-control-sm" id="visitor_contact" name="visitor_contact" placeholder="Phone & Email" disabled>
                                <small id="visitor_contact" class="form-text text-muted">Contact Details</small>                                 
                            </div>
                            <div class="form-group col-md-4">                          
                                <input type="text" class="form-control form-control-sm" id="visitor_detail" name="visitor_detail" placeholder="Gender | DOB" disabled>
                                <small id="visitor_detail" class="form-text text-muted">Details</small>                   
                            </div>                        
                        </div>          

                    </div>   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Save changes</button> -->
                    <button type="submit" id="updateWorkBtn" class="btn btn-sm btn-primary">Update changes</button>
                </div>
        </form>
    </div>
    </div>
</div>

<!-- remove modal -->
<div class="modal" tabindex="-1" role="dialog" id="removeMemberModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove Work Detail  !</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>                     
        <div class="modal-body px-4 py-1">

            <div id="removeMsg"></div>
            <div id="rmove_model_body">
                <div class="row" >
                    <div class=" col-md-5">
                        <p id="remove_Paragraph"><strong>Do You Really Want to Delete ?</strong><br>
                            This Process is not Undo...!
                        </p>
                    </div>
                    <div class="col-md-7">
                        <div class="form-row">
                            <div class="form-group col-md-6">                                   
                                <input class="form-check-input" type="checkbox" id="remove_work_detail" value="remove_work_detail" checked disabled>
                                <label class="form-check-label" for="remove_work_detail">Delete Work Detail</label>
                            </div>
                            <div class="form-group col-md-6">                                   
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="remove_visitor_detail" checked disabled>
                                <label class="form-check-label" for="remove_visitor_detail">Delete Visitor Detail</label>
                            </div>
                        </div>
                    </div>
                </div>                    

                <div class="form-row">
                    <div class="form-group col-md-4">                                   
                        <input type="hidden" class="form-control form-control-sm" id="work_id_r" disabled>
                    </div>
                    <div class="form-group col-md-4">                                   
                        <input type="hidden" class="form-control form-control-sm" id="work_complete_date_r" disabled>
                    </div>
                    <div class="form-group col-md-4">  
                        <input type="text" class="form-control form-control-sm" id="work_status_r" placeholder="Work Status" disabled>                                 
                    </div>

                </div>

                <div class="form-group">                         
                    <input type="text" class="form-control form-control-sm" id="work_title_r" name="work_title_r" placeholder="Work Title" disabled> 
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">  
                        <input type="text" class="form-control form-control-sm" id="work_cat_r" name="work_cat_r" placeholder="Work Category" disabled> 
                        <small id="work_cat_r" class="form-text text-muted">Category</small>                      
                    </div>
                    <div class="form-group col-md-6">                          
                        <input type="text" class="form-control form-control-sm" id="work_subcat_r" name="work_subcat_r" placeholder="Work SubCategory" disabled> 
                        <small id="work_subcat_r" class="form-text text-muted">Sub Category</small>
                    </div>                        
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">  
                        <input type="text" class="form-control form-control-sm" id="work_add_date_r" name="work_add_date_r" placeholder="Work Add Date" disabled> 
                        <small id="work_add_date_r" class="form-text text-muted">Work Add Date</small>                      
                    </div>
                    <div class="form-group col-md-6"> 
                        <input type="text" class="form-control form-control-sm" id="work_priority_r" name="work_priority_r" placeholder="Work Priority" disabled>                          
                        <small id="work_priority_r" class="form-text text-muted">Work Priority</small>
                    </div>                        
                </div>

                <div class="form-group">                   
                    <textarea class="form-control form-control-sm" name="work_detail_r" id="work_detail_r" rows="1" cols="100%" placeholder="Work Note" disabled></textarea>
                    <small id="work_detail_r" class="form-text text-muted">Work Detail</small>                    
                </div>  

                <hr>
                <h6>Visitor Detail</h6>
                <div class="form-group col-md-4">                                   
                    <input type="hidden" class="form-control" id="visitor_id_r">
                </div>
                <div class="form-group">                   
                    <input type="text" class="form-control form-control-sm" id="visitor_name_r" name="visitor_name_r" placeholder="Visitor Name" disabled> 
                    <small id="visitor_name_r" class="form-text text-muted">Visitor Name</small>                    
                </div>  
                <div class="form-row">
                    <div class="form-group col-md-8">                         
                        <input type="text" class="form-control form-control-sm" id="visitor_contact_r" name="visitor_contact_r" placeholder="Phone & Email" disabled>
                        <small id="visitor_contact_r" class="form-text text-muted">Contact Details</small>                                 
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="text" class="form-control form-control-sm" id="visitor_detail_r" name="visitor_detail_r" placeholder="Gender | DOB" disabled>
                        <small id="visitor_detail_r" class="form-text text-muted">Details</small>                   
                    </div>                        
                </div>  
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" id="rmWorkModelBtn" data-dismiss="modal">No</button>
            <button type="button" id="rmoveworkBtn" class="btn btn-primary btn-sm">Yes</button>
        </div>
        
    </div>
</div>
<!-- /remove modal -->


  






    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>  
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="government.js"></script>
    
</body>
</html>