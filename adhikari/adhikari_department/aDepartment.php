<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin")
{

}else {
    header("location:../../login/logout.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adhikari Department</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../datatable/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../datatable/dataTables.all.css"/>
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
                <a class="nav-link" href="#">Adhikari Department </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../adhikari.php">Adhikari List </a>
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

    <div class="container bg-white my-4">

        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">

        <div class="row">
            <div class="col-md-6 my-2">
            </div>
            <div class="col-md-6 my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" id="add_department_btn" data-target="#add_department_Modal">Add Department</button>
                <button type="button" class="btn btn-sm btn-primary mx-2"  data-toggle="modal" id="add_occupation_btn" data-target="#add_occupation_Modal">Add Occupation</button>
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-secondary p-2">
            <div class="col-12">

                <div class="table table-reponsive table-bordered my-4 table-hover p-2">
                    <table id="department_datatable" class="table table-bordered table-sm table-reponsive">
                        <thead>
                            <tr>
                                <th width="5%">Id</th>
                                <th width="30%">Department</th>
                                <th width="25%">Occupation</th>
                                <th width="25%">Area</th>
                                <th width="15%">Action</th>
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
                    <div class="form-group col-md-12">
                        <select id="adhikari_department_f" name="adhikari_department_f" class="form-control form-control-sm" required>
                            <option selected>All</option>
                            <?php
                                require_once "../config.php";
                                $department = "";
                                $query_d = "SELECT `ADE_Department` FROM `adhikari_department` GROUP BY `ADE_Department` ORDER BY `ADE_Department` ASC";
                                $result_d = $con->query($query_d);
                                while($row_d = mysqli_fetch_array($result_d))
                                {
                                    $department .='<option value="'.$row_d["ADE_Department"].'">'.$row_d["ADE_Department"].'</option>';
                                }
                                echo $department;
                            ?>
                        </select>
                        <small id="adhikari_department_f" class="form-text text-muted">Department</small>
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


    <!-- Add Department Modal -->
    <div class="modal fade" id="add_department_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_department_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_department"></div>
                        <div id="add_department_div">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="department_name" name="department_name" placeholder="Department Name" required>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                            <select id="address_name" name="address_name" class="form-control form-control-sm" >
                                                <?php
                                                    //index.php

                                                    $address = "<option value='' selected>Select</option>";
                                                    $query = "SELECT `ADD_Id`, `ADD_Address` FROM `address_detail` GROUP BY `ADD_Address` ORDER BY `ADD_Address` ASC";
                                                    $result = $con->query($query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        $address .='<option value="'.$row["ADD_Id"].'">'.$row["ADD_Address"].'</option>';
                                                    }
                                                    echo $address;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea id="department_detail" name="department_detail" class="form-control form-control-sm" cols="30" rows="2" placeholder="Department Detail"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addDepBtn" class="btn btn-sm btn-primary">Add Department</button>
                    </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Add Occupation Modal -->
    <div class="modal fade" id="add_occupation_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Occupation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_occupation_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_occupation"></div>
                        <div id="add_occ_div">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="occupation_name" name="occupation_name" placeholder="Occupation Name" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select id="department" name="department_occ" class="form-control form-control-sm" >
                                              <option value="">Select</option>
                                                <?php  echo $department;   ?>
                                            </select>
                                            <small id="department" class="form-text text-muted">Department</small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select id="address_name_occ" name="address_name_occ" class="form-control form-control-sm" >
                                                <?php  echo $address; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea id="occupation_detail" name="occupation_detail" class="form-control form-control-sm" cols="30" rows="2" placeholder="Occupation Detail"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addOccBtn" class="btn btn-sm btn-primary">Add Occupation</button>
                    </div>
            </form>
        </div>
        </div>
    </div>

    <!-- remove modal -->
    <div class="modal" tabindex="-1" role="dialog" id="removeDepartmentModal">
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

    <!-- update Modal -->
    <div class="modal fade" id="update_department_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_department_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_up"></div>
                        <div id="add_update_div">
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" class="form-control form-control-sm" id="department_up_id" name="department_up_id">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="department_up" name="department_up" placeholder="Department" disabled>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="occupation_up" name="occupation_up" placeholder="Occupation" disabled>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="department_add_txt" name="department_add_txt" placeholder="department old add " disabled>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select id="address_name_up" name="address_name_up" class="form-control form-control-sm" require>
                                            <?php  echo $address; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea id="department_detail_up" name="department_detail_up" class="form-control form-control-sm" cols="30" rows="2" placeholder="Department Detail"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="updateDepBtn" class="btn btn-sm btn-primary">Update Department</button>
                    </div>
            </form>
        </div>
        </div>
    </div>


    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script type="text/javascript" src="../../datatable/dataTables.all.js"></script>
    <script src="aDepartment.js"></script>

</body>
</html>
