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
    <title>Karykarta List</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../datatable/dataTables.bootstrap4.css">
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
                <a class="nav-link" href="../karykarta/karykarta.php">Karykarta List </a>
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

        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">

        <div class="row">
            <div class="col-md-6 my-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" id="add_karykarta_btn" data-toggle="modal" data-target="#exampleModal">
                    Add Karykarta <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-secondary p-2">
            <div class="col-12">

                <div class="table table-reponsive table-bordered my-4  p-2">
                    <table id="Karykarta_datatable" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Id</th>
                                <th width="25%">Name</th>
                                <th width="10%">Contact</th>
                                <th width="10%">Detail</th>
                                <th width="15%">Address</th>
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
                        <select id="work_category_f" name="work_category_f" class="form-control form-control-sm">
                            <option selected>All</option>
                            <option>Government</option>
                            <option>Personal</option>
                            <option>Invitation</option>
                            <option>Job</option>
                            <option>Other</option>
                        </select>
                        <small id="work_category_f" class="form-text text-muted">Category</small>
                    </div>
                    <div class="form-group col-md-6">
                        <select id="karykarta_status_f" name="karykarta_status_f" class="form-control form-control-sm">
                            <option selected>All</option>
                            <option value="Active">Active</option>
                            <option value="In-Active">In Active</option>
                        </select>
                        <small id="karykarta_status_f" class="form-text text-muted"> Status</small>
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

    <!-- Update Karykarta Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Karykarta Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_karykarta_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_up"></div>
                        <div id="update_div">
                          <div class="row" >
                              <div class="col-md-8">
                                  <div class="form-group">
                                      <input type="hidden" class="form-control form-control-sm" id="karykarta_Id_up" name="karykarta_Id" placeholder="Id" >
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <select id="karykarta_department_up" name="karykarta_department" class="form-control form-control-sm" >
                                              <option selected>Government</option>
                                              <option>Personal</option>
                                              <option>Invitation</option>
                                              <option>Job</option>
                                              <option>Other</option>
                                          </select>
                                          <small id="karykarta_department_up" class="form-text text-muted">Department</small>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <select id="karykarta_status_up" name="karykarta_status" class="form-control form-control-sm" >
                                              <option selected>Active</option>
                                              <option>In-Active</option>
                                              <option>Other</option>
                                          </select>
                                          <small id="karykarta_status_up" class="form-text text-muted">Status</small>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                  <input type="text" class="form-control form-control-sm" id="karykarta_name_up" name="karykarta_name" placeholder="Name" >
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <input type="tel" class="form-control form-control-sm" id="karykarta_phone_up" name="karykarta_phone" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Phone" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <input type="email" class="form-control form-control-sm" id="karykarta_email_up" name="karykarta_email" placeholder="Email" >
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <select id="karykarta_gender_up" name="karykarta_gender" class="form-control form-control-sm" >
                                              <option selected>Male</option>
                                              <option>Female</option>
                                              <option>Other</option>
                                          </select>
                                          <small id="karykarta_gender" class="form-text text-muted">Gender</small>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <input type="date" class="form-control form-control-sm" id="karykarta_dob_up" name="karykarta_dob" placeholder="DOB" aria-describedby="karykarta_dob" >
                                          <small id="karykarta_dob" class="form-text text-muted">Date of Birth</small>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <input type="text" class="form-control form-control-sm" id="karykarta_address_up" name="karykarta_address" placeholder="Address | e.g. Apartment, studio, or floor" >
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <select id="karykarta_city_up" name="karykarta_city_up" class="form-control form-control-sm">
                                          <option value="">Select</option>
                                        </select>
                                        <small id="karykarta_city_up" class="form-text text-muted">City</small>

                                      </div>
                                      <div class="form-group col-md-6">
                                      <input type="text" class="form-control form-control-sm" id="karykarta_pincode_up" name="karykarta_pincode" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group ">
                                      <img src="../image/default_img.png" id="karykarta_img_pre_up" class="img-thumbnail m-2">
                                      <div class="form-group">
                                          <input type="file" id="karykarta_profile_up" name="karykarta_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="updateKaryBtn" class="btn btn-sm btn-primary">Update changes</button>
                    </div>
            </form>
        </div>
        </div>
    </div>


    <!-- Add Karykarta Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Karykarta Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_karykarta_frm" >
                    <div class="modal-body p-4">
                        <div id="messages"></div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <select id="karykarta_department" name="karykarta_department" class="form-control form-control-sm" >
                                            <option selected>Government</option>
                                            <option>Personal</option>
                                            <option>Invitation</option>
                                            <option>Job</option>
                                            <option>Other</option>
                                        </select>
                                        <small id="karykarta_department" class="form-text text-muted">Department</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select id="karykarta_status" name="karykarta_status" class="form-control form-control-sm" >
                                            <option selected>Active</option>
                                            <option>In-Active</option>
                                            <option>Other</option>
                                        </select>
                                        <small id="karykarta_status" class="form-text text-muted">Status</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="karykarta_name" name="karykarta_name" placeholder="Name" >
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="tel" class="form-control form-control-sm" id="karykarta_phone" name="karykarta_phone" placeholder="Phone" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" class="form-control form-control-sm" id="karykarta_email" name="karykarta_email" placeholder="Email" >
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <select id="karykarta_gender" name="karykarta_gender" class="form-control form-control-sm" >
                                            <option selected>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                        <small id="karykarta_gender" class="form-text text-muted">Gender</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="date" class="form-control form-control-sm" id="karykarta_dob" name="karykarta_dob" placeholder="DOB" aria-describedby="karykarta_dob" >
                                        <small id="karykarta_dob" class="form-text text-muted">Date of Birth</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="karykarta_address" name="karykarta_address" placeholder="Address | e.g. Apartment, studio, or floor" >
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <select id="karykarta_city" name="karykarta_city" class="form-control form-control-sm">
                                        <option value="">Select</option>
                                      </select>
                                      <small id="karykarta_city" class="form-text text-muted">City</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <input type="text" class="form-control form-control-sm" id="karykarta_pincode" name="karykarta_pincode" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}" required>
                                    </div>
                                </div>

                                <h6>Login Detail</h6>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="User Name" minlength="5" maxlength="10" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="user_password" name="user_password" placeholder="Password" minlength="5" maxlength="10" required>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <img src="../image/default_img.png" id="karykarta_img_pre" class="img-thumbnail m-2">
                                    <div class="form-group">
                                        <input type="file" id="karykarta_profile" name="karykarta_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Add Karykarta</button>
                    </div>
            </form>
        </div>
        </div>
    </div>



    <!-- remove modal -->
    <div class="modal" tabindex="-1" role="dialog" id="removeMemberModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Karykarta Remove !</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p id="remove_Paragraph"><strong>Do You Really Want to Delete ?</strong><br>
                    This Process is not Undo...!
                </p>
                <div id="removeMsg"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" id="rmKaryModelBtn" data-dismiss="modal">No</button>
              <button type="button" id="rmoveBtn" class="btn btn-primary btn-sm">Yes</button>
            </div>
          </div>
        </div>
    </div>
    <!-- /remove modal -->


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="karykarta_script.js"></script>



</body>
</html>
