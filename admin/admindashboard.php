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
    <title>Admin Dashboard</title>
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
                <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../addVisitor/addvisitor.php">Add Visitor </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                List
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../visitorList/visitorList.php">Visitor List</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../karykarta/karykarta.php">Karykarta List </a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../user/user.php">User List </a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../adhikari/adhikari.php">Adhikari List</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../connector/connector.php">Connector List</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../worklist/workList.php">All Work List</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../addressList/addressList.php">Address List</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../visitorWork\visitorworkList.php">Visitor Work List</a>
                </div>
            </li>

            <li class="nav-item ">
                <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../letter/dashboard.php">Letter Format</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Department
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../government/government.php">Government</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../education/education.php">Personal</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../invitation/invitation.php">Invitation</a>
                    <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../job/job.php">Job</a>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" target="_blank" rel="noopener noreferrer" href="../proposal/proposal.php">Proposal</a>
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

<div class="container bg-white p-3 my-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-primary m-1">
                Total Visitor : <span class="badge badge-light" id="total_visitor"></span>
            </button>
            <button type="button" class="btn btn-sm btn-primary m-1">
                Today Visitor : <span class="badge badge-light" id="today_visitor"></span>
            </button>
            <button type="button" class="btn btn-sm btn-info m-1">
                Total Voter Visitor : <span class="badge badge-light" id="total_voter"></span>
            </button>
        </div>
    </div>

    <!-- Dashboard -->
    <div class="row">
      <div class="col-md-6">
        <div id="accordion" class="my-2">
            <div class="card">
              <div class="card-header py-0 border border-top-0 border-bottom-0  border-right-0 border-primary" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h5>Work Details </h5>
                  </button>
                </h5>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body p-4">
                    <div class="row justify-content-between">
                        <h5 class="ml-md-2">Detail</h5>
                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
                    </div>

                    <hr>
                    <h6>Total Work : <span id="total_work"></span></h6>

                    <div class="row">
                        <div class="col-md-12 table table-reponsive">
                            <table id="today_work_detail" class="table table-bordered table-hover table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Total</th>
                                        <th>Complete</th>
                                        <th>Pending</th>
                                        <th>Under Process</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Government</td>
                                        <td id="gov_total"></td>
                                        <td id="gov_c_total"></td>
                                        <td id="gov_p_total"></td>
                                        <td id="gov_up_total"></td>
                                    </tr>
                                    <tr>
                                        <td>Personal</td>
                                        <td id="per_total"></td>
                                        <td id="per_c_total"></td>
                                        <td id="per_p_total"></td>
                                        <td id="per_up_total"></td>
                                    </tr>
                                    <tr>
                                        <td>Invitation</td>
                                        <td id="inv_total"></td>
                                        <td id="inv_c_total"></td>
                                        <td id="inv_p_total"></td>
                                        <td id="inv_up_total"></td>
                                    </tr>
                                    <tr>
                                        <td>Job</td>
                                        <td id="job_total"></td>
                                        <td id="job_c_total"></td>
                                        <td id="job_p_total"></td>
                                        <td id="job_up_total"></td>
                                    </tr>
                                    <tr>
                                        <td>Other</td>
                                        <td id="oth_total"></td>
                                        <td id="oth_c_total"></td>
                                        <td id="oth_p_total"></td>
                                        <td id="oth_up_total"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
              </div>
            </div>

        </div>
      </div>

      <div class="col-md-6">
            <div id="accordion" class="my-1">
              <div class="card">
                <div class="card-header py-0 border border-top-0 border-bottom-0  border-right-0 border-primary" id="headingOne">
                    <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#user_Log" aria-expanded="true" aria-controls="user_Log">
                        <h5>User Recent Log </h5>
                    </button>
                    </h5>
                </div>
                <div id="user_Log" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 table table-reponsive small">
                                <table id="user_log_table" class="table table-bordered table-hover table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Comment</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

    </div>



</div>


  <!-- work filter Modal -->
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
                    <button type="button"  id="filter_fun" class="btn btn-sm btn-primary">Filter</button>
                    <button type="button"  id="clear_filter" class="btn btn-sm btn-danger">Clear</button>
                </div>
            </form>
      </div>
    </div>
  </div>



    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="admindashboard.js"></script>

</body>
</html>
