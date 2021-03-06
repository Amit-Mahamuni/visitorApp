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
    <title>Connector List</title>
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
                <a class="nav-link" href="#">Connector List</a>
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

        <div class="row">
            <div class="col-md-6 my-2">
                <!-- Button trigger modal -->

                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">

                <button type="button" class="btn btn-primary btn-sm" id="add_connector_btn" data-toggle="modal" data-target="#exampleModal">
                    Add Connector <i class="fa fa-plus"></i>
                </button>

                <button type="button" class="btn btn-primary btn-sm" id="add_connector_btn" data-toggle="modal" data-target="#connectorOccupation">
                    Add Connector Occupation<i class="fa fa-plus"></i>
                </button>

            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-secondary p-2">
            <div class="col-12 my-4  p-2">

                <table id="connector_datatable" class="table table-sm table-bordered table-hover table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="30%">Name</th>
                            <th width="20%">Contact</th>
                            <th width="15%">Occupation</th>
                            <th width="10%">Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                </table>

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
                        <select id="adhikari_occupation_f" name="adhikari_occupation_f" class="form-control form-control-sm" data-live-search="true" required>
                            <option selected>All</option>
                            <?php
                                require_once "config.php";
                                $occupation = "";
                                $query_d = "SELECT `CN_Id`, `CN_Occupation_mr`, `CN_Occupation_en` FROM `connector_occupation` GROUP BY `CN_Occupation_en` ORDER BY `CN_Occupation_en` ASC";
                                $result_d = $con->query($query_d);
                                while($row_d = mysqli_fetch_array($result_d))
                                {
                                    $occupation .='<option value="'.$row_d["CN_Occupation_en"].'">'.$row_d["CN_Occupation_mr"].' ( '.$row_d["CN_Occupation_en"].' ) </option>';

                                }
                                echo $occupation;
                            ?>
                        </select>
                        <small id="adhikari_occupation_f" class="form-text text-muted">Department</small>
                    </div>
                    <div class="form-group col-md-6">
                        <select id="adhikari_status_f" name="adhikari_status_f" class="form-control form-control-sm">
                            <option selected>All</option>
                            <option value="Active">Active</option>
                            <option value="In-Active">In Active</option>
                        </select>
                        <small id="adhikari_status_f" class="form-text text-muted"> Status</small>
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

    <!-- add Occupation Modal -->
    <div class="modal fade" id="connectorOccupation" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Occupation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body px-4 py-2">

            <!-- add Occupation form -->
            <div class="add_occupation_div">
              <form id="add_occupation_frm" class="my-3">
                <input type="hidden" name="occupation_id" id="occupation_id">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control form-control-sm" id="Occupation_name_mr" name="Occupation_name_mr" placeholder="Occupation in Marathi" required>
                        <small id="Occupation_name_mr" class="form-text text-muted">Occupation in Marathi</small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control form-control-sm" id="Occupation_name_en" name="Occupation_name_en" placeholder="Occupation in English" required>
                        <small id="Occupation_name_en" class="form-text text-muted">Occupation in English </small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                      <textarea name="Occupation_detail" id="Occupation_detail" class="form-control form-control-sm" rows="1" placeholder="Occupation Detail"></textarea>
                      <small id="Occupation_detail" class="form-text text-muted">Occupation Detail</small>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-sm btn-primary" id="add_occupation_btn">Add Occupation</button>
                    </div>
                </div>
              </form>
            </div>

            <div id="occupation_messages">
            </div>
            <hr>
            <!-- occupation list -->
            <div class="row small">
              <div class="col-md-12 table-responsive ">
                <table id="connectorOccupation_datatable" class="table table-sm table-bordered table-hover" style="width : 100%">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="50%">Occupation </th>
                            <!-- <th width="25%">Occupation (MR)</th> -->
                            <th width="30%">Occupation Details</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          </div>
    </div>
  </div>
</div>

    <!-- Update Connector Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Connector Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_connector_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_up"></div>
                        <div id="update_div">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 id="connector_id_txt"></h5>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control form-control-sm" id="connector_Id_up" name="connector_Id_up">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="connector_occupation_up" name="connector_occupation_up" class="form-control form-control-sm" >
                                            <option value = null selected>Select</option>
                                            <!-- <option value="Nothing">Select</option>
                                            <option value="Member of Panchayat Committee">Member of Panchayat Committee</option>
                                            <option value="Member of Gram Panchayat">Member of Gram Panchayat</option>
                                            <option value="Village servant">Village servant</option>
                                            <option value="District Council Member">District Council Member</option> -->
                                            <?php echo $occupation; ?>
                                          </select>
                                          <small id="connector_occupation_up" class="form-text text-muted">Occupation</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select id="connector_status_up" name="connector_status_up" class="form-control form-control-sm" >
                                                <option selected>Active</option>
                                                <option>In-Active</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="connector_status_up" class="form-text text-muted">Status</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="connector_name_up" name="connector_name_up" placeholder="Name" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="tel" class="form-control form-control-sm" id="connector_phone_up" name="connector_phone_up" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Phone" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control form-control-sm" id="connector_email_up" name="connector_email_up" placeholder="Email" >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="connector_gender_up" name="connector_gender_up" class="form-control form-control-sm" >
                                                <option selected>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="connector_gender_up" class="form-text text-muted">Gender</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="date" class="form-control form-control-sm" id="connector_dob_up" name="connector_dob_up" placeholder="DOB">
                                            <small id="connector_dob_up" class="form-text text-muted">Date of Birth</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" id="connector_address_up" name="connector_address_up" placeholder="Address | e.g. Apartment, studio, or floor" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="connector_city_up" name="connector_city_up" class="form-control form-control-sm">
                                          </select>
                                          <small id="connector_city_up" class="form-text text-muted">City</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <input type="text" class="form-control form-control-sm" id="connector_pincode_up" name="connector_pincode_up" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <a href="http://" id="connector_pro_href" target="_blank" rel="noopener noreferrer">
                                            <img src="../image/default_img.png" id="connector_img_pre_up" class="img-thumbnail m-2">
                                        </a>
                                        <div class="form-group">
                                            <input type="file" id="connector_profile_up" name="connector_profile_up" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="updateConnBtn" class="btn btn-sm btn-primary">Update changes</button>
                    </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Add connector Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Connector Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_connector_frm" >
                    <div class="modal-body p-4">
                        <div id="messages"></div>
                        <div id="add_connector_div">
                            <div class="row">
                                <div class="col-md-8">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="connector_occupation" name="connector_occupation" class="form-control form-control-sm" data-live-search="true">
                                             <option value="Nothing" data-tokens="Select">Select</option>
                                            <!--<option value="Member of Panchayat Committee">Member of Panchayat Committee</option>
                                            <option value="Member of Gram Panchayat">Member of Gram Panchayat</option>
                                            <option value="Village servant">Village servant</option>
                                            <option value="District Council Member">District Council Member</option> -->
                                            <?php echo $occupation; ?>
                                          </select>
                                          <small id="connector_occupation" class="form-text text-muted">Occupation</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select id="connector_status" name="connector_status" class="form-control form-control-sm" >
                                                <option selected>Active</option>
                                                <option>In-Active</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="connector_name" name="connector_name" placeholder="Name" required>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="tel" class="form-control form-control-sm" id="connector_phone" name="connector_phone" placeholder="Phone" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control form-control-sm" id="connector_email" name="connector_email" placeholder="Email" >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="connector_gender" name="connector_gender" class="form-control form-control-sm" >
                                                <option selected>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="connector_gender" class="form-text text-muted">Gender</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="date" class="form-control form-control-sm" id="connector_dob" name="connector_dob" placeholder="DOB"  >
                                            <small id="connector_dob" class="form-text text-muted">Date of Birth</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" id="connector_address" name="connector_address" placeholder="Address | e.g. Apartment, studio, or floor" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="connector_city" name="connector_city" class="form-control form-control-sm">
                                            <option value="">Select</option>
                                          </select>
                                          <small id="connector_city" class="form-text text-muted">City</small>

                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="connector_pincode" name="connector_pincode" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}">
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <img src="../image/default_img.png" id="connector_img_pre" class="img-thumbnail m-2">
                                        <div class="form-group">
                                            <input type="file" id="connector_profile" name="connector_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addConnBtn" class="btn btn-sm btn-primary">Add Connector</button>
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
                    This Process is not Reverse...!
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
    <script src="connector.js"></script>

</body>
</html>
