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
    <title>Medical</title>
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
                <a class="nav-link" href="../MedicalLetter/medicalList.php">Medical</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../education/education.php">Education</a>
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

    <!-- Medical List -->
    <div class="container bg-white my-4">

        <div class="row">
            <div class="col-md-6 my-2">
                <button type="button" class="btn btn-sm btn-primary">
                    Notifications : Today Work <span  id="today_work" class="badge badge-light"></span>
                </button>
            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-dark p-3">
            <div class="col-12">     
                <div class="table table-reponsive table-bordered my-4  p-3">
                    <table id="hospital_datatable" class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Id</th>
                                <th width="25%">Name</th>
                                <th width="25%">Hospital</th>
                                <th width="15%">Disease</th>
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
                            <select id="work_status_f" name="work_status_f" class="form-control form-control-sm">
                                <option selected>All</option> 
                                <option value="Pending">Pending</option>
                                <option value="Complete">Complete</option>
                                <option value="Under Process">Under Process</option>
                            </select>
                            <small id="work_status_f" class="form-text text-muted">Work Status</small>                                 
                        </div>
                        <div class="form-group col-md-6">                                    
                            <select id="work_priority_f" name="work_priority_f" class="form-control form-control-sm">                           
                                <option selected>All</option>
                                <option>Low</option>
                                <option>Normal</option>
                                <option>High</option>
                            </select>
                            <small id="work_priority_f" class="form-text text-muted">Priority</small>  
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">  
                            <input type="date" class="form-control form-control-sm" id="work_date_from_f" name="work_date_from_f" > 
                            <small id="work_date_from_f" class="form-text text-muted">Date Form</small>                      
                        </div>
                        <div class="form-group col-md-6">                          
                            <input type="date" class="form-control form-control-sm" id="work_date_end_f" name="work_date_end_f"> 
                            <small id="work_date_end_f" class="form-text text-muted">Date End</small>       
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
    <div class="modal fade" id="MedicalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Medical Detail : <span id="medical_id_txt"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="medical_frm"> 
                <div class="modal-body p-4">       
                    <div id="messages"></div>
                    <div id="from_data">
                        <div class="form-row">
                            <div class="form-group col-md-8"> 
                                
                                <!-- work detail -->
                                <div id="work_detail_div">
                                   
                                    <div class="form-row">
                                        <div class="form-group col-md-4">                     
                                            <input type="hidden" class="form-control form-control-sm" id="w_id" name="w_id">
                                            <input type="hidden" class="form-control form-control-sm" id="v_id" name="v_id">
                                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                            <h6>Work ID: <span id="work_id_txt"></span> </h6>
                                        </div> 
    
                                        <div class="form-group col-md-4">                                                                               
                                            <select id="work_status" name="work_status" class="form-control form-control-sm">
                                                <option value="Pending">Pending</option>
                                                <option value="Complete">Complete</option>
                                                <option value="Under Process">Under Process</option>
                                            </select>                                            
                                            <small id="work_status" class="form-text text-muted">Status</small>                                                
                                        </div>
    
                                        <div class="form-group col-md-4">                                                                   
                                            <select id="work_priority" name="work_priority" class="form-control form-control-sm">                                
                                                <option >Low</option>
                                                <option>Normal</option>
                                                <option>High</option>
                                            </select>
                                            <small id="work_priority" class="form-text text-muted">Priority</small>                                               
                                        </div>
    
                                    </div> 
    
                                    <div class="form-group">                      
                                        <input type="text" class="form-control form-control-sm" id="work_title" name="work_title" placeholder="Work Title" required>
                                        <small id="work_title" class="form-text text-muted"> Work Title</small>                     
                                    </div>
                                    
                                    <div class="form-group">                            
                                        <textarea class="form-control form-control-sm" name="work_detail" id="work_detail" rows="2" cols="100%" maxlength="300" placeholder="Work Note"></textarea>
                                        <small id="work_detail" class="form-text text-muted"> Work Detail</small>
                                    </div>

                                </div>


                                <!-- patient details -->
                                <div id="patient_detail">
                                    <hr>
                                    <h5>Patient Detail</h5>
                                    <input type='hidden' class='form-control form-control-sm' id='m_Id' name='m_Id' >
                                    <div class='form-row'>
                                        <div class='form-group col-md-12'>                          
                                            <input type='text' class='form-control form-control-sm' id='patient_name' name='patient_name' placeholder='Patient Name' >
                                            <small id='patient_name' class='form-text text-muted'>Patient Name</small>
                                        </div>
                                    </div> 
                                        <div class='form-row'>
                                    <div class='form-group col-md-4'>
                                        <input type='date' class='form-control form-control-sm' id='patient_dob' name='patient_dob' placeholder='Patient DOB' >
                                        <small id='patient_name' class='form-text text-muted'>Patient DOB</small>                      
                                    </div>
                                    <div class='form-group col-md-4'>                        
                                        <select id='patient_gender' name='patient_gender' class='form-control form-control-sm'>                               
                                            <option value='Male' >Male</option>
                                            <option value='Female'>Female</option>                               
                                            <option value='Other'>Other</option>                              
                                        </select><small id='patient_gender' class='form-text text-muted'>Patient Gender</small>
                                    </div> 
                                    <div class='form-group col-md-4'>                       
                                        <select id='patient_relation' name='patient_relation' class='form-control form-control-sm'>                                
                                            <option value='Son/Daughter of Visitor'>Son/Daughter of Visitor</option>
                                            <option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>
                                            <option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>
                                            <option value='GrandParent of Visitor'>GrandParent of Visitor</option>                                
                                            <option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>
                                            <option value='Self'>Self</option>
                                            <option value='Other'>Other</option>                                
                                        </select><small id='patient_relation' class='form-text text-muted'>Patient Related to Visitor</small>
                                    </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='form-group'>                           
                                        <textarea class='form-control form-control-sm' name='hospital_name' id='hospital_name' rows='1' cols='100%' maxlength='100' placeholder='Hospital Name'></textarea>
                                            <small id='hospital_name' class='form-text text-muted'>Hospital Name | Max. Word 100. | Format - Name , Address </small>
                                        </div>
                                    </div>            
                                    <div class='form-row'>
                                        <div class='form-group col-md-4'>
                                            <input type='text' class='form-control form-control-sm' id='hospital_ward' name='hospital_ward' placeholder='Hospital Ward' >
                                            <small id='hospital_ward' class='form-text text-muted'>Hospital Ward</small>                      
                                        </div>
                                        <div class='form-group col-md-4'>                          
                                            <input type='text' class='form-control form-control-sm' id='hospital_bed' name='hospital_bed' placeholder='Bed No.'>
                                            <small id='hospital_bed' class='form-text text-muted'>Bed No.</small>
                                        </div> 
                                        <div class='form-group col-md-4'>                          
                                            <input type='date' class='form-control form-control-sm' id='admit_date' name='admit_date'>
                                            <small id='admit_date' class='form-text text-muted'>Date Of Admit</small>
                                        </div> 
                                    </div>
                                    <div class='form-row'>
                                        <div class='form-group col-md-12'>                            
                                            <input type='text' class='form-control form-control-sm' id='Disease' name='Disease' placeholder='Disease' >
                                            <small id='Disease' class='form-text text-muted'>Disease</small>
                                        </div>
                                    </div>
                                </div>

                                <div id="visitor_details">
                                    <hr>
                                    <h5>Visitor Detail</h5>
                                    <div class='form-row'>
                                        <div class='form-group col-md-8'>                            
                                            <input type="text" class="form-control form-control-sm" id="visitor_name" name="visitor_name" placeholder="Name" disabled>  
                                            <small id='visitor_name' class='form-text text-muted'>Visitor Name</small>
                                        </div>
                                        <div class='form-group col-md-4'>
                                            <input type="text" class="form-control form-control-sm" id="visitor_voter" name="visitor_voter" placeholder="Voter" disabled>  
                                            <small id="visitor_voter" class="form-text text-muted">Voter</small> 
                                        </div>
                                    </div>

                                    <div class='form-row'>
                                        <div class='form-group col-md-6'>                            
                                            <input type="text" class="form-control form-control-sm" id="visitor_contact" name="visitor_contact" placeholder="Contact Detail" disabled>  
                                            <small id='visitor_contact' class='form-text text-muted'>Contact Detail</small>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <input type="text" class="form-control form-control-sm" id="visitor_detail" name="visitor_detail"  disabled>  
                                            <small id="visitor_detail" class="form-text text-muted">Details</small> 
                                        </div>
                                    </div>

                                    <div class='form-row'>
                                        <div class='form-group col-md-12'>                            
                                            <input type='text' class='form-control form-control-sm' id='visitor_address' name='visitor_address' placeholder='Visitor Address' disabled>
                                            <small id='visitor_address' class='form-text text-muted'>Address</small>
                                        </div>
                                    </div>

                                </div>                              



                            </div>
                            <div class="form-group col-md-4 p-2"> 

                                <div id="visitor_profile_div">
                                    <a href="#" target="_blank" rel="noopener noreferrer" id="visitor_pro_downoad">
                                        <img src="../image/default_img.png" id="visitor_profile" class="img-thumbnail m-2">
                                        <p class="text-center">Visitor Profile</p>
                                    </a>
                                    <hr>
                                </div>                         

                                
                                <div id="work_doc_div">
                                    <a href="#" target="_blank" rel="noopener noreferrer" id="work_doc_downoad">
                                        <img src="../image/default_img.png" id="work_doc" class="img-thumbnail m-2">
                                        <p class="text-center"> Document</p>
                                    </a>
                                    <hr>
                                </div>

                                <div id="m_final_letter_div" >
                                    <h6 class="text-center">Letter is Complete</h6>
                                    <a href="#"  id="m_final_letter" class="btn btn-sm btn-primary ml-md-5"  target="_blank">Download Letter</a>
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
    <script src="medicalList.js"></script>
    
</body>
</html>