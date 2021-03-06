<?php

session_start();

// if(!isset($_SESSION['U_Id']) && $_SESSION['Department'] != "Government")
// {
//  header("location:../login/logout.php");
// }

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin" || $_SESSION['Department'] == "Job")
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
    <title>Job</title>
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
                <a class="nav-link" href="../job/job.php">Job</a>
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

    <!-- job List -->
    <div class="container bg-white my-4">

        <div class="row">
            <div class="col-md-6 my-2">
                <button type="button" class="btn btn-sm btn-primary">
                    Notifications : Today Work <span  id="today_Job_work" class="badge badge-light"></span>
                </button>
            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-dark p-3">
            <div class="col-12">
                <div class="table table-reponsive my-4 p-3">
                    <table id="job_datatable" class="table table-hover table-sm table-bordered table-border">
                        <thead>
                            <tr>
                                <th width="5%">Id</th>
                                <th width="30%">Name</th>
                                <th width="20%">Qualification</th>
                                <th width="15%">Detail</th>
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
                            <select id="work_category_f" name="work_category_f" class="form-control form-control-sm">
                                <option selected>All</option>
                                <option value='Vacany'>Vacany</option>
                                <option value='Job Letter'>Job Letter</option>
                                <option value='Other'>Other</option>
                            </select>
                            <small id="work_category_f" class="form-text text-muted">Category</small>
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
    <div class="modal fade" id="JobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Job Detail : <span id="Job_id_txt"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="job_frm">
                <div class="modal-body p-4">
                    <div id="messages"></div>
                    <div id="from_data">
                        <div class="form-row">
                            <div class="form-group col-md-8">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" class="form-control form-control-sm" id="j_id" name="j_id">
                                        <input type='text' class='form-control form-control-sm' id='job_type' name="job_type"  placeholder='Job Type' disabled>
                                        <small id='job_type' class='form-text text-muted'>Job Type</small>
                                        <!-- <input type='hidden' class='form-control form-control-sm' id='invitation_type' name='invitation_type' placeholder='Invitation Title'>                                     -->
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                        <input type="hidden" class="form-control form-control-sm" id="v_id" name="v_id">
                                        <input type="hidden" class="form-control form-control-sm" id="w_id" name="w_id">
                                            <select id="work_status" name="work_status" class="form-control form-control-sm">
                                                <option value="Pending" selected>Pending</option>
                                                <option value="Complete">Complete</option>
                                                <option value="Under Process">Under Process</option>
                                            </select>
                                        <small id="work_status" class="form-text text-muted">Status</small>
                                    </div>

                                </div>

                                <div class='form-row'>
                                    <div class='form-group col-md-12'>
                                        <input type='text' class='form-control form-control-sm' id='job_name' name='job_name' placeholder='Name' >
                                        <small id='job_name' class='form-text text-muted'>Name</small>
                                    </div>
                                </div>
                                <div class='form-row'>
                                    <div class='form-group col-md-4'>
                                        <input type='date' class='form-control form-control-sm' id='job_dob' name='job_dob' >
                                        <small id='job_dob' class='form-text text-muted'>DOB</small>
                                    </div>
                                    <div class='form-group col-md-3'>
                                        <select id='job_gender' name='job_gender' class='form-control form-control-sm'>
                                            <option value='Male' selected>Male</option>
                                            <option value='Female'>Female</option>
                                            <option value='Other'>Other</option>
                                        </select><small id='job_gender' class='form-text text-muted'>Gender</small>
                                    </div>
                                    <div class='form-group col-md-5'>
                                        <select id='job_relation' name='job_relation' class='form-control form-control-sm'>
                                            <option value='Son/Daughter of Visitor' selected>Son/Daughter of Visitor</option>
                                            <option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>
                                            <option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>
                                            <option value='GrandParent of Visitor'>GrandParent of Visitor</option>
                                            <option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>
                                            <option value='Other'>Other</option>
                                        </select><small id='job_relation' class='form-text text-muted'> Related to Visitor</small>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-group col-md-6'>
                                        <input type='email' class='form-control form-control-sm' id='job_email' name='job_email' placeholder='Email'>
                                        <small id='job_email' class='form-text text-muted'>Email</small>
                                    </div>
                                    <div class='form-group col-md-6'>
                                        <input type='tel' class='form-control form-control-sm' id='job_phone' name='job_phone' minlength='10' maxlength='10' pattern='[0-9]{10}' placeholder='Phone' >
                                            <small id='job_phone' class='form-text text-muted'>Phone</small>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-group col-md-12'>
                                        <input type='text' class='form-control form-control-sm' id='job_qualification' name='job_qualification' placeholder='Qualification' >
                                        <small id='job_qualification' class='form-text text-muted'>Qualification | E.g. BE(Mech.)</small>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-group col-md-4'>
                                        <input type='number' class='form-control form-control-sm' id='job_exp' name='job_exp' placeholder='Experience'>
                                        <small id='job_exp' class='form-text text-muted'>Experiences | In Year</small>
                                    </div>
                                    <div class='form-group col-md-8'>
                                        <input type='text' class='form-control form-control-sm' id='job_company' name='job_company' placeholder='Last Company Name' >
                                            <small id='job_phone' class='form-text text-muted'>Last Company Name</small>
                                    </div>
                                </div>


                            </div>
                        <div class="form-group col-md-4">
                            <img src="../image/default_img.png" id="job_img_pre" class="img-thumbnail m-2">
                            <div class="form-group">
                                <input type="file" id="job_profile" name="job_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png .pdf">
                            </div>
                            <a href="#"  id="job_resume" class="btn btn-sm btn-primary"  target="_blank">Download Resume</a>
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
    <script src="job.js"></script>

</body>
</html>
