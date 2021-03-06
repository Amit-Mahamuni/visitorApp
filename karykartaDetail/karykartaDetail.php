<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin" || $_SESSION['Department'] == "Karykarta")
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
    <title>Karykarta Detail</title>
    <link rel="stylesheet" href="../css/bootstrap.css">    	
    <link rel="stylesheet" href="../datatable/dataTables.css" />
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
                <a class="nav-link" href="../karykartaDetail/karykartaDetail.php">Karykarta Detail </a>
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
                <h5>Karykarta Id: <span id="karykarta_id"></span></h5>
                <button type="button" id="printBtn" onclick="window.print();" class="btn btn-primary btn-sm">Print</button>
            </div>
        </div>


        <!-- Karykarta detail -->
        <div class="row border border-dark p-3">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-6">                         
                        <h6><strong>Karykarta Detail</strong> </h6>         
                    </div> 
                    <div class="form-group col-md-3">   
                        <input type="text" class="form-control form-control-sm" id="karykarta_department" name="karykarta_department" placeholder="Department" disabled>
                        <small id="karykarta_department" class="form-text text-muted">Karykarta Department</small>  
                    </div>   
                    <div class="form-group col-md-3">                          
                        <input type="text" class="form-control form-control-sm" id="karykarta_status" name="karykarta_status" placeholder="Status" disabled>
                        <small id="karykarta_status" class="form-text text-muted">Karykarta Status</small>  
                    </div>                     
                </div> 

                <div class="form-group col-md-4">                                  
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php if($_SESSION['Department'] == 'Karykarta'){ echo $_SESSION['U_Id']; } ?>" disabled>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">                         
                        <input type="text" class="form-control form-control-sm" id="karykarta_name" name="karykarta_name" placeholder="Visitor Name" disabled> 
                        <small id="karykarta_name" class="form-text text-muted">Karykarta Name</small>                    
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="text" class="form-control form-control-sm" id="karykarta_detail" name="karykarta_detail" placeholder="Gender | DOB" disabled>
                        <small id="karykarta_detail" class="form-text text-muted">Details: Gender | Date Of Birth</small>                   
                    </div>                        
                </div> 

                <div class="form-row">
                    <div class="form-group col-md-4">                         
                        <input type="text" class="form-control form-control-sm" id="karykarta_contact" name="karykarta_contact" placeholder="Phone & Email" disabled>
                        <small id="visitor_contact" class="form-text text-muted">Contact Details</small>                                 
                    </div>
                    <div class="form-group col-md-8">                          
                        <input type="text" class="form-control form-control-sm" id="karykarta_address" name="karykarta_address" placeholder="Address, city, pincode" disabled>
                        <small id="visitor_address" class="form-text text-muted">Address | City | Pincode</small>                   
                    </div>                        
                </div> 

                <!-- <div class="form-row">                    
                    <div class="form-group col-md-4"> 
                        <input type="text" class="form-control form-control-sm" id="k_adhar_card"   name="k_adhar_card"  placeholder="Adhar Card" disabled>                                                        
                        <small id="k_adhar_card" class="form-text text-muted">Adhar Card </small>
                    </div>
                    <div class="form-group col-md-4">                          
                        <input type="tel" class="form-control form-control-sm" id="k_voter_card" name="k_voter_card" placeholder="Voter Card" disabled>
                        <small id="k_voter_card" class="form-text text-muted">Voter Card </small>
                    </div> 
                    <div class="form-group col-md-4">                          
                        <input type="tel" class="form-control form-control-sm" id="k_pan_card" name="k_pan_card"  placeholder="Pan Card" disabled >
                        <small id="k_pan_card" class="form-text text-muted">Pan Card</small>
                    </div>                                             
                </div>  -->

            </div>

            <div class="col-md-3">
                <img src="../image/default_img.png" class="img-thumbnail rounded mx-auto d-block" id="karykarta_profile" name="karykarta_profile" >
            </div>
        </div> 


        <!-- work detail -->
        <div class="row">
            <div class="col-md-12">                
                    <div class="row border border-dark p-3">
                        <div class="col-12">                            
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary">
                                Total Work : <span id="total_work" class="badge badge-light"></span>
                            </button>  
                            <a href="../worklist/workList.php" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-sm btn-info">
                                Assign New Work For this Karykarta <i class="far fa-plus-square"></i>
                            </button>                           </a> 
            
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
    <script src="../js/bootstrap.js"></script>  
    <script src="../datatable/dataTables.js"></script>
    <script src="karykartaDetail.js"></script> 
    
</body>
</html>