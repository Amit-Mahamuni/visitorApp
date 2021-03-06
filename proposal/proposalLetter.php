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
    <title>Proposal Letter</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
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
                    <li class="nav-item ">
                        <a class="nav-link" href="../proposal/proposal.php">Add Proposal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../proposal/proposalList.php">Proposal List</a>
                    </li> 
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Proposal Letter</a>
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

        <!-- Header code -->
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">         
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <h5>Proposal Letter Format </h5>
                    </li>                
                  </ul>
                  <ul class="navbar-nav ">
                    <button class="btn btn-danger btn-sm m-1" id="uploadLetterModalBtn" data-toggle="modal" data-target="#uploadLetterModal" >Upload Final Letter</button>
                    <button class="btn btn-primary btn-sm m-1" data-toggle="modal" data-target="#visitorDetailModal">Check Proposal Detail</button>
                  </ul>
              
              </nav>
        </div>

        <!-- visitor detail Modal -->
        <div class="modal fade" id="visitorDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Proposal Detail</h5>
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
                                    <input type='text' class='form-control form-control-sm' id='proposal_status' name='proposal_status' placeholder='Total Man in Family' disabled>
                                        <small id='proposal_status' class='form-text text-muted'>Status</small>                     
                                </div>
                                <div class='form-group col-md-4'>   
                                    <input type='text' class='form-control form-control-sm'   id='proposal_priority' name='proposal_priority' placeholder='Total WoMan in Family' disabled>             
                                    <small id='proposal_priority' class='form-text text-muted'> Priority</small>
                                </div> 
                                <div class='form-group col-md-4'>   
                                    <input type='text' class='form-control form-control-sm'   id='proposal_add_date' name='proposal_add_date' placeholder='Total Year Lived in Maval' disabled>             
                                    <small id='proposal_add_date' class='form-text text-muted'> Add Date </small>
                                </div> 
                            </div>         
                            
                            <div class='form-row'>
                                <div class='form-group col-md-12'>
                                    <input type='text' class='form-control form-control-sm' id='proposal_note' name='proposal_note' placeholder='Total Man in Family' disabled>
                                        <small id='proposal_note' class='form-text text-muted'>Note</small>                     
                                </div>
                            </div>     

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Creator Detail</h5>

                            <div class="form-row">                   
                                <div class="form-group col-md-6">    
                                    <input type="hidden" class="form-control form-control-sm" id="proposal_id" name="proposal_id">                     
                                    <input type="text" class="form-control form-control-sm" id="proposal_name" name="proposal_name" placeholder="Name" disabled>
                                </div>
                                <div class="form-group col-md-6">                          
                                    <input type="text" class="form-control form-control-sm" id="proposal_phone" name="proposal_phone" minlength="10" maxlength="10" placeholder="Phone" disabled >
                                </div>             
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
                        <div class="col-md-12 d-flex justify-content-center">
                            <div id="messages_ml_id"></div>
                            <h6 class="alert alert-info" id="status_txt"></h6>
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
                                    <input type="hidden" id="Proposal_Id" name="Proposal_Id">                   
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
                                        <textarea class="textarea_l" name="letter_subject" id="letter_subject" cols="70%" rows="1"></textarea>                    
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
                            <!-- <br><br>

                            <div class="row my-2">            
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <textarea  class="textarea_l" name="letter_end" id="letter_end" cols="210" rows="3"></textarea>
                                    </div>                
                                </div>
                            </div> -->
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





    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>   
    <script src="proposalLetter.js"></script> 
    
</body>
</html>