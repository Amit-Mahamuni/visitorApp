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
    <title>Address List</title>
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
                <a class="nav-link" href="#">Address List</a>
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

                <button type="button" class="btn btn-primary btn-sm" id="add_address_btn" data-toggle="modal" data-target="#exampleModal">
                    Add Address <i class="fa fa-plus"></i>
                </button>

            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-secondary p-2">
            <div class="col-12 my-4  p-2">
                <table id="address_datatable" class="table table-sm table-bordered table-hover table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="25%">Address</th>
                            <th width="10%">Pincode</th>
                            <th width="10%">Type</th>
                            <th width="20%">Goverment</th>
                            <th width="15%">Detail</th>
                            <th width="15%">Action</th>
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
                        <select id="address_type_f" name="address_type_f" class="form-control form-control-sm" data-live-search="true" required>
                            <option selected>All</option>
                            <?php
                                require_once "config.php";
                                $addressType = "";
                                $query_d = "SELECT `ADD_Type` FROM `address_detail` WHERE `ADD_Type` != '' GROUP BY `ADD_Type` ORDER BY `ADD_Type` ASC";
                                $result_d = $con->query($query_d);
                                while($row_d = mysqli_fetch_array($result_d))
                                {
                                    $addressType .='<option value="'.$row_d["ADD_Type"].'">'.$row_d["ADD_Type"].'</option>';

                                }
                                echo $addressType;
                            ?>
                        </select>
                        <small id="address_type_f" class="form-text text-muted">Type</small>
                    </div>
                    <div class="form-group col-md-6">
                      <select id="address_gov_f" name="address_gov_f" class="form-control form-control-sm" data-live-search="true" required>
                          <option selected>All</option>
                          <?php
                              // require_once "config.php";
                              $govermenttype = "";
                              $query_gov = "SELECT `ADD_Gov` FROM `address_detail` WHERE `ADD_Gov` != '' GROUP BY `ADD_Gov` ORDER BY `ADD_Gov` ASC";
                              $result_gov = $con->query($query_gov);
                              while($row_d = mysqli_fetch_array($result_gov))
                              {
                                  $govermenttype .='<option value="'.$row_d["ADD_Gov"].'">'.$row_d["ADD_Gov"].'</option>';
                              }
                              echo $govermenttype;
                          ?>
                      </select>
                      <small id="address_gov_f" class="form-text text-muted">Goverment</small>
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

    <!-- Update Address Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Address Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_address_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_up"></div>
                        <div id="update_div">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 id="address_id_txt"></h5>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control form-control-sm" id="address_Id_up" name="address_Id_up">
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-12">
                                        <input type="text" class="form-control form-control-sm" id="address_up" name="address_up" placeholder="Address" >
                                        <small id="address_up" class="form-text text-muted">Address</small>
                                      </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="address_type_up" name="address_type_up" class="form-control form-control-sm" >
                                            <option value="">Select</option>
                                            <?php echo $addressType; ?>
                                          </select>
                                          <small id="address_type_up" class="form-text text-muted">Type</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <input type="text" class="form-control form-control-sm" id="address_pincode_up" name="address_pincode_up" maxlength="6" minlength="6"  pattern="[0-9]{6}">
                                          <small id="address_pincode_up" class="form-text text-muted">Pincode</small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-12">
                                        <select id="address_gov_up" name="address_gov_up" class="form-control form-control-sm" >
                                          <option value="">Select</option>
                                          <?php  echo $govermenttype;   ?>
                                        </select>
                                        <small id="address_gov_up" class="form-text text-muted">Goverment</small>
                                      </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="form-group col-md-12">
                                        <input type="text" class="form-control form-control-sm" id="address_detail_up" name="address_detail_up" placeholder="Detail" >
                                        <small id="address_detail_up" class="form-text text-muted">Detail</small>
                                      </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="updateBtn" class="btn btn-sm btn-primary">Update changes</button>
                    </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Address Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_address_frm" >
                    <div class="modal-body p-4">
                        <div id="messages"></div>
                        <div id="add_address_div">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Address" >
                                      <small id="address" class="form-text text-muted">Address</small>
                                    </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <select id="address_type" name="address_type" class="form-control form-control-sm" >
                                          <option value="">Select</option>
                                          <?php echo $addressType; ?>
                                        </select>
                                        <small id="address_type" class="form-text text-muted">Type</small>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="address_pincode" name="address_pincode" maxlength="6" minlength="6" pattern="[0-9]{6}">
                                        <small id="address_pincode" class="form-text text-muted">Pincode</small>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <select id="address_gov" name="address_gov" class="form-control form-control-sm" >
                                        <option value="">Select</option>
                                        <?php   echo $govermenttype;     ?>
                                      </select>
                                      <small id="address_gov" class="form-text text-muted">Goverment</small>
                                    </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <input type="text" class="form-control form-control-sm" id="address_detail" name="address_detail" placeholder="Detail" >
                                      <small id="address_detail" class="form-text text-muted">Detail</small>
                                    </div>
                                  </div>

                              </div>
                          </div>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addBtn" class="btn btn-sm btn-primary">Add Connector</button>
                    </div>
            </form>
        </div>
        </div>
    </div>

    <!-- remove modal -->
    <div class="modal" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Remove Address !</h5>
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
    <script src="addressList.js"></script>

</body>
</html>
