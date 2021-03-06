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
    <title>Work Detail</title>
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

            <li class="nav-item active">
                <a class="nav-link" href="#">Work Detail</a>
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

    <div class="container bg-white py-2 my-3" id="printContent">
        <div class="row my-3">
            <div class="col-md-6 ">
                <h5>Work Id: <span id="word_id"></span></h5>                
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" id="printBtn" onclick="printDoc()" class="btn btn-primary btn-sm mr-3">Print</button>
                <button type="button" id="Letter" onclick="passData_Letter()" class="btn btn-info btn-sm">Create Letter</button>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12 border border-secondary p-4">
                <h6><strong>Work Detail</strong></h6>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="hidden" class="form-control form-control-sm" id="user_id" value="<?php echo $_SESSION['U_Id']; ?>" disabled>
                        <input type="hidden" class="form-control form-control-sm" id="user_department" value="<?php echo $_SESSION['Department']; ?>" disabled>                                   
                        <input type="hidden" class="form-control form-control-sm" id="work_id" disabled>
                    </div>
                    <div class="form-group col-md-6">                                   
                        <input type="hidden" class="form-control form-control-sm" id="work_complete_date" disabled>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-8">  
                        <input type="text" class="form-control form-control-sm" id="work_title" name="work_title" placeholder="Work Title" disabled> 
                        <small id="work_title" class="form-text text-muted">Work Title</small>                      
                    </div>   
                    <div class="form-group col-md-4">  
                        <input type="text" class="form-control form-control-sm" id="work_status" placeholder="Work Status" disabled>
                        <small id="work_status" class="form-text text-muted">Work Status</small>                      
                    </div>                  
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">  
                        <input type="text" class="form-control form-control-sm" id="work_cat_subcat" name="work_cat_subcat_r" placeholder="Work Category | Subcategory" disabled> 
                        <small id="work_cat_subcat" class="form-text text-muted">Category</small> 
                        <input type="hidden" class="form-control form-control-sm" id="work_cat" name="work_cat" disabled>  
                        <input type="hidden" class="form-control form-control-sm" id="work_subcat" name="work_subcat" placeholder="Subcategory" disabled> 
                        <input type="hidden" class="form-control form-control-sm" id="work_subcat_letter" name="work_subcat_letter" placeholder="Subcategory" disabled>                     
                    </div>   
                    <div class="form-group col-md-4">  
                        <input type="text" class="form-control form-control-sm" id="work_add_date" name="work_add_date" placeholder="Work Add Date" disabled> 
                        <small id="work_add_date" class="form-text text-muted">Work Add Date</small>                      
                    </div>
                    <div class="form-group col-md-4"> 
                        <input type="text" class="form-control form-control-sm" id="work_priority" name="work_priority" placeholder="Work Priority" disabled>                          
                        <small id="work_priority" class="form-text text-muted">Work Priority</small>
                    </div>                    
                </div>

                <div class="form-row">
                       
                </div>

                <div class="form-group">                   
                    <textarea class="form-control form-control-sm" name="work_detail" id="work_detail" rows="1" cols="100%" placeholder="Work Note" disabled></textarea>
                    <small id="work_detail" class="form-text text-muted">Work Detail</small>                    
                </div>  

                <div class="row">
                    <div class="col-md-9">
                        <div id="subcategory_layout"></div>
                    </div>
                    <div class="col-md-3">
                      <a  id="work_doc_pre" target="_blank" rel="noopener noreferrer"> <img src="../image/default_document.png" class="img-thumbnail rounded mx-auto d-block" id="work_doc" name="work_doc"></a>
                       <a href="#" class="btn btn-primary btn-sm m-3" id="final_letter" target="_blank" rel="noopener noreferrer"> Download Letter</a>
                    </div>
                </div>
                

                <hr>
                <!-- visitor detail -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-row">
                            <div class="form-group col-md-6">                         
                                <h6><strong>Visitor Detail</strong> </h6>         
                            </div> 
                            <div class="form-group col-md-3">                          
                                <input type="text" class="form-control form-control-sm" id="visitor_type" name="visitor_type" placeholder="By Call" disabled>
                            </div>   
                            <div class="form-group col-md-3">                          
                                <input type="text" class="form-control form-control-sm" id="visitor_voter" name="visitor_voter" placeholder="Voter Info" disabled>
                                <small id="visitor_voter" class="form-text text-muted">Voter</small>  
                            </div>                     
                        </div> 

                        <div class="form-group col-md-4">                                 
                            <input type="hidden" class="form-control" id="visitor_id" name="visitor_id">
                        </div>
        
                        <div class="form-row">
                            <div class="form-group col-md-8">                         
                                <input type="text" class="form-control form-control-sm" id="visitor_name" name="visitor_name" placeholder="Visitor Name" disabled> 
                            <small id="visitor_name" class="form-text text-muted">Visitor Name</small>                    
                            </div>
                            <div class="form-group col-md-4">                          
                                <input type="text" class="form-control form-control-sm" id="visitor_detail" name="visitor_detail" placeholder="Gender | DOB" disabled>
                                <small id="visitor_detail" class="form-text text-muted">Details: Gender | Date Of Birth</small>                   
                            </div>                        
                        </div> 

                        <div class="form-row">
                            <div class="form-group col-md-4">                         
                                <input type="text" class="form-control form-control-sm" id="visitor_contact" name="visitor_contact" placeholder="Phone & Email" disabled>
                                <small id="visitor_contact" class="form-text text-muted">Contact Details</small>                                 
                            </div>
                            <div class="form-group col-md-8">                          
                                <input type="text" class="form-control form-control-sm" id="visitor_address" name="visitor_address" placeholder="Address, city, pincode" disabled>
                                <small id="visitor_address" class="form-text text-muted">Address | City | Pincode</small>                   
                            </div>                        
                        </div> 

                        <div class="form-row">
                            <div class="form-group col-md-4"> 
                                <input type="text" class="form-control form-control-sm " id="v_adhar_card" name="v_adhar_card" placeholder="Adhar Card" disabled>                                                        
                                <small id="v_adhar_card" class="form-text text-muted">Adhar Card </small>
                            </div>
                            <div class="form-group col-md-4">                          
                                <input type="tel" class="form-control form-control-sm" id="v_voter_card" name="v_voter_card" placeholder="Voter Card" disabled>
                                <small id="v_voter_card" class="form-text text-muted">Voter Card </small>
                            </div> 
                            <div class="form-group col-md-4">                          
                                <input type="tel" class="form-control form-control-sm" id="v_pan_card" name="v_pan_card" placeholder="Pan Card" disabled>
                                <small id="v_pan_card" class="form-text text-muted">Pan Card</small>
                            </div>                        
                        </div> 

                        <hr>
                        <!-- refernce detail -->
                        <div id="reference_detail">
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-3"><strong>Refernce Detail</strong></p>
                                    <div class="form-row">
                                        <div class="form-group col-md-6"> 
                                            <input type="hidden" class="form-control form-control-sm" id="refernce_id" name="refernce_id"> 
                                            <input type="text" class="form-control form-control-sm" id="refernce_name" name="refernce_name" placeholder="Refernce Name" disabled> 
                                            <small id="refernce_name" class="form-text text-muted">Refernce Name</small>                                                       
                                        </div>
                                        <div class="form-group col-md-6">                          
                                            <input type="tel" class="form-control form-control-sm" id="refernce_phone" name="refernce_phone" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Refernce Phone" disabled>
                                            <small id="refernce_phone" class="form-text text-muted">Refernce Phone</small> 
                                        </div>                        
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-4"> 
                                            <input type="text" class="form-control form-control-sm" id="refernce_detail" name="refernce_detail" placeholder="DOB | Gender" aria-describedby="refernce_dob" disabled>
                                            <small id="refernce_dob" class="form-text text-muted">Refernce Date of Birth | Gender</small>                                                       
                                        </div>
                                        <div class="form-group col-md-4">                          
                                            <input type="text" class="form-control form-control-sm" id="refernce_occupation" name="refernce_occupation" placeholder="Refernce Occupation" disabled>
                                            <small id="refernce_occupation" class="form-text text-muted">e.g. Nagar Sevak, Sarpanch, Other</small>
                                        </div>  
                                        <div class="form-group col-md-4">                          
                                            <input type="text" class="form-control form-control-sm" id="refernce_address" name="refernce_address" placeholder="Refernce Address " disabled>
                                            <small id="refernce_address" class="form-text text-muted">Refernce Address</small>
                                        </div>                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-3">
                        <button type="button" id="visitorDetail_btn" onclick="visitorDetail()" class="btn btn-primary btn-sm my-3">Visitor Detail</button>
                        <img src="../image/default_img.png" class="img-thumbnail rounded mx-auto d-block" id="visitor_profile" name="visitor_profile" >
                    </div>
                </div>
                
 
            </div>
        </div>

        <!-- Assign Karykarta  -->
        <div class="row">
            <div class="col-12 border border-secondary my-3 p-3">
                <h6><strong>Karykarta Detail</strong></h6>
                <br>

                <div id="karykarta_detail">
                    <div class="form-row">
                        <div class="form-group col-md-3">  
                            <input type="hidden" id="karykarta_id" name="karykarta_id" disabled> 
                            <input type="text" class="form-control form-control-sm" id="karykarta_name" name="karykarta_name" placeholder="Karykarta Name" disabled> 
                            <small id="karykarta_name" class="form-text text-muted">Karykarta Name</small>                      
                        </div>   
                        <div class="form-group col-md-3">  
                            <input type="text" class="form-control form-control-sm" id="karykarta_contact" name="karykarta_contact" placeholder="Karykarta Contact" disabled> 
                            <small id="karykarta_contact" class="form-text text-muted">Karykarta Contact</small>                      
                        </div>
                        <div class="form-group col-md-2"> 
                            <input type="text" class="form-control form-control-sm" id="karykarta_department" name="karykarta_department" placeholder="Department" disabled>                          
                            <small id="karykarta_department" class="form-text text-muted">Department</small>
                        </div>   
                        <div class="form-group col-md-2"> 
                            <input type="text" class="form-control form-control-sm" id="karykarta_status" name="karykarta_status" placeholder="Status" disabled>                          
                            <small id="karykarta_status" class="form-text text-muted">Status</small>
                        </div>  
                        <div class="form-group col-md-2"> 
                            <button id="karykarta_rm_btn" onclick="dismisskarykarta()" class="btn btn-danger btn-sm">Remove</button>
                        </div>                
                    </div>
                    <div id="karykarta_msg"></div>
                </div>
                
                <div id="karykarta_list">
                    <hr>
                    <h6><strong>Karykarta List</strong></h6>
                    <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                        <table id="Karykarta_datatable" class="table table-sm table-border table-reponsive">
                            <thead>
                                <tr>
                                    <th width="5%">Id</th>
                                    <th width="30%">Name</th>
                                    <th width="25%">Contact</th>
                                    <th width="20%">Department</th> 
                                    <th width="10%">Status</th>                                
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    

                </div>
                

            </div>
        </div>

        <!-- assign New Adhikari -->
        <div id="adhikari_div">
            <div class="row">
                <div class="col-12 border border-secondary my-3 p-3">
                    <h6><strong>Adhikari Detail</strong></h6>
                    <br>

                    <div id="karykarta_detail">
                        <div class="form-row">
                            <div class="form-group col-md-3">  
                                <input type="hidden" id="adhikari_id" name="adhikari_id" disabled> 
                                <input type="text" class="form-control form-control-sm" id="adhikari_name" name="adhikari_name" placeholder="Adhikari Name" disabled> 
                                <small id="adhikari_name" class="form-text text-muted">Adhikari Name</small>                      
                            </div>   
                            <div class="form-group col-md-3">  
                                <input type="text" class="form-control form-control-sm" id="adhikari_contact" name="adhikari_contact" placeholder="Adhikari Contact" disabled> 
                                <small id="adhikari_contact" class="form-text text-muted">Adhikari Contact</small>                      
                            </div>
                            <div class="form-group col-md-3"> 
                                <input type="text" class="form-control form-control-sm" id="adhikari_department" name="adhikari_department" placeholder="Adhikari Department" disabled>                          
                                <small id="adhikari_department" class="form-text text-muted">Department</small>
                            </div>   
                            <div class="form-group col-md-2"> 
                                <input type="text" class="form-control form-control-sm" id="adhikari_status" name="adhikari_status" placeholder="Adhikari Status" disabled>                          
                                <small id="adhikari_status" class="form-text text-muted">Status</small>
                            </div>  
                            <div class="form-group col-md-1"> 
                                <button id="adhikari_rm_btn" onclick="dismissAdhikari()" class="btn btn-danger btn-sm">Remove</button>
                            </div>                
                        </div>
                    </div>
                    
                    <div id="adhikari_list">
                        <hr>                        
                        <div class="row">
                            <div class="col-md-6"><h6><strong>Adhikari List</strong></h6></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
                            </div>
                        </div>
                        <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                            <table id="adhikari_datatable" class="table table-sm table-border table-reponsive">
                                <thead>
                                    <tr>
                                        <th width="5%">Id</th>
                                        <th width="30%">Name</th>                                        
                                        <th width="20%">Department</th> 
                                        <th width="25%">Contact</th>
                                        <th width="10%">Status</th>                                
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>                       

                    </div>
                    

                </div>
            </div>
        </div>






    </div>    

        <!-- filter Modal -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
            <div class="modal-body px-4 py-2"> 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <select id="adhikari_department_f" name="adhikari_department_f" class="form-control form-control-sm" required> 
                            <option selected>All</option>                                
                            <option>Forest Officer</option>
                            <option>Collector</option>
                            <option>Mining Officer</option>
                            <option>District Informatics Officer</option>
                            <option>Tahsildar, Revenue Branch</option>
                        </select> 
                        <small id="adhikari_department_f" class="form-text text-muted">Department</small>                                
                    </div>
                    <div class="form-group col-md-6">                                    
                        <select id="adhikari_status_f" name="adhikari_status_f" class="form-control form-control-sm">
                            <option selected>All</option> 
                            <option value="Active">Active</option>
                            <option value="In-Active">In Active</option>
                        </select>
                        <small id="adhikari_status_f" class="form-text text-muted"> Status</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>                  
                <button type="button"  id="filter_fun" class="btn btn-sm btn-primary">Filter</button>
                <button type="button"  id="clear_filter" class="btn btn-sm btn-danger">Clear</button>
            </div>     
      </div>
    </div>
  </div>


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>  
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script> 
    <script src="workdetail.js"></script> 
</body>
</html>