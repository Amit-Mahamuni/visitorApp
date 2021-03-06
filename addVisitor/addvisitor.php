<?php

session_start();

if(isset($_SESSION['U_Id']) && $_SESSION['Department'] == "Reception" || $_SESSION['Department'] == "Admin")
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
    <title>Add Visitor</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        @media print{
            /**/
            body * {
                visibility: hidden;
            }
            .print-conatiner, .print-conatiner * {
                visibility: visible;

            }

            .print-conatiner{
                position: absolute;
                top: 10px;
            }

        }
    </style>
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
                    <a class="nav-link" href="../addVisitor/addvisitor.php">Add Visitor </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="../visitorWork/visitorworkList.php">Visitor Work List </a>
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

   <div class="container my-5" style="background-color:white;">
       <form id="frm">

        <!-- visitor detail from section -->
          <div class="row">
            <div class="col-md-8 border border-secondary p-4">
                <h5 class="mb-3">Visitor Detail</h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- <div class="form-group" > -->
                            <!-- <button type="button" name="visitor_type" id="visitor_type" value="Walk" class="btn btn-sm btn-primary">Walking</button>
                            <button type="button" name="visitor_type" id="visitor_type" value="Call" class="btn btn-sm btn-primary">Call</button>
                        </div> -->

                        <div class="form-check form-check-inline">
                            <input class="form-check-input " type="radio" name="visitor_type" id="visitor_type" value="By Walking" checked>
                            <label class="form-check-label" for="Walk">Walking</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input " type="radio" name="visitor_type" id="visitor_type" value="By Call">
                            <label class="form-check-label" for="Call">Call</label>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                    <div class="form-group col-md-4">
                        <input type="hidden" class="form-control" id="visitor_id" name="visitor_id">
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['U_Id']; ?>">
                        <select id="visitor_voter" name="visitor_voter" class="form-control form-control-sm" aria-describedby="visitor_voter">
                            <option value="Unknown" selected>Unknown</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <small id="visitor_voter" class="form-text text-muted">Voter</small>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="visitor_name" name="visitor_name" placeholder="Name" required>
                    <div id="countryList"></div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="tel" class="form-control form-control-sm" id="visitor_phone" name="visitor_phone" placeholder="Phone" minlength="10" maxlength="10"  required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control form-control-sm" id="visitor_email" name="visitor_email" placeholder="Email" >
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
                        <option value="">Select</option>
                      </select>
                      <small id="visitor_city" class="form-text text-muted">City</small>
                    </div>

                    <div class="form-group col-md-6">
                        <input type="text" class="form-control form-control-sm" id="visitor_pincode" minlength="6" maxlength="6"  name="visitor_pincode" placeholder="Pincode" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-sm" id="v_adhar_card" minlength="12" maxlength="12" name="v_adhar_card"  placeholder="Adhar Card" >
                        <small id="v_adhar_card" class="form-text text-muted">Adhar Card </small>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="tel" class="form-control form-control-sm" id="v_voter_card" name="v_voter_card" minlength="12" maxlength="12"  placeholder="Voter Card" >
                        <small id="v_voter_card" class="form-text text-muted">Voter Card </small>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="tel" class="form-control form-control-sm" id="v_pan_card" name="v_pan_card" minlength="12" maxlength="12" placeholder="Pan Card" >
                        <small id="v_pan_card" class="form-text text-muted">Pan Card</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border border-secondary p-4">
                <img src="../image/default_img.png" id="visitor_img_pre"  class="rounded mx-auto d-block m-4" width="70%" height="auto">
                <div class="form-group">
                    <input type="file" id="visitor_profile" class="m-2 pb-5 form-control" capture="camera" name="visitor_profile" accept=".jpg, .jpeg, .png">
                </div>
            </div>
          </div>

          <!-- Refernce Detail from section -->
          <div class="row border border-secondary p-4">
              <div class="col-12">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="refernce_detail_check" onclick="refernce_detail()">
                    <label class="custom-control-label" for="refernce_detail_check">Have a Refernce </label>
                </div>
                <div id="refernce_detail_div"></div>

              </div>
          </div>

          <!-- Group Detail from section-->
          <div class="row border border-secondary p-4">
              <div class="col-12">
                <h5 class="mb-3">Group Detail</h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="visitor_category" id="visitor_category" value="Single" checked>
                            <label class="form-check-label" for="Single">Single</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="visitor_category" id="visitor_category" value="Group">
                            <label class="form-check-label" for="Group">Group</label>
                        </div>

                    </div>
                </div>

                <div class="form-row" id="group_row">
                    <span id="error"></span>
                    <table class="table table-bordered" id="group_table">
                        <thead>
                            <tr>
                                <th width="30%">Name</th>
                                <th width="20%">Phone</th>
                                <th width="15%">Gender</th>
                                <th width="15%">Dob</th>
                                <th width="10%"><button type="button" name="add" class="btn btn-primary btn-sm add">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
          </div>

          <!-- work detail from section -->
          <div class="row">
              <div class="col-md-8 col-md-pull-8 border border-secondary p-4">

                <input type="hidden" class="form-control" id="work_id" name="work_id">
                <div class="form-row">
                    <div class="form-group col-md-8"><h5 class="mb-3">Work Detail</h5></div>
                    <div class="form-group col-md-4">
                        <select id="work_priority" name="work_priority" class="form-control form-control-sm">
                            <option selected>Low</option>
                            <option>Normal</option>
                            <option>High</option>
                        </select>
                        <small id="work_priority" class="form-text text-muted">Priority</small>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <select id="work_category" name="work_category" class="form-control form-control-sm">
                          <option value="" selected>Select</option>
                            <option value="Government">Government</option>
                            <option value="Personal">Personal</option>
                            <option value="Invitation">Invitation</option>
                            <option value="Job">Job</option>
                            <option value="Other">Other</option>
                        </select>
                        <small id="work_category" class="form-text text-muted">Work Category</small>
                    </div>
                    <div id="work_subcat_div" class="form-group col-md-6">
                    </div>
                </div>






                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <select id="work_category" name="work_category" class="form-control form-control-sm">
                            <option value="Government">Government</option>
                            <option value="Personal">Personal</option>
                            <option value="Invitation">Invitation</option>
                            <option value="Job">Job</option>
                            <option value="Other">Other</option>
                        </select>
                        <small id="work_category" class="form-text text-muted">Work Category</small>
                    </div>
                    <div id="work_subcat_div" class="form-group col-md-6">
                    </div>
                </div> -->

                <div id="form_layout"></div>
                <div id="form_complaint_layout"></div>
                <div id="letter_cat"></div>

                <!-- <div id="test">
               </div> -->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control form-control-sm" id="work_title" name="work_title" placeholder="Work Title" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control form-control-sm" name="work_detail" id="work_detail" rows="2" cols="100%" maxlength="300" placeholder="Work Note"></textarea>
                        <small id="work_detail" class="form-text text-muted">Add Work Detail | Max. Word 300. </small>
                    </div>
                </div>

                <button type="submit" id="add_work_save" class="btn btn-primary">Submit</button>
              </div>
              <div class="col-md-4 col-md-push-4 border border-dark p-4">
                <img src="../image/icon/doc.png" id="work_file_pre" class="rounded mx-auto d-block m-4" width="70%" height="auto" >
                <div class="form-group">
                    <input type="file" id="work_file" class="m-2 pb-5 form-control" name="work_file" accept=".jpg, .jpeg, .png">
                </div>
              </div>
          </div>


       </form>


       <!-- <button class="btn btn-danger btn-sm m-1" id="uploadLetterModalBtn" data-toggle="modal" data-target="#PrintModal" >Print Btn</button> -->
   </div>


   <!-- Print Modal -->
   <div class="modal fade" id="PrintModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visitor Detail</h5>
        </div>

        <input type="hidden" id="work_id_make_change" name="work_id_make_change">

        <div class="modal-body p-4">

            <div class="print-conatiner ">
                <div class="border border-secondary p-5">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Visitor ID : <span id="pv_vid"></span></h6>
                                </div>
                                <div class="col-6">
                                    <h6>Work ID : <span id="pv_wid"></span></h6>
                                </div>
                            </div>
                            <hr>

                            <h6>Name : <span id="pv_name"></span></h6>
                            <h6>Detail : <span id="pv_detail"></span></h6>
                            <h6>Conact Detail : <span id="pv_contact"></span></h6>
                            <h6>Address : <span id="pv_address"></span></h6>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <img src="../image/default_img.png" id="visitor_profile_print" class="img-thumbnail m-2">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Work : <span id="pv_work"></span></h6>
                            <h6>Category : <span id="pv_work_cat"></span></h6>
                            <h6>Date : <span id="pv_work_c_date"></span></h6>
                            <h6><span id="pv_work_detail"></span></h6>
                        </div>
                    </div>
                </div>

                <hr><hr>

                <h6 class="text-center"> Office Use</h6>

                <br><br><br><br><br><br>

                <hr>
                <div class="border border-secondary p-5">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Visitor ID : <span id="pv_vid_f"></span></h6>
                                </div>
                                <div class="col-6">
                                    <h6>Work ID : <span id="pv_wid_f"></span></h6>
                                </div>
                            </div>
                            <hr>
                            <h6>Name : <span id="pv_name_f"></span></h6>
                            <h6>Detail : <span id="pv_detail_f"></span></h6>
                            <h6>Conact Detail : <span id="pv_contact_f"></span></h6>
                            <h6>Address : <span id="pv_address_f"></span></h6>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <img src="../image/default_img.png" id="visitor_profile_print_f" class="img-thumbnail m-2">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Work : <span id="pv_work_f"></span></h6>
                            <h6>Category : <span id="pv_work_cat_f"></span></h6>
                            <h6>Date : <span id="pv_work_c_date_f"></span></h6>
                            <h6><span id="pv_work_detail_f"></span></h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" id="print_modal_close" onclick="close_print_modal();" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="print_modal_close" onclick="Make_Change_btn();" class="btn btn-sm btn-info" data-dismiss="modal">Make Change</button>
            <button type="button" id="pv_print_btn" onclick="print_visitor_btn();" class="btn btn-sm btn-primary">Print</button>
        </div>

    </div>
    </div>
   </div>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="addvisitor.js"></script>

</body>
</html>
