<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Personal" || $_SESSION['Department'] == "Admin")
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
    <title>Eduction Help</title>
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
            <li class="nav-item">
                <a class="nav-link" href="../MedicalLetter/medicalList.php">Medical</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../education/education.html">Personal</a>
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

    <div class="row p-3">
        <div class="col-md-6 ">
            <button type="button" class="btn btn-sm btn-primary">
                Notifications : Today Work <span  id="today_total_work" class="badge badge-light"></span>
            </button>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary my-auto"  data-toggle="modal" data-target="#exampleModal1">filter</button>
        </div>
    </div>

    <hr>

    <div class="row p-3">
        <div class="col-12">          
            <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                <table id="education_datatable" class="table table-border table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="25%">Student Name</th>
                            <th width="20%">Collage Name</th>
                            <th width="15%">Class</th>
                            <th width="15%">Fee</th>                                
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
<div class="modal fade" id="educationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Education Detail : <span id="Education_id_txt"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="education_frm"> 
                    <div class="modal-body p-4">       
                        <div id="messages"></div>
                        <div id="from_data">
                            <div class="form-row">
                                <div class="form-group col-md-8">    

                                    <div class="form-row">
                                        <div class="form-group col-md-6">                     
                                            <input type="hidden" class="form-control form-control-sm" id="e_id" name="e_id">                                
                                        </div> 
                                        <div class="form-group col-md-6">  
                                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                            <input type="hidden" class="form-control form-control-sm" id="v_id" name="v_id">  
                                            <input type="hidden" class="form-control form-control-sm" id="w_id" name="w_id">                                               
                                        </div>
                                    </div> 

                                    <div class="form-group">                      
                                        <input type='text' class='form-control form-control-sm' id='student_name' name='student_name' placeholder='Student Name' required>
                                        <small id='invitation_title' class='form-text text-muted'>Student Name</small>                  
                                    </div> 

                                    <div class="form-group">                      
                                        <input type='text' class='form-control form-control-sm' id='collage_Name' name='collage_Name' placeholder='Collage Name | Address' required>
                                        <small id='collage_Name' class='form-text text-muted'>Collage Name | Address</small>                  
                                    </div>
                                    
                                    <div class="form-group">                      
                                        <input type='text' class='form-control form-control-sm' id='student_class' name='student_class' placeholder='Student Class' required>
                                        <small id='student_class' class='form-text text-muted'>Student Class</small>                  
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">                     
                                            <input type='text' class='form-control form-control-sm' id='student_discount_fee' name='student_discount_fee' placeholder='Student Fee Discount' required>
                                            <small id='student_discount_fee' class='form-text text-muted'>Student Fee Discount</small>                                               
                                        </div> 
                                        <div class="form-group col-md-6">  
                                            <input type='text' class='form-control form-control-sm' id='student_fee_total' name='student_fee_total' placeholder='Student Fee Total' required>
                                            <small id='student_fee_total' class='form-text text-muted'>Student Fee Total</small>                                              
                                        </div>
                                    </div> 

                                </div>
                                <div class="form-group col-md-4">                          
                                    <img src="../image/default_img.png" id="student_img_pre" class="img-thumbnail m-2">
                                    <div class="form-group">                   
                                        <input type="file" id="student_profile" name="student_profile" class=" m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>                        
                            </div>  

                        </div>                                           
                            
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Save changes</button> -->
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
<script src="education.js"></script>
    
</body>
</html>