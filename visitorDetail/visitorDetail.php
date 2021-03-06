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
    <title>Visitor Detail</title>
    <link rel="stylesheet" href="../css/bootstrap.css">    	
    <link rel="stylesheet" href="../datatable/dataTables.css" />
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
                <a class="nav-link" href="../visitorDetail/visitorDetail.php">Visitor Detail</a>
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

    <div class="container bg-white">
        <div class="row my-3">
            <div class="col-12  d-flex justify-content-between">
                <h5>Visitor Id: <span id="visitor_id"></span></h5>
                <button type="button" id="printBtn" onclick="window.print();" class="btn btn-primary btn-sm">Print</button>
            </div>
        </div>

        <!-- visitor detail -->
        <div class="row border border-secondary p-3">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-6">                         
                        <h6><strong>Visitor Detail</strong> </h6>         
                    </div> 
                    <div class="form-group col-md-3">                          
                        <input type="text" class="form-control form-control-sm" id="visitor_type" name="visitor_type" placeholder="By Call" disabled>
                    </div>          
                    <div class="form-group col-md-3">                          
                        <input type="text" class="form-control form-control-sm" id="visitor_voterInfo" name="visitor_voterInfo" placeholder="Voter Info" disabled>
                        <small id="visitor_voterInfo" class="form-text text-muted">Voter Info</small>
                    </div>              
                </div> 

                <div class="form-group col-md-4">                                   
                    <input type="hidden" class="form-control" id="visitor_id">
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
                        <input type="text" class="form-control form-control-sm" id="v_adhar_card"   name="v_adhar_card"  placeholder="Adhar Card" disabled>                                                        
                        <small id="v_adhar_card" class="form-text text-muted">Adhar Card </small>
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="tel" class="form-control form-control-sm" id="v_voter_card" name="v_voter_card" placeholder="Voter Card" disabled>
                        <small id="v_voter_card" class="form-text text-muted">Voter Card </small>
                    </div> 
                    <div class="form-group col-md-4">                          
                        <input type="tel" class="form-control form-control-sm" id="v_pan_card" name="v_pan_card"  placeholder="Pan Card" disabled >
                        <small id="v_pan_card" class="form-text text-muted">Pan Card</small>
                    </div>                                             
                </div> 

            </div>

            <div class="col-md-3">
                <img src="../image/default_img.png" class="img-thumbnail rounded mx-auto d-block" id="visitor_profile" name="visitor_profile" >
            </div>
        </div> 



        <div class="row">
            <div class="col-md-12">                
                    <div class="row border border-dark p-3">
                        <div class="col-12">                            
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary">
                                Total Work : <span id="total_work" class="badge badge-light"></span>
                            </button>  
                            <button type="button" class="btn btn-sm btn-info" onclick="AddWork()" id="add_karykarta_btn" data-toggle="modal" data-target="#exampleModal">
                                Add Work For this Visitor <i class="far fa-plus-square"></i>
                            </button>                           
            
                            <div class="table-reponsive my-4">
                                <table id="workList_datatable" class="table table-hover table-sm table-border">
                                    <thead>
                                        <tr>
                                            <th width="5%">Id</th>
                                            <th width="40%">Work</th>
                                            <th width="20%">Category</th>
                                            <th width="15%">Add Date</th>                                
                                            <th width="10%">Status</th>                                
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="work_table_body">

                                    </tbody>
                                </table>
                            </div> 

                        </div>
                    </div>
            </div>
        </div>      
        

        
    </div>



    <script src="../js/jquery-3.4.1.min.js"></script>
    <!--  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script> --> 
    <script src="../js/bootstrap.js"></script>  
    <script src="../datatable/dataTables.js"></script>    
    <script src="visitordetail.js"></script>     
</body>
</html>