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
    <title>Ration Card Letter</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <style>
        @media print{
            /**/
            body * {
                visibility: hidden;
            }
            .print-conatiner, .print-conatiner * {
                visibility: visible;

            }

            .print-conatiner{
                position: absolute;
                top: 100px;
            }

        }
    </style>
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

        <!-- Header code -->
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">         
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <h5>Ration Card Letter Format </h5>
                    </li>                
                  </ul>
                  <ul class="navbar-nav ">
                    <button class="btn btn-danger btn-sm m-1" id="uploadLetterModalBtn" data-toggle="modal" data-target="#uploadLetterModal" >Upload Final Letter</button>
                    <button class="btn btn-primary btn-sm m-1" data-toggle="modal" data-target="#visitorDetailModal">Check Visitor Detail</button>
                  </ul>
              
              </nav>
        </div>

        <!-- visitor detail Modal -->
        <div class="modal fade" id="visitorDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visitor Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4 py-2"> 

                    <div class="row">
                        <div class="col-md-12">
                            <h5> Detail</h5>
                            
                            <div class='form-row'>
                            <div class='form-group col-md-4'>
                                <input type='text' class='form-control form-control-sm' id='ration_l_tman' name='ration_l_tman' placeholder='Total Man in Family' disabled>
                                    <small id='ration_l_tman' class='form-text text-muted'>Total Man in Family</small>                     
                            </div>
                            <div class='form-group col-md-4'>   
                                <input type='text' class='form-control form-control-sm'   id='ration_l_twoman' name='ration_l_twoman' placeholder='Total WoMan in Family' disabled>             
                                <small id='ration_l_twoman' class='form-text text-muted'> Total WoMan in Family </small>
                            </div> 
                            <div class='form-group col-md-4'>   
                                <input type='text' class='form-control form-control-sm'   id='ration_l_tlive' name='ration_l_tlive' placeholder='Total Year Lived in Maval' disabled>             
                                <small id='ration_l_tlive' class='form-text text-muted'> Total Year Lived in Maval </small>
                            </div> 
                            </div>                          

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Visitor Detail</h5>
                            <div class="form-group col-md-4">                                   
                                <!-- <input type="hidden" class="form-control" id="visitor_id" > -->
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
            
                            <div class="form-group">                   
                                <input type="text" class="form-control form-control-sm" id="visitor_address" name="visitor_address" placeholder="Visitor Address" disabled> 
                                <small id="visitor_name" class="form-text text-muted">Visitor Address</small>                    
                            </div>
                        </div>
                    </div>
                </div>                           
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>                    
                </div>
            </div>
            </div>
        </div>

        <!-- upload letter Modal -->
        <div class="modal fade" id="uploadLetterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Final Letter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="upload_file">
                <div class="modal-body px-4 py-2"> 
                    <div class="row">
                        <div class="col-md-12 ">                           
                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>" disabled>
                                <img src="../../image/default_document1.jpg" id="doc_img_pre"  class="rounded mx-auto d-block m-4" width="50%" height="auto">
                                <div class="form-group">                   
                                    <input type="file" id="final_document" class="m-2 pb-5 form-control" name="final_document" accept=".jpg, .jpeg, .png, .pdf">                       
                                </div>                               
                            
                        </div>
                    </div>
                </div>                           
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button> 
                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Upload File</button>                   
                </div>
            </form>
            </div>
            </div>
        </div>


        <div id="form_section">

            <form id="letter_frm">
    
                <div class="container mt-2 ">
                    <div class="row">
                        <div class="col-12">                        
                            <div class=" d-flex justify-content-end">
                                <button type="submit" id="updateML" class="btn btn-primary btn-sm mr-4"  id="save_letter_btn">Save</button>
                                <button type="button" class="btn btn-info btn-sm" id="print_ML">Print</button>
                            </div>            
                        </div>
                    </div>
        
                    <div class="row my-2">
                        <div class="col-md-12">
                            <div id="messages_ml_id"></div>
                        </div>
                    </div>
                </div>  
    
               
    
    
        
                <!-- letter layout -->
                <div class="p-4" style="background-color:lightblue">
                
                    <div class="container my-5 p-5 print-conatiner" style="background-color:white">
                        <div class="row">
                            <div class="col-12 px-1">
                                <div class="d-flex justify-content-between">
                                    <h6>ID : <span id="l_id_txt"></span></h6>
                                    <h6>Date : <span id="current_date"></span></h6>  
                                    <input type="hidden" id="work_id" name="work_id">
                                    <input type="hidden" id="visitor_id" name="visitor_id">
                                    <input type="hidden" id="id" name="id">                   
                                </div>                 
                            </div>
                        </div> 
                        <br>
                
                            <div class="row">
                                <div class="col-12 px-1 mt-5">
                                    <div class="d-flex justify-content-between">
                                        <textarea class="textarea_l" name="letter_to" id="letter_to" cols="30" rows="5"></textarea>                    
                                    </div>                 
                                </div>
                            </div>   
                            
                            <br><br>
                            
                            <div class="row my-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <textarea class="textarea_l" name="letter_subject" id="letter_subject" cols="50%" rows="1"></textarea>                    
                                    </div> 
                                </div>
                            </div>
            
                            <div class="row my-2">            
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <textarea  class="textarea_l" name="letter_detail" id="letter_detail" cols="210" rows="15"></textarea>
                                    </div>                
                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="row">
                                <div class="col-12 py-3">
                                    <div class="d-flex justify-content-end">
                                        <textarea class="textarea_l" name="letter_sign" id="letter_sign" cols="30" rows="5"></textarea>                    
                                    </div>                 
                                </div>
                            </div>            
                    </div>                
                </div>  
            </form>
        </div>





    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>   
    <script src="rationCardLetter.js"></script> 
    
</body>
</html>