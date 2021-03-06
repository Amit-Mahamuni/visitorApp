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
    <title>Adhikari List</title>
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
                <a class="nav-link" href="#">Adhikari List </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../adhikari/adhikari_department/aDepartment.php">Adhikari Department </a>
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

                <button type="button" class="btn btn-primary btn-sm" id="add_adhikari_btn" data-toggle="modal" data-target="#exampleModal">
                    Add Adhikari <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="col-md-6  my-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#exampleModal1">filter</button>
            </div>
        </div>

        <div class="row border border-secondary p-2">
            <div class="col-12 my-4  p-2">

                <table id="adhikari_datatable" class="table table-sm table-bordered table-hover table-reponsive">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="30%">Name</th>
                            <th width="20%">Department</th>
                            <th width="15%">Contact</th>
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
                        <select id="adhikari_department_f" name="adhikari_department_f" class="form-control form-control-sm" required>
                            <option selected>All</option>
                            <!-- <option>Forest Officer</option>
                            <option>Collector</option>
                            <option>Mining Officer</option>
                            <option>District Informatics Officer</option>
                            <option>Tahsildar, Revenue Branch</option> -->
                            <?php
                                require_once "config.php";
                                $department = "<option value='' selected>Select</option>";
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

    <!-- Update Adhikari Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Adhikari Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update_adhikari_frm" >
                    <div class="modal-body p-4">
                        <div id="messages_up"></div>
                        <div id="update_div">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control form-control-sm" id="adhikari_Id_up" name="adhikari_Id_up" placeholder="Id" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <h5 id="adhikari_id_txt"></h5>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_status_up" name="adhikari_status_up" class="form-control form-control-sm" >
                                                <option selected>Active</option>
                                                <option>In-Active</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="adhikari_status_up" class="form-text text-muted">Status</small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="adhikari_dep_occ" name="adhikari_dep_occ" placeholder="Department | Ocuupation" disabled>
                                            <small id="adhikari_dep_occ" class="form-text text-muted">Department | Ocuupation </small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_department_up" name="adhikari_department_up" class="form-control form-control-sm" >
                                            <?php echo $department; ?>
                                            </select>
                                            <small id="adhikari_department_up" class="form-text text-muted">Department</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <!-- <input type="text" class="form-control form-control-sm" id="adhikari_occupation_up" name="adhikari_occupation_up" placeholder="Occupation" required>   -->
                                            <select id="adhikari_occupation_up" name="adhikari_occupation_up" class="form-control form-control-sm" >
                                            </select>
                                            <small id="adhikari_occupation_up" class="form-text text-muted">Occupation</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="adhikari_name_up" name="adhikari_name_up" placeholder="Name" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="tel" class="form-control form-control-sm" id="adhikari_phone_up" name="adhikari_phone_up" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Phone" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control form-control-sm" id="adhikari_email_up" name="adhikari_email_up" placeholder="Email" >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_gender_up" name="adhikari_gender_up" class="form-control form-control-sm" >
                                                <option selected>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="adhikari_gender_up" class="form-text text-muted">Gender</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="date" class="form-control form-control-sm" id="adhikari_dob_up" name="adhikari_dob_up" placeholder="DOB" aria-describedby="karykarta_dob" >
                                            <small id="adhikari_dob_up" class="form-text text-muted">Date of Birth</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" id="adhikari_address_up" name="adhikari_address_up" placeholder="Address | e.g. Apartment, studio, or floor" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_city_up" name="adhikari_city_up" class="form-control form-control-sm" >
                                                <option selected>Adavi</option>
                                                <option>Adhale Budruk</option>
                                                <option>Adhale Khurd</option>
                                                <option>Adhe Khurd</option>
                                                <option>Ahirvade</option>
                                                <option>Ajivali</option>
                                                <option>Akurdi</option>
                                                <option>Ambale</option>
                                                <option>Ambegaon</option>
                                                <option>Ambi</option>
                                                <option>Apati</option>
                                                <option>Atvan</option>
                                                <option>Aundhe Khurd</option>
                                                <option>Aundholi</option>
                                                <option>Badhalawadi</option>
                                                <option>Baur</option>
                                                <option>Bebad Ohol</option>
                                                <option>Bedse</option>
                                                <option>Belaj</option>
                                                <option>Bhadawali</option>
                                                <option>Bhaje</option>
                                                <option>Bhajgaon</option>
                                                <option>Bhoyare</option>
                                                <option>Boraj</option>
                                                <option>Borivali</option>
                                                <option>Brahmanoli</option>
                                                <option>Brahman Wadi</option>
                                                <option>Brahmanwadi</option>
                                                <option>Budhavadi</option>
                                                <option>Chandkhed</option>
                                                <option>Chavsar</option>
                                                <option>Chikhalse</option>
                                                <option>Dahivali</option>
                                                <option>Dahuli</option>
                                                <option>Darumbare</option>
                                                <option>Devale</option>
                                                <option>Devghar</option>
                                                <option>Dhalewadi</option>
                                                <option>Dhamane</option>
                                                <option>Dhangavhan</option>
                                                <option>Divad</option>
                                                <option>Done</option>
                                                <option>Dongargaon</option>
                                                <option>Dudhivare</option>
                                                <option>Gahunje</option>
                                                <option>Gevhande Apati</option>
                                                <option>Gevhande Khadak</option>
                                                <option>Ghonshet</option>
                                                <option>Godumbare</option>
                                                <option>Govitri</option>
                                                <option>Induri</option>
                                                <option>Inglun</option>
                                                <option>Jadhavwadi</option>
                                                <option>Jambavade</option>
                                                <option>Jambhavali</option>
                                                <option>Jambhul</option>
                                                <option>Jovan</option>
                                                <option>Kacharewadi</option>
                                                <option>Kadadhe</option>
                                                <option>Kadav</option>
                                                <option>Kale</option>
                                                <option>Kalhat</option>
                                                <option>Kambare Andar Mawal</option>
                                                <option>Kambare Nane Mawal</option>
                                                <option>Kamshet</option>
                                                <option>Kanhe</option>
                                                <option>Karandoli</option>
                                                <option>Karanjgaon</option>
                                                <option>Karla</option>
                                                <option>Karunj</option>
                                                <option>Kashal</option>
                                                <option>Katavi</option>
                                                <option>Keware</option>
                                                <option>Khand</option>
                                                <option>Khandashi</option>
                                                <option>Kivale</option>
                                                <option>Kolechafesar</option>
                                                <option>Kondivade Andar Mawal</option>
                                                <option>Kondivade Nane Mawal</option>
                                                <option>Kothurne</option>
                                                <option>Kune Ansute</option>
                                                <option>Kune Nane Mawal</option>
                                                <option>Kurvande</option>
                                                <option>Kusavali</option>
                                                <option>Kusgaon Khurd</option>
                                                <option>Kusgaon Pawan Mawal</option>
                                                <option>Kusur</option>
                                                <option>Lohagad</option>
                                                <option>Mahagaon</option>
                                                <option>Majgaon</option>
                                                <option>Malavandi Thule</option>
                                                <option>Malawali Nane Mawal</option>
                                                <option>Malawali Pawan Mawal</option>
                                                <option>Malegaon Budruk</option>
                                                <option>Malegaon Khurd</option>
                                                <option>Malewadi</option>
                                                <option>Mangarul</option>
                                                <option>Mau</option>
                                                <option>Mendhewadi</option>
                                                <option>Mohitewadi</option>
                                                <option>Moramarwadi</option>
                                                <option>Morave</option>
                                                <option>Mundhavare</option>
                                                <option>Nagathali</option>
                                                <option>Nandgaon</option>
                                                <option>Nane</option>
                                                <option>Nanoli Nane Mawal</option>
                                                <option>Nanoli Tarf Chakan</option>
                                                <option>Navlakhumbre</option>
                                                <option>Nayagaon</option>
                                                <option>Nesave</option>
                                                <option>Nigade</option>
                                                <option>Ovale</option>
                                                <option>Ozarde</option>
                                                <option>Pachane</option>
                                                <option>Pale Nane Mawal</option>
                                                <option>Pangaloli</option>
                                                <option>Pansoli</option>
                                                <option>Parandvadi</option>
                                                <option>Paravadi</option>
                                                <option>Patan</option>
                                                <option>Pathargaon</option>
                                                <option>Pawalewadi</option>
                                                <option>Phalane</option>
                                                <option>Pimpal Khunte</option>
                                                <option>Pimpaloli</option>
                                                <option>Pimpari</option>
                                                <option>Prabhachiwadi</option>
                                                <option>Pusane</option>
                                                <option>Rajpuri</option>
                                                <option>Rakaswadi</option>
                                                <option>Sadapur</option>
                                                <option>Sadavali</option>
                                                <option>Sai</option>
                                                <option>Salumbare</option>
                                                <option>Sangavade</option>
                                                <option>Sangavi</option>
                                                <option>Sangise</option>
                                                <option>Sate</option>
                                                <option>Sawale</option>
                                                <option>Sawantwadi</option>
                                                <option>Shilatane</option>
                                                <option>Shilimb</option>
                                                <option>Shindgaon</option>
                                                <option>Shirdhe</option>
                                                <option>Shire</option>
                                                <option>Shirgaon</option>
                                                <option>Shivali</option>
                                                <option>Shivane</option>
                                                <option>Somatane</option>
                                                <option>Somavadi</option>
                                                <option>Sudhavadi</option>
                                                <option>Sudumbare</option>
                                                <option>Taje</option>
                                                <option>Takave Budruk</option>
                                                <option>Takave Khurd</option>
                                                <option>Talegaon Dabhade</option>
                                                <option>Thakursai</option>
                                                <option>Thoran</option>
                                                <option>Thugaon</option>
                                                <option>Tikona</option>
                                                <option>Tung</option>
                                                <option>Udhewadi</option>
                                                <option>Ukasan</option>
                                                <option>Umbare Navalakh</option>
                                                <option>Urse</option>
                                                <option>Vadavali</option>
                                                <option>Vadeshwar</option>
                                                <option>Vadivale</option>
                                                <option>Vagheshwar</option>
                                                <option>Valakh</option>
                                                <option>Valavanti</option>
                                                <option>Varale</option>
                                                <option>Varsoli</option>
                                                <option>Varu</option>
                                                <option>Vaund</option>
                                                <option>Vehergaon</option>
                                                <option>Velhavali</option>
                                                <option>Wahangaon</option>
                                                <option>Waksai</option>
                                                <option>Yelase</option>
                                                <option>Yelghol</option>
                                            </select>
                                            <small id="adhikari_city_up" class="form-text text-muted">City</small>

                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="adhikari_pincode_up" name="adhikari_pincode_up" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <a href="http://" id="adhikari_pro_href" target="_blank" rel="noopener noreferrer">
                                            <img src="../image/default_img.png" id="adhikari_img_pre_up" class="img-thumbnail m-2">
                                        </a>
                                        <div class="form-group">
                                            <input type="file" id="adhikari_profile_up" name="adhikari_profile_up" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="updateAdhBtn" class="btn btn-sm btn-primary">Update changes</button>
                    </div>
            </form>
        </div>
        </div>
    </div>


    <!-- Add Adhikari Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adhikari Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_adhikari_frm" >
                    <div class="modal-body p-4">
                        <div id="messages"></div>
                        <div id="add_adhikari_div">
                            <div class="row">
                                <div class="col-md-8">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_status" name="adhikari_status" class="form-control form-control-sm" >
                                                <option selected>Active</option>
                                                <option>In-Active</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_department" name="adhikari_department" class="form-control form-control-sm" required>
                                                <?php echo $department; ?>
                                            </select>
                                            <small id="adhikari_department" class="form-text text-muted">Department</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <!-- <input type="text" class="form-control form-control-sm" id="adhikari_occupation" name="adhikari_occupation" placeholder="Occupation" required>   -->
                                            <select id="adhikari_occupation" name="adhikari_occupation" class="form-control form-control-sm">
                                            </select>
                                            <small id="adhikari_occupation" class="form-text text-muted">Occupation</small>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control form-control-sm" id="adhikari_name" name="adhikari_name" placeholder="Name" required>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="tel" class="form-control form-control-sm" id="adhikari_phone" name="adhikari_phone" placeholder="Phone" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control form-control-sm" id="adhikari_email" name="adhikari_email" placeholder="Email" >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="adhikari_gender" name="adhikari_gender" class="form-control form-control-sm" >
                                                <option selected>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                            <small id="adhikari_gender" class="form-text text-muted">Gender</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="date" class="form-control form-control-sm" id="adhikari_dob" name="adhikari_dob" placeholder="DOB" aria-describedby="karykarta_dob" >
                                            <small id="adhikari_dob" class="form-text text-muted">Date of Birth</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" id="adhikari_address" name="adhikari_address" placeholder="Address | e.g. Apartment, studio, or floor" >
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <select id="adhikari_city" name="adhikari_city" class="form-control form-control-sm">
                                            <option value="">Select</option>
                                          </select>
                                          <small id="adhikari_city" class="form-text text-muted">City</small>

                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="adhikari_pincode" name="adhikari_pincode" placeholder="Pincode" minlength="6" maxlength="6" pattern="[0-9]{6}">
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <img src="../image/default_img.png" id="adhikari_img_pre" class="img-thumbnail m-2">
                                        <div class="form-group">
                                            <input type="file" id="adhikari_profile" name="adhikari_profile" class="m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Add Adhikari</button>
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
    <script src="adhikari.js"></script>

</body>
</html>
