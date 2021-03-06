<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Admin" || $_SESSION['Department'] == "Reception")
{

}else {
    header("location:../login/logout.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor List</title>
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
                <a class="nav-link" href="../visitorList/visitorList.php">Visitor List</a>
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
    <div class="row p-3">
        <div class="col-md-6">
            <button type="button" class="btn btn-sm btn-primary">
                Notifications : Today Entry <span  id="total_entry" class="badge badge-light"></span>
              </button>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary my-auto"  data-toggle="modal" data-target="#exampleModal1">Filter</button>
        </div>
    </div>
    <div class="row border border-secondary p-1">
        <div class="col-md-12">

            <div class="table table-reponsive table-bordered my-4 p-3">
                <table id="visitor_datatable" class="table table-sm table-hover  ">
                    <thead>
                        <tr>
                            <th width="5%">Id</th>
                            <th width="20%">Name</th>
                            <th width="20%">Contact</th>
                            <th width="10%">Detail</th>
                            <th width="30%">Address</th>
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
                                <option>Low</option>
                                <option>Normal</option>
                                <option>High</option>
                            </select>
                            <small id="work_priority_f" class="form-text text-muted">Work Priority</small>
                        </div>
                        <div class="form-group col-md-6">
                            <select id="work_status_f" name="work_status_f" class="form-control form-control-sm">
                                <option selected>All</option>
                                <option value="Pending">Pending</option>
                                <option value="Complete">Complete</option>
                                <option value="Under Process">Under Process</option>
                            </select>
                            <small id="work_status_f" class="form-text text-muted">Work Status</small>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <select id="visitor_voter_f" name="visitor_voter_f" class="form-control form-control-sm" >
                                <option selected>All</option>
                                <option value="Unknown">Unknown</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <small id="visitor_voter_f" class="form-text text-muted">Voter</small>
                        </div>
                        <div class="form-group col-md-6">
                            <select id="visitor_gender_f" name="visitor_gender_f" class="form-control form-control-sm" aria-describedby="visitor_gender" required>
                                <option selected>All</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                            <small id="visitor_gender_f" class="form-text text-muted">Gender</small>
                        </div>

                    </div>

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
                        <div id="work_subcat_div" class="form-group col-md-6"></div>
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
                    <!-- <button type="submit" id="addKaryBtn" class="btn btn-sm btn-primary">Save changes</button> -->
                    <button type="button"  id="filter_fun" class="btn btn-sm btn-primary">Filter</button>
                    <button type="button"  id="clear_filter" class="btn btn-sm btn-danger">Clear</button>
                </div>
            </form>
      </div>
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="visitorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visitor Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="visitor_frm" >
                <div class="modal-body p-4">
                    <div id="messages"></div>
                    <div id="from_data">
                        <div class="form-row">
                            <div class="form-group col-md-8">

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <h6 id="visitor_id_txt"></h6>
                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                                        <input type="hidden" class="form-control form-control-sm" id="visitor_id" name="visitor_id">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <select id="visitor_type" name="visitor_type" class="form-control form-control-sm" required>
                                            <option value="By Walking" selected>By Walking</option>
                                            <option value="By Call">By Call</option>
                                        </select>
                                        <small id="visitor_type" class="form-text text-muted">Visitor Type</small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <select id="visitor_voter" name="visitor_voter" class="form-control form-control-sm" >
                                            <option value="Unknown" selected>Unknown</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <small id="visitor_voter" class="form-text text-muted">Voter</small>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="visitor_name" name="visitor_name" placeholder="Name" required>
                                    <small id="visitor_name" class="form-text text-muted">Visitor Name</small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="tel" class="form-control form-control-sm" id="visitor_phone" name="visitor_phone" placeholder="Phone" minlength="10" maxlength="10" pattern="[0-9]{10}"  required>
                                        <small id="visitor_phone" class="form-text text-muted">Visitor Phone</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" class="form-control form-control-sm" id="visitor_email" name="visitor_email" placeholder="Email" >
                                        <small id="visitor_email" class="form-text text-muted">Visitor Email</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <select id="visitor_gender" name="visitor_gender" class="form-control form-control-sm" aria-describedby="visitor_gender" required>
                                            <option selected>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                        <small id="visitor_gender" class="form-text text-muted">Gender</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="date" class="form-control form-control-sm" id="visitor_dob" name="visitor_dob" placeholder="DOB" aria-describedby="visitor_dob" >
                                        <small id="visitor_dob" class="form-text text-muted">Date of Birth</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="visitor_address" name="visitor_address" placeholder="Address | e.g. Apartment, studio, or floor" required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <select id="visitor_city" name="visitor_city" class="form-control form-control-sm" aria-describedby="visitor_city" required>
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
                                        <small id="visitor_city" class="form-text text-muted">City</small>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control form-control-sm" id="visitor_pincode" name="visitor_pincode" placeholder="Pincode" required>
                                        <small id="visitor_pincode" class="form-text text-muted">Pincode </small>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group col-md-4">
                                <img src="../image/default_img.png" id="visitor_img_pre" class="img-thumbnail m-2">
                                <div class="form-group">
                                    <input type="file" id="visitor_profile" name="visitor_profile" class=" m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">
                                    <!-- <input type="file" id="visitor_profile" name="visitor_profile" class=" m-2 pb-5 form-control form-control-sm"  accept=".jpg, .jpeg, .png">                        -->
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control form-control-sm" id="v_adhar_card" minlength="12" maxlength="12" name="v_adhar_card" pattern="[0-9]{12}" placeholder="Adhar Card" >
                                <small id="v_adhar_card" class="form-text text-muted">Adhar Card </small>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="tel" class="form-control form-control-sm" id="v_voter_card" name="v_voter_card"  placeholder="Voter Card" >
                                <small id="v_voter_card" class="form-text text-muted">Voter Card </small>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="tel" class="form-control form-control-sm" id="v_pan_card" name="v_pan_card"  placeholder="Pan Card" >
                                <small id="v_pan_card" class="form-text text-muted">Pan Card</small>
                            </div>
                        </div>

                        <hr>
                        <input type="hidden" class="form-control form-control-sm" id="refernce_id" name="refernce_id">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control form-control-sm" id="refernce_name" name="refernce_name" placeholder="Refernce Name" >
                                <small id="refernce_name" class="form-text text-muted">Refernce Name </small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="tel" class="form-control form-control-sm" id="refernce_phone" name="refernce_phone" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Refernce Phone" >
                                <small id="refernce_phone" class="form-text text-muted">Refernce Phone </small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <input type="date" class="form-control form-control-sm" id="refernce_dob" name="refernce_dob" placeholder="DOB" aria-describedby="refernce_dob" >
                                <small id="refernce_dob" class="form-text text-muted">Refernce Date of Birth</small>
                            </div>
                            <div class="form-group col-md-4">
                                <select id="refernce_gender" name="refernce_gender" class="form-control form-control-sm" aria-describedby="refernce_gender">
                                    <option selected>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                <small id="refernce_gender" class="form-text text-muted">Gender</small>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control form-control-sm" id="refernce_occupation" name="refernce_occupation" placeholder="Refernce Occupation" >
                                <small id="refernce_occupation" class="form-text text-muted">e.g. Nagar Sevak, Sarpanch, Other</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" id="refernce_address" name="refernce_address" placeholder="Refernce Address | Street, Village/City, Pincode">
                            <small id="refernce_address" class="form-text text-muted">Refernce Address | Format - Street, Village/City, Pincode</small>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="updateVisitorBtn" class="btn btn-sm btn-primary">Update changes</button>
                    <button type="button" id="removeBtn" class="btn btn-sm btn-danger">Remove</button>
                </div>
        </form>
    </div>
    </div>
</div>


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../datatable/dataTables.all.js"></script>
    <script src="visitorList.js"></script>

</body>
</html>
