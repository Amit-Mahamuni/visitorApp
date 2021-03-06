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
    <title>Connector Detail</title>
    <link rel="stylesheet" href="../css/bootstrap.css">    	
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.all.css"/>
</head>
<body>

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
                <a class="nav-link" href="#">Connector Detail </a>
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

    <div class="container">
        <div class="row my-3">
            <div class="col-12  d-flex justify-content-between">
                <h5>Connector Id: <span id="connector_id"></span></h5>
                <button type="button" id="printBtn" onclick="window.print();" class="btn btn-primary btn-sm">Print</button>
            </div>
        </div>


        <!-- connector detail -->
        <div class="row border border-dark p-3">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-4">                                 
                    </div> 
                    <div class="form-group col-md-4">   
                        <input type="text" class="form-control form-control-sm" id="connector_occupation" name="connector_occupation" placeholder="Occupation" disabled>
                        <small id="connector_occupation" class="form-text text-muted">Occupation</small>  
                    </div>   
                    <div class="form-group col-md-4">                          
                        <input type="text" class="form-control form-control-sm" id="connector_status" name="connector_status" placeholder="Status" disabled>
                        <small id="connector_status" class="form-text text-muted">Status</small>  
                    </div>                     
                </div> 

                <div class="form-row">
                    <div class="form-group col-md-8">                         
                        <input type="text" class="form-control form-control-sm" id="connector_name" name="connector_name" placeholder="Name" disabled> 
                        <small id="connector_name" class="form-text text-muted">Name</small>                    
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="text" class="form-control form-control-sm" id="connector_detail" name="connector_detail" placeholder="Gender | DOB" disabled>
                        <small id="connector_detail" class="form-text text-muted">Details: Gender | Date Of Birth</small>                   
                    </div>                        
                </div> 

                <div class="form-row">
                    <div class="form-group col-md-4">                         
                        <input type="text" class="form-control form-control-sm" id="connector_contact" name="connector_contact" placeholder="Phone & Email" disabled>
                        <small id="connector_contact" class="form-text text-muted">Contact Details</small>                                 
                    </div>
                    <div class="form-group col-md-8">                          
                        <input type="text" class="form-control form-control-sm" id="connector_address" name="connector_address" placeholder="Address, city, pincode" disabled>
                        <small id="connector_address" class="form-text text-muted">Address | City | Pincode</small>                   
                    </div>                        
                </div> 

            </div>

            <div class="col-md-3">
                <a href="http://" id="connector_pro_href" target="_blank" rel="noopener noreferrer">
                    <img src="../image/default_img.png" class="img-thumbnail rounded mx-auto d-block" id="connector_profile" name="connector_profile" >
                </a>
            </div>
        </div> 


        <!-- work detail -->
        <div class="row">
            <div class="col-md-12">                
                <div class="row border border-dark p-3">
                    <div class="col-12">                            
                        <button type="button" class="btn btn-sm btn-primary">
                            Total Work : <span id="total_work" class="badge badge-light"></span>
                        </button> 
                        <div class="table-reponsive my-4">
                            <table id="workList_datatable" class="table table-hover table-sm table-bordered table-reponsive">
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
    <script src="../js/bootstrap.js"></script>  
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="connectorDetail.js"></script> 
    
</body>
</html>