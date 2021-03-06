<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Invitation" || $_SESSION['Department'] == "Admin")
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
    <title>Invitation List</title>
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
                <a class="nav-link" href="../invitation/invitation.html">Invitation</a>
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

    <!-- Wedding List -->
    <div class="container bg-white my-4">
        <div class="row">
            <div class="col-md-6 my-2">
                <button type="button" class="btn btn-sm btn-primary">
                    Notifications : Today Invitation <span  id="today_total_work" class="badge badge-light"></span>
                </button>
            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>
        <div class="row border border-secondary p-3">
            <div class="col-12">

                <div class="table table-reponsive table-bordered my-4 table-hover p-3">
                    <table id="wedding_datatable" class="table table-border table-reponsive">
                        <thead>
                            <tr>
                                <th width="5%">Id</th>
                                <th width="25%">Title</th>
                                <th width="25%">Address</th>
                                <th width="10%">Type</th>
                                <th width="15%">Date</th>
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
                                <select id="work_priority_f" name="work_priority_f" class="form-control form-control-sm">
                                    <option selected>All</option>
                                    <option >Low</option>
                                    <option>Normal</option>
                                    <option>High</option>
                                </select>
                                <small id="work_priority_f" class="form-text text-muted">Work Priority</small>
                            </div>
                            <div class="form-group col-md-6">
                                <select id="work_status_f" name="work_status_f" class="form-control form-control-sm">
                                    <option selected>All</option>
                                    <option value="Unknow">Unknow</option>
                                    <option value="Possible">Possible</option>
                                    <option value="Not Possible">Not Possible</option>
                                </select>
                                <small id="work_status_f" class="form-text text-muted">Work Status</small>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <select id="work_category_f" name="work_category_f" class="form-control form-control-sm">
                                    <option selected>All</option>
                                    <option value='Wedding'>Wedding</option>
                                    <option value='Opening'>Opening</option>
                                    <option value='Dashkriya'>Dashkriya</option>
                                    <option value='Other'>Other</option>
                                </select>
                                <small id="work_category_f" class="form-text text-muted">Invitation Category</small>
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
    <div class="modal fade" id="InvitationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invitation Detail : <span id="Invitation_id_txt"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="invitation_frm">
                    <div class="modal-body p-4">
                        <div id="messages"></div>
                        <div id="from_data">
                            <div class="form-row">
                                <div class="form-group col-md-8">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" class="form-control form-control-sm" id="i_id" name="i_id">
                                            <input type='text' class='form-control form-control-sm' id='invitation_type_txt'  placeholder='Invitation Title' disabled>
                                            <small id='invitation_type' class='form-text text-muted'>Invitation Type</small>
                                            <input type='hidden' class='form-control form-control-sm' id='invitation_type' name='invitation_type' placeholder='Invitation Title'>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                            <input type="hidden" class="form-control form-control-sm" id="v_id" name="v_id">
                                            <input type="hidden" class="form-control form-control-sm" id="w_id" name="w_id">

                                            <select id="invitation_status" name="invitation_status" class="form-control form-control-sm" required>
                                                <option value="Unknow">Unknow</option>
                                                <option value="Possible">Possible</option>
                                                <option value="Not Possible">Not Possible</option>
                                            </select>
                                            <small id="invitation_status" class="form-text text-muted">Invitation Status</small>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Invitation Title' required>
                                        <small id='invitation_title' class='form-text text-muted'>Invitation Title</small>
                                    </div>

                                    <div id="wedding_info">
                                        <div class="form-group">
                                            <input type='text' class='form-control form-control-sm' id='Wedding_Boy_Name' name='Wedding_Boy_Name' placeholder='Wedding Boy Name' disabled>
                                            <small id='Wedding_Boy_Name' class='form-text text-muted'>Wedding Boy Name | First , Middle , Last </small>
                                        </div>

                                        <div>
                                            <h6>AND</h6>
                                        </div>

                                        <div class="form-group">
                                            <input type='text' class='form-control form-control-sm' id='Wedding_Girl_Name' name='Wedding_Girl_Name' placeholder='Wedding Boy Name' disabled>
                                            <small id='Wedding_Girl_Name' class='form-text text-muted'>Wedding Girl Name | First , Middle , Last </small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>
                                            <small id='invitation_date' class='form-text text-muted'>Date</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>
                                            <small id='invitation_time' class='form-text text-muted'>Time</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" id="invitation_address" name="invitation_address" placeholder="Address | Street, Village/City, Pincode" required>
                                        <small id='invitation_address' class='form-text text-muted'>Invitation Address | Format - Street, Village/City, Pincode</small>
                                    </div>

                                </div>
                                <div class="form-group col-md-4">
                                    <img src="../image/default_img.png" id="invitation_img_pre" class="img-thumbnail m-2">
                                    <div class="form-group">
                                        <input type="file" id="invitation_profile" name="invitation_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
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
    <script src="weddingList.js"></script>

</body>
</html>
