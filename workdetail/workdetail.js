$(document).ready(function(){
    // alert("this is work detail");
    var qsParm = new Array();
        var query = window.location.search.substring(1);
        var parms = query.split('&');
        for (var i=0; i < parms.length; i++) {
            var pos = parms[i].indexOf('=');
            if (pos > 0) {
                var key = parms[i].substring(0, pos);
                var val = parms[i].substring(pos + 1);
                qsParm[key] = val;
            }
        }


        //hide letter download btn
        $("#final_letter").hide();
        $('#work_doc').hide();
        $("#work_doc_pre").hide();
        $("#Letter").hide();
        $("#reference_detail").hide();

     var workId = qsParm[key];
     if(parms != ""){
        $("#word_id").html(workId);

        if($("#user_department").val != "Admin" || $("#user_department").val == ""){
            $("#karykarta_list").hide();
            $("#adhikari_list").hide();
            $("#karykarta_rm_btn").hide();
        }else{
            $("#karykarta_list").show();
            $("#adhikari_list").show();
            $("#karykarta_rm_btn").show();
        }

        $.ajax({
            url : "retriveWorkDetail.php",
            type : "Post",
            data : {work_Id : workId, action : "workdetail"},
            dataType : "json",
            success:function(response){

                $("#work_id").val(response.W_Id);
                $("#work_title").val(response.Work_title);

                $("#work_subcat").val(response.Work_Subcategory);
                $("#work_cat").val(response.Work_Category);

                karykarta_dt = $('#Karykarta_datatable').DataTable({
                    "order" : [],
                    "ajax" : {
                     url:"karykarta_List.php",
                     type:"POST",
                     data:{
                        Department : response.Work_Category
                     }
                    },
                    fixedHeader: true,
                    responsive: true
                });

                // adhikari_dt = $('#adhikari_datatable').DataTable({
                //     "order" : [],
                //     "ajax" : {
                //      url:"function.php",
                //      type:"POST",
                //      data:{
                //         adhikari_Id : response.Work_Category, action : "adhikariDetail"
                //      }
                //     },
                //     fixedHeader: true,
                //     responsive: true
                // });

                var work_subcategory_text = response.Work_Subcategory;
                $("#work_subcat_letter").val(response.W_LType);
                $("#work_cat_subcat").val(response.Work_Category+" | "+response.Work_Subcategory);

                $("#work_priority").val(response.Priority);
                $("#work_detail").val(response.Work_detail);
                $("#work_add_date").val(response.Work_add_date);
                $("#work_complete_date").val(response.Work_end_date);
                $("#work_status").val(response.Status);
                $("#visitor_id").val(response.V_Id);
                $("#visitor_name").val(response.V_Name);
                $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
                $("#visitor_detail").val(response.V_Gender+" | "+response.V_Dob);
                $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);

                $("#visitor_type").val(response.V_Type);
                $("#visitor_voter").val(response.V_Voter);
                $("#v_adhar_card").val(response.V_Adhar_Card);
                $("#v_voter_card").val(response.V_Voter_Card);
                $("#v_pan_card").val(response.V_Pan_Card);
                var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;

                $("#karykarta_id").val(response.K_Id);
                var karykarta_id = response.K_Id;
                $("#karykarta_name").val(response.K_Name);
                $("#karykarta_contact").val(response.K_Phone+" | "+response.K_Email);
                $("#karykarta_department").val(response.K_Department);
                $("#karykarta_status").val(response.K_Status);
                // $("#karykarta_department").val(response.Department);
                var karykarta_status = response.K_Status;

                if(karykarta_id == null && karykarta_status == null){
                    $("#karykarta_list").show();
                    $("#karykarta_rm_btn").hide();
                }else if(karykarta_status == "In-Active"){
                    $("#karykarta_list").show();
                    $("#karykarta_rm_btn").show();
                    $("#karykarta_msg").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>  Karykarta Status is In Active </strong><br> Please assign another Karykarta or Remove It.'+
                   '</div>');
                }else{
                    $("#karykarta_list").hide();
                    $("#karykarta_rm_btn").show();
                }

                if (response.Work_Category == "Government") {
                  $("#adhikari_div").show();
                  if(response.AD_Id == null || response.AD_Id == "" ){
                      $("#adhikari_list").show();
                      $("#adhikari_rm_btn").hide();
                  }else{
                      $("#adhikari_list").hide();
                      $("#adhikari_rm_btn").show();
                      get_Adhikari_detail(response.AD_Id);
                  }
                }else {
                  $("#adhikari_div").hide();
                }




                if(response.Visitor_Profile != null || response.Visitor_Profile == ""){

                    $('#visitor_profile').attr('src', visitor_profile_path);
                }


                // alert(work_subcategory_text);
                switch(work_subcategory_text){

                    case "Medical Letter":
                                //  alert(work_subcategory_text);
                                $("#Letter").show();
                                 $("#subcategory_layout").html("<hr>"+
                                 "<h6 class='mb-3'>Hospital Detail</h6>"+
                                 "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                        "<input type='text' class='form-control form-control-sm' id='patient_name' name='patient_name' placeholder='Patient Name' disabled>"+
                                        "<small id='patient_name' class='form-text text-muted'>Patient Name</small>"+
                                    " </div>"+
                                "</div>"+
                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-4'>"+
                                        "<input type='date' class='form-control form-control-sm' id='patient_dob' name='patient_dob' placeholder='Patient DOB' disabled>"+
                                    " <small id='patient_name' class='form-text text-muted'>Patient DOB</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-4'> "+
                                        "<select id='patient_gender' name='patient_gender' class='form-control form-control-sm' disabled>"+
                                            "<option value='Male' selected>Male</option>"+
                                            "<option value='Female'>Female</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='patient_gender' class='form-text text-muted'>Patient Gender</small>"+
                                    "</div> "+
                                    "<div class='form-group col-md-4'>"+
                                        "<select id='patient_relation' name='patient_relation' class='form-control form-control-sm' disabled>"+
                                            "<option value='Son/Daughter of Visitor' selected>Son/Daughter of Visitor</option>"+
                                            "<option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>"+
                                            "<option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>"+
                                            "<option value='GrandParent of Visitor'>GrandParent of Visitor</option>"+
                                            "<option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='patient_relation' class='form-text text-muted'>Patient Related to Visitor</small>"+
                                    "</div>" +
                                "</div>"+
                                 "<div class='form-row'>"+
                                     "<div class='form-group'>"+
                                        "<textarea class='form-control form-control-sm' name='hospital_name' id='hospital_name' rows='1' cols='100%' maxlength='100' placeholder='Hospital Name' disabled></textarea>"+
                                         "<small id='work_detail' class='form-text text-muted'>Hospital Name | Max. Word 100. | Format - Name , Address </small>"+
                                    " </div>"+
                                 "</div>"+
                                " <div class='form-row'>"+
                                     "<div class='form-group col-md-4'>"+
                                         "<input type='text' class='form-control form-control-sm' id='hospital_ward' name='hospital_ward' placeholder='Hospital Ward' disabled>"+
                                        " <small id='hospital_ward' class='form-text text-muted'>Hospital Ward</small>"+
                                     "</div>"+
                                     "<div class='form-group col-md-4'> "+
                                         "<input type='text' class='form-control form-control-sm' id='hospital_bed' name='hospital_bed' placeholder='Bed No.' disabled>"+
                                        " <small id='hospital_bed' class='form-text text-muted'>Bed No.</small>"+
                                     "</div> "+
                                     "<div class='form-group col-md-4'>"+
                                         "<input type='date' class='form-control form-control-sm' id='admit_date' name='admit_date' disabled>"+
                                         "<small id='admit_date' class='form-text text-muted'>Date Of Admit</small>"+
                                     "</div>" +
                                 "</div>"+
                                 "<div class='form-row'>"+
                                     "<div class='form-group col-md-12'>"+
                                         "<input type='text' class='form-control form-control-sm' id='Disease' name='Disease' placeholder='Disease' disabled>"+
                                        " <small id='Disease' class='form-text text-muted'>Disease</small>"+
                                     "</div>"+
                               "</div>"+
                               "<div class='form-row'>"+
                               "<div class='form-group'>"+
                                    "<input type='date' class='form-control form-control-sm' id='complete_date' name='complete_date' disabled>"+

                                " </div>"+
                                "</div>"+
                                 "<hr>");

                                 $.ajax({
                                    url : "function.php",
                                    type : "Post",
                                    data : {work_Id : workId, action : "Medical_Letter"},
                                    dataType : "json",
                                    success:function(response_medical){
                                        // alert(response_medical);

                                        `W_Id`, `V_Id`, `ML_Hospital`, `ML_Ward`, `ML_Bed`, `ML_Disease`, `ML_Admit_Date`, `ML_C_Date`, `ML_Final_Letter`

                                        $("#hospital_name").val(response_medical.ML_Hospital)
                                        $("#hospital_ward").val(response_medical.ML_Ward);
                                        $("#hospital_bed").val(response_medical.ML_Bed);
                                        $("#admit_date").val(response_medical.ML_Admit_Date);
                                        $("#Disease").val(response_medical.ML_Disease);

                                        $("#patient_name").val(response_medical.ML_PName);
                                        $("#patient_dob").val(response_medical.ML_PDob);
                                        $("#patient_gender").val(response_medical.ML_PGender);
                                        $("#patient_relation").val(response_medical.ML_PRelation);

                                        if(response_medical.ML_C_Date != null || response_medical.ML_C_Date == ""){
                                            $("#complete_date").val(response_medical.ML_C_Date);
                                        }else{
                                            $("#complete_date").hide();
                                        }
                                        // $("#refernce_address").val(response_ref.R_Address);

                                        var medical_file_path = "../image/Work_File/"+response_medical.Work_Doc;
                                        if(response_medical.Work_Doc != null || response_medical.Work_Doc == ""){
                                            // alert("visitor profile path " +visitor_profile_path );
                                            $('#work_doc').attr('src', medical_file_path);
                                            $('#work_doc').show();
                                            $('#work_doc_pre').show();
                                        }

                                        var letter_download_path = "../image/Work_File/ml_letter/"+response_medical.ML_Final_Letter;
                                        if(response_medical.ML_Final_Letter != null || response_medical.ML_Final_Letter == ""){
                                            $("#final_letter").show();
                                            $('#final_letter').attr('href', letter_download_path);
                                        }


                                    }
                                });


            break;

            case "Wedding":
                            // alert("wedding");
                        $("#Letter").hide();

                        $("#subcategory_layout").html("<hr>"+
                        "<h6 class='mb-3'>Wedding Detail</h6>"+
                        "<div class='form-group'>"+
                        "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='wedding Address | Street, Village/City, Pincode' disabled>"+
                        "<small id='invitation_address' class='form-text text-muted'>wedding Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"+
                        "<div class='form-row'>"+
                            "<div class='form-group col-md-6'>"+
                            " <input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' disabled>"+
                                "<small id='invitation_date' class='form-text text-muted'>Wedding Date</small>"+
                            "</div>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time' disabled>"+
                                "<small id='invitation_time' class='form-text text-muted'>Wedding Time</small>"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group'>"+
                            "<input type='text' class='form-control form-control-sm' id='Wedding_Boy_Name' name='Wedding_Boy_Name' placeholder='Wedding Boy Name' disabled>"+
                            "<small id='refernce_address' class='form-text text-muted'>Wedding Boy Name | First Name, Middle Name, Last Name</small>"+
                        "</div>"+
                        "<div class='form-group'>"+
                            "<input type='text' class='form-control form-control-sm' id='Wedding_Girl_Name' name='Wedding_Girl_Name' placeholder='Wedding Girl Name' disabled>"+
                            "<small id='Wedding_Girl_Name' class='form-text text-muted'>Wedding Girl Name | First Name, Middle Name, Last Name</small>"+
                        "</div>"+
                        "<hr>");

                        $.ajax({
                            url : "function.php",
                            type : "Post",
                            data : {work_Id : workId, action : "invitation"},
                            dataType : "json",
                            success:function(response_wedding){
                                // alert(response_ref)

                                $("#invitation_date").val(response_wedding.I_Date);
                                $("#invitation_time").val(response_wedding.I_Time);
                                $("#invitation_address").val(response_wedding.I_Address);
                                $("#Wedding_Boy_Name").val(response_wedding.WI_BName);
                                $("#Wedding_Girl_Name").val(response_wedding.WI_GName);

                                // $("#invitation_title").val(response.I_Title);


                                var invitation_wedding_file_path = "../image/Work_File/"+response_wedding.Work_Doc;
                                if(response_wedding.Work_Doc != null || response_wedding.Work_Doc == ""){
                                    // alert("visitor profile path " +visitor_profile_path );
                                    $('#work_doc').attr('src', invitation_wedding_file_path);
                                    $('#work_doc').show();
                                    $('#work_doc_pre').show();
                                }


                            }
                        });

            break;

            case "Dashkriya":
            case "Birthday":
            case "Collage / School Program":
            case "Government Program / Meeting":
            case "Other Invitation":

                        $("#Letter").hide();

                        $("#subcategory_layout").html("<hr>"+
                        "<h6 class='mb-3'>Invitation Detail</h6>"+
                        "<div class='form-group'>" +
                            " <input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Invitation Of' disabled>"+
                            "<small id='invitation_title' class='form-text text-muted'>Invitation</small>"+
                        "</div>"+

                        " <div class='form-group'> "  +
                            "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Opening Address | Street, Village/City, Pincode' disabled>"+
                            "<small id='invitation_address' class='form-text text-muted'>Opening Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"+

                        "<div class='form-row'>"+
                            "<div class='form-group col-md-6'>"+
                                " <input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' disabled>"+
                                "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                            "</div>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time' disabled>"+
                                "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                            "</div>"+
                        "</div>" +
                        "<hr>");

                        $.ajax({
                            url : "function.php",
                            type : "Post",
                            data : {work_Id : workId, action : "invitation"},
                            dataType : "json",
                            success:function(response_opening){
                                // alert(response_opening)

                                $("#invitation_date").val(response_opening.I_Date);
                                $("#invitation_time").val(response_opening.I_Time);
                                $("#invitation_address").val(response_opening.I_Address);
                                $("#invitation_title").val(response_opening.I_Title);


                                var invitation_Opening_file_path = "../image/Work_File/"+response_opening.Work_Doc;
                                if(response_opening.Work_Doc != null || response_opening.Work_Doc == ""){
                                    // alert("visitor profile path " +visitor_profile_path );
                                    $('#work_doc').attr('src', invitation_Opening_file_path);
                                    $('#work_doc').show();
                                    $('#work_doc_pre').show();
                                }


                            }
                        });
            break;


                case "Education":
                        // alert("Education");
                        $("#Letter").hide();
                        $("#subcategory_layout").html("<hr>"+
                        "<h6 class='mb-3'>Education Detail</h6>"+
                            "<div class='form-group'>"  +
                                "<input type='text' class='form-control form-control-sm' id='student_name' name='student_name' placeholder='Student Name' disabled>"+
                                "<small id='student_name' class='form-text text-muted'>Student Name</small>"+
                            "</div>"+

                            "<div class='form-group'>"    +
                                "<input type='text' class='form-control form-control-sm' id='collage_Name' name='collage_Name' placeholder='Collage Name' disabled>"+
                                "<small id='collage_Name' class='form-text text-muted'>Collage Name | Address</small>"+
                            "</div>"+

                            "<div class='form-row'>"+
                                "<div class='form-group col-md-4'>"+
                                    "<input type='text' class='form-control form-control-sm' name='student_class' id='student_class' placeholder='Student Class' disabled>"+
                                    "<small id='student_class' class='form-text text-muted'>Student Class</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'>"+
                                    "<input type='text' class='form-control form-control-sm' name='student_fee_total' id='student_fee_total' placeholder='Student Fee Total' disabled>"+
                                    "<small id='student_fee' class='form-text text-muted'>Student Fee Total</small>"+
                                "</div>"+
                            "<div class='form-group col-md-4'>"+
                                    "<input type='text' class='form-control form-control-sm' name='student_discount_fee' id='student_discount_fee' placeholder='Need Fee Discount' disabled>"+
                                    "<small id='student_discount_fee' class='form-text text-muted'>Need Fee Discount</small>"+
                            "</div>"+
                        "</div>"+
                        "<hr>");

                        $.ajax({
                            url : "function.php",
                            type : "Post",
                            data : {work_Id : workId, action : "Education"},
                            dataType : "json",
                            success:function(response_education){
                                // alert(response_education);

                                $("#student_name").val(response_education.E_Student_Name);
                                $("#collage_Name").val(response_education.E_Collage_Name);
                                $("#student_class").val(response_education.E_Class);
                                $("#student_discount_fee").val(response_education.E_D_Fee);
                                $("#student_fee_total").val(response_education.E_T_Fee);


                                var invitation_education_file_path = "../image/Work_File/"+response_education.Work_Doc;
                                if(response_education.Work_Doc != null || response_education.Work_Doc == ""){
                                    // alert("visitor profile path " +visitor_profile_path );
                                    $('#work_doc').attr('src', invitation_education_file_path);
                                    $('#work_doc').show();
                                    $('#work_doc_pre').show();
                                }

                            }
                        });
                    break;

                    case "Vacany":
                        // alert("Education");
                        $("#Letter").hide();
                        $("#subcategory_layout").html("<hr>"+
                        "<h6 class='mb-3'>Job Detail</h6>"+
                        " <div class='form-row'>"+
                                "<div class='form-group col-md-8'> " +
                                    "  <input type='text' class='form-control form-control-sm' id='job_name' name='job_name' placeholder='Name' disabled>"+
                                    " <small id='job_name' class='form-text text-muted'>Name</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'> " +
                                    "  <input type='text' class='form-control form-control-sm' id='job_type' name='job_type' placeholder='Type' disabled>"+
                                    " <small id='job_type' class='form-text text-muted'>Name</small>"+
                            "  </div>"+
                        " </div>"+

                            "<div class='form-row'>"+
                                "<div class='form-group col-md-6'>"+
                                    "<input type='text' class='form-control form-control-sm' id='job_detail' name='job_detail' placeholder='DOB | Gender' disabled>"+
                                    " <small id='job_detail' class='form-text text-muted'>DOB | Gender</small>  "   +
                                "</div>"+
                                "<div class='form-group col-md-6'>" +
                                    "<input type='text' class='form-control form-control-sm'   id='job_relation' name='job_relation' placeholder='Related to Visitor' disabled>" +
                                    "<small id='job_relation' class='form-text text-muted'> Related to Visitor</small>"+
                                "</div> "+
                            "</div>"+

                        " <div class='form-row'>"+
                            " <div class='form-group col-md-6'>"+
                                    "<input type='email' class='form-control form-control-sm' id='job_contact' name='job_contact' placeholder='Phone | Email' disabled>"+
                                    "<small id='job_contact' class='form-text text-muted'>Phone | Email</small> " +
                                "</div>"+
                                "<div class='form-group col-md-6'>"   +
                                    " <input type='text' class='form-control form-control-sm' id='job_qualification' name='job_qualification' placeholder='Qualification' disabled>"+
                                    " <small id='job_qualification' class='form-text text-muted'>Qualification | E.g. BE(Mech.)</small>"+
                                "</div> "+
                            "</div>"+


                        " <div class='form-row'>"+
                                "<div class='form-group col-md-4'>"+
                                " <input type='number' class='form-control form-control-sm' id='job_exp' name='job_exp' placeholder='Experience' disabled>"+
                                    "<small id='job_exp' class='form-text text-muted'>Experiences | In Year</small>  "  +
                                "</div>"+
                                "<div class='form-group col-md-8'> " +
                                " <input type='text' class='form-control form-control-sm' id='job_company' name='job_company' placeholder='Last Company Name' disabled>"+
                                        "<small id='job_phone' class='form-text text-muted'>Last Company Name</small>" +
                                "</div> "+
                            "</div>"+
                        "<hr>");

                        $.ajax({
                            url : "function.php",
                            type : "Post",
                            data : {work_Id : workId, action : "Job"},
                            dataType : "json",
                            success:function(response_job_letter){
                                // alert(response_job_letter);

                                // `J_Id`, `J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`, `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`

                                $("#job_name").val(response_job_letter.J_Name);
                                $("#job_type").val(response_job_letter.J_Type);
                                $("#job_detail").val(response_job_letter.J_Dob+" | "+response_job_letter.J_Gender);
                                $("#job_relation").val(response_job_letter.J_Relative);
                                $("#job_contact").val(response_job_letter.J_Phone+" | "+response_job_letter.J_Email);
                                $("#job_qualification").val(response_job_letter.J_Qualification);
                                $("#job_exp").val(response_job_letter.J_Exp);
                                $("#job_company").val(response_job_letter.J_Old_Company);



                                var job_file_path = "../image/Work_File/"+response_job_letter.Work_Doc;
                                if(response_job_letter.Work_Doc != null || response_job_letter.Work_Doc == ""){
                                    // alert("visitor profile path " +visitor_profile_path );
                                    $('#work_doc').attr('src', job_file_path);
                                    $('#work_doc').show();
                                    $('#work_doc_pre').show();
                                }

                            }
                        });

                    break;



                    case "Job Letter":
                        // alert("Education");
                        $("#Letter").show();
                        $("#subcategory_layout").html("<hr>"+
                        "<h6 class='mb-3'>Job Detail</h6>"+
                        " <div class='form-row'>"+
                                "<div class='form-group col-md-8'> " +
                                    "  <input type='text' class='form-control form-control-sm' id='job_name' name='job_name' placeholder='Name' disabled>"+
                                    " <small id='job_name' class='form-text text-muted'>Name</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'> " +
                                    "  <input type='text' class='form-control form-control-sm' id='job_type' name='job_type' placeholder='Type' disabled>"+
                                    " <small id='job_type' class='form-text text-muted'>Work</small>"+
                            "  </div>"+
                        " </div>"+

                            "<div class='form-row'>"+
                                "<div class='form-group col-md-6'>"+
                                    "<input type='text' class='form-control form-control-sm' id='job_detail' name='job_detail' placeholder='DOB | Gender' disabled>"+
                                    " <small id='job_detail' class='form-text text-muted'>DOB | Gender</small>  "   +
                                "</div>"+
                                "<div class='form-group col-md-6'>" +
                                    "<input type='text' class='form-control form-control-sm'   id='job_relation' name='job_relation' placeholder='Related to Visitor' disabled>" +
                                    "<small id='job_relation' class='form-text text-muted'> Related to Visitor</small>"+
                                "</div> "+
                            "</div>"+

                        " <div class='form-row'>"+
                            " <div class='form-group col-md-6'>"+
                                    "<input type='email' class='form-control form-control-sm' id='job_contact' name='job_contact' placeholder='Phone | Email' disabled>"+
                                    "<small id='job_contact' class='form-text text-muted'>Phone | Email</small> " +
                                "</div>"+
                                "<div class='form-group col-md-6'>"   +
                                    " <input type='text' class='form-control form-control-sm' id='job_qualification' name='job_qualification' placeholder='Qualification' disabled>"+
                                    " <small id='job_qualification' class='form-text text-muted'>Qualification | E.g. BE(Mech.)</small>"+
                                "</div> "+
                            "</div>"+


                        " <div class='form-row'>"+
                                "<div class='form-group col-md-4'>"+
                                " <input type='number' class='form-control form-control-sm' id='job_exp' name='job_exp' placeholder='Experience' disabled>"+
                                    "<small id='job_exp' class='form-text text-muted'>Experiences | In Year</small>  "  +
                                "</div>"+
                                "<div class='form-group col-md-8'> " +
                                " <input type='text' class='form-control form-control-sm' id='job_company' name='job_company' placeholder='Last Company Name' disabled>"+
                                        "<small id='job_phone' class='form-text text-muted'>Last Company Name</small>" +
                                "</div> "+
                            "</div>"+
                        "<hr>");

                        $.ajax({
                            url : "function.php",
                            type : "Post",
                            data : {work_Id : workId, action : "Job"},
                            dataType : "json",
                            success:function(response_job_letter){
                                // alert(response_job_letter);

                                // `J_Id`, `J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`, `J_Qualification`, `J_Exp`, `J_Old_Company`, `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`

                                $("#job_name").val(response_job_letter.J_Name);
                                $("#job_type").val(response_job_letter.J_Type);
                                $("#job_detail").val(response_job_letter.J_Dob+" | "+response_job_letter.J_Gender);
                                $("#job_relation").val(response_job_letter.J_Relative);
                                $("#job_contact").val(response_job_letter.J_Phone+" | "+response_job_letter.J_Email);
                                $("#job_qualification").val(response_job_letter.J_Qualification);
                                $("#job_exp").val(response_job_letter.J_Exp);
                                $("#job_company").val(response_job_letter.J_Old_Company);



                                var job_file_path = "../image/Work_File/"+response_job_letter.Work_Doc;
                                if(response_job_letter.Work_Doc != null || response_job_letter.Work_Doc == ""){
                                    // alert("visitor profile path " +visitor_profile_path );
                                    $("#work_doc").show();
                                    $('#work_doc').attr('src', job_file_path);
                                    $("#work_doc_pre").show();

                                }

                                var letter_download_path = "../image/Work_File/job_letter/"+response_job_letter.J_LFinal ;
                                if(response_job_letter.J_LFinal != null || response_job_letter.J_LFinal == ""){
                                    $("#final_letter").show();
                                    $('#final_letter').attr('href', letter_download_path);
                                }

                            }
                        });

                    break;

                    case "Letter":

                        switch(response.W_LType){

                            case "Ration Card":
                                $("#Letter").show();
                                $("#subcategory_layout").html("<hr>"+
                                "<h6 class='mb-3'>Ration Card Letter Detail</h6>"+
                                "<div class='form-row'>"+
                                "<div class='form-group col-md-4'>"+
                                "<input type='number' id='ration_l_tman' name='ration_l_tman' class='form-control form-control-sm' disabled>"+
                                "<small id='ration_l_tman' class='form-text text-muted'>Total Man in Family</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'>"+
                                "<input type='number' id='ration_l_twoman' name='ration_l_twoman' class='form-control form-control-sm' disabled>"+
                                "<small id='ration_l_twoman' class='form-text text-muted'>Total WoMan in Family</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'>"+
                                "<input type='number' id='ration_l_tlive' name='ration_l_tlive' class='form-control form-control-sm' disabled>"+
                                "<small id='ration_l_tlive' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                "</div>"+
                                "</div>"+
                                "<hr>");

                                $.ajax({
                                    url : "function.php",
                                    type : "Post",
                                    data : {work_Id : workId, action : "RationCard"},
                                    dataType : "json",
                                    success:function(response_RationCard){
                                        // alert(response_RationCard);

                                        $("#ration_l_tman").val(response_RationCard.RC_TM);
                                        $("#ration_l_twoman").val(response_RationCard.RC_TW);
                                        $("#ration_l_tlive").val(response_RationCard.RC_TY);

                                        var file_path = "../image/Work_File/"+response_RationCard.Work_Doc;
                                        if(response_RationCard.Work_Doc != null || response_RationCard.Work_Doc == ""){
                                            // alert("visitor profile path " +visitor_profile_path );

                                            $('#work_doc').attr('src', file_path);
                                            $('#work_doc').show();
                                            $('#work_doc_pre').show();
                                        }

                                        var letter_download_path = "../image/Work_File/rationc_letter/"+response_RationCard.RC_FLetter ;
                                        if(response_RationCard.RC_FLetter  != null || response_RationCard.RC_FLetter  == ""){
                                            $("#final_letter").show();
                                            $('#final_letter').attr('href', letter_download_path);
                                        }

                                    }
                                });

                            break;

                            case "Identity card":
                                $("#Letter").show();
                                $("#subcategory_layout").html("<hr>"+
                                "<h6 class='mb-3'>Identity Card Letter Detail</h6>"+
                                "<div class='form-row'>"+
                                "<div class='form-group col-md-6'>"+
                                "<input type='number' id='identityC_Year' name='identityC_Year' class='form-control form-control-sm' minlength='1' maxlength='2' disabled>"+
                                "<small id='identityC_Year' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                "</div>"+
                                "</div>"+
                                "<hr>");

                                $.ajax({
                                    url : "function.php",
                                    type : "Post",
                                    data : {work_Id : workId, action : "IdentityCard"},
                                    dataType : "json",
                                    success:function(response_IdentityCard){
                                        // alert(response_RationCard);

                                        $("#identityC_Year").val(response_IdentityCard.ID_TYear);


                                        var file_path = "../image/Work_File/"+response_IdentityCard.Work_Doc;
                                        if(response_IdentityCard.Work_Doc != null || response_IdentityCard.Work_Doc == ""){
                                            // alert("visitor profile path " +visitor_profile_path );

                                            $('#work_doc').attr('src', file_path);
                                            $('#work_doc').show();
                                            $('#work_doc_pre').show();
                                        }

                                        var letter_download_path = "../image/Work_File/identityc_letter/"+response_IdentityCard.ID_FLetter ;
                                        if(response_IdentityCard.ID_FLetter  != null || response_IdentityCard.ID_FLetter  == ""){
                                            $("#final_letter").show();
                                            $('#final_letter').attr('href', letter_download_path);
                                        }

                                    }
                                });

                            break;


                            case "Residential Certificate":
                                $("#Letter").show();
                                $("#subcategory_layout").html("<hr>"+
                                "<h6 class='mb-3'>Ration Card Letter Detail</h6>"+
                                "<div class='form-row'>"+
                                "<div class='form-group col-md-12'>"+
                                   "<input type='text' id='residentialL_For' name='residentialL_For' class='form-control form-control-sm' disabled>"+
                                   "<small id='residentialL_For' class='form-text text-muted'>Residential Letter For</small>"+
                                "</div>"+
                                "</div>"+
                                "<div class='form-row'>"+
                                "<div class='form-group col-md-12'>"+
                                   "<input type='number' id='residentialL_Year' name='residentialL_Year' class='form-control form-control-sm' minlength='1' maxlength='2' disabled>"+
                                   "<small id='residentialL_Year' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                "</div>"+
                                "</div>"+
                                "<hr>");

                                $.ajax({
                                    url : "function.php",
                                    type : "Post",
                                    data : {work_Id : workId, action : "ResidentailLetter"},
                                    dataType : "json",
                                    success:function(response_ResidentialLetter){
                                        // alert(response_RationCard);

                                        $("#residentialL_For").val(response_ResidentialLetter.RL_For);
                                        $("#residentialL_Year").val(response_ResidentialLetter.RL_TYear);


                                        var file_path = "../image/Work_File/"+response_ResidentialLetter.Work_Doc;
                                        if(response_ResidentialLetter.Work_Doc != null || response_ResidentialLetter.Work_Doc == ""){
                                            // alert("visitor profile path " +visitor_profile_path );

                                            $('#work_doc').attr('src', file_path);
                                            $('#work_doc').show();
                                            $('#work_doc_pre').show();
                                        }

                                        var letter_download_path = "../image/Work_File/residential_letter/"+response_ResidentialLetter.RL_FLetter ;
                                        if(response_ResidentialLetter.RL_FLetter  != null || response_ResidentialLetter.RL_FLetter  == ""){
                                            $("#final_letter").show();
                                            $('#final_letter').attr('href', letter_download_path);
                                        }

                                    }
                                });

                            break;

                            case "Other":
                                $("#Letter").show();
                                $.ajax({
                                    url : "function.php",
                                    type : "Post",
                                    data : {work_Id : workId, action : "CutomLetter"},
                                    dataType : "json",
                                    success:function(response_CustomLetter){
                                        // alert(response_RationCard);

                                        var file_path = "../image/Work_File/"+response_CustomLetter.Work_Doc;
                                        if(response_CustomLetter.Work_Doc != null || response_CustomLetter.Work_Doc == ""){
                                            // alert("visitor profile path " +visitor_profile_path );

                                            $('#work_doc').attr('src', file_path);
                                            $('#work_doc').show();
                                            $('#work_doc_pre').show();
                                        }

                                        var letter_download_path = "../image/Work_File/custom_letter/"+response_CustomLetter.CL_FLetter ;
                                        if(response_CustomLetter.CL_FLetter  != null || response_CustomLetter.CL_FLetter  == ""){
                                            $("#final_letter").show();
                                            $('#final_letter').attr('href', letter_download_path);
                                        }

                                    }
                                });
                                break;

                        }

                    break;


                case "Other":
                    $("#subcategory_layout").html("");
                break;
                }


                //get refernce detail
                $.ajax({
                    url : "retriveWorkDetail.php",
                    type : "Post",
                    data : {work_Id : workId, action : "refernceDetail"},
                    dataType : "json",
                    success:function(response_ref){

                        // alert(response_ref);

                        if(response_ref != null){

                            if(response_ref.R_Id != "" || response_ref.R_Id != null){

                                $("#reference_detail").show();
                                $("#refernce_id").val(response_ref.R_Id)
                                $("#refernce_name").val(response_ref.R_Name);
                                $("#refernce_phone").val(response_ref.R_Phone);
                                $("#refernce_detail").val(response_ref.R_Dob+" | "+response_ref.R_Gender);
                                $("#refernce_occupation").val(response_ref.R_Occupation);
                                $("#refernce_address").val(response_ref.R_Address);

                            }else if(response_ref.R_Id == null || response_ref.R_Id == ""){

                                $("#reference_detail").hide();

                            }

                        }
                    }
                });

            }
        });


    }else{
        alert("No Work Id Found!  Please Select from Work List");
    }


    fill_adhikari_table();

    function fill_adhikari_table(stat = '', cate = '')
    {
        adhikari_dt = $('#adhikari_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                status : stat, category : cate, action : "adhikariDetail"
             }
            },
            fixedHeader: true,
            responsive: true,

        });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#adhikari_datatable').DataTable().destroy();

        fill_adhikari_table($("#adhikari_status_f").val(), $("#adhikari_department_f").val());

    });

     $(document).on('click', '#clear_filter', function(){

        $('#adhikari_datatable').DataTable().destroy();

        fill_adhikari_table();

    });


    //  alert($("#work_cat_subcat").val());
    // var K_Department =  $("#work_cat").val();
    //  karykarta_dt = $('#Karykarta_datatable').DataTable({
    //     "order" : [],
    //     "ajax" : {
    //      url:"karykarta_List.php",
    //      type:"POST",
    //      data:{
    //         Department : K_Department
    //      }
    //     },
    //     fixedHeader: true,
    //     responsive: true
    // });


});

function printDoc(){
    // alert("print");
    window.print();
}

function assignkarykarta(Id){
    var workId = $("#work_id").val();
    $.ajax({
        url : "retriveWorkDetail.php",
        type : "Post",
        data : {work_Id : workId, action : "updateWork", KID: Id, VID: $("#visitor_id").val(), UID: $("#user_id").val()},
        dataType : "json",
        success:function(response){
            // alert(response);
            if(response.success == true){
                alert(response.messages);
                $("#karykarta_list").hide();
                location.reload(true);
            }else{
                alert(response.messages);
            }
        }
    });
}


function dismisskarykarta(){
    var work_Id = $("#work_id").val();
    // alert("work Id is "+work_Id);
    $.ajax({
        url : "retriveWorkDetail.php",
        type : "Post",
        data : {work_Id : work_Id, visitor_Id : $("#visitor_id").val(), UID : $("#user_id").val(), KID : $("#karykarta_id").val(), action : "removeKarykarta"},
        dataType : "json",
        success:function(response){
            // alert(response);
            if(response.success == true){

                alert(response.messages);
                // $("#karykarta_list").hide();
                location.reload(true);

            }else{
                alert(response.messages);
            }
        }
    });
}

function passData_Letter(){

    var Id = $("#work_id").val();
    var subcat = $("#work_subcat").val();

    switch(subcat){
        case "Job Letter":
            // alert("Work Id is"+Id+" subcate "+subcat);
                window.location = '../job/jobLetter.php?Id=' + Id;

        break;
        case "Medical Letter":
                // alert("Work Id is"+Id+" subcate "+subcat);
                window.location = '../MedicalLetter/medicalLetter.php?Id=' + Id;

        break;
        case "Letter":
           switch($("#work_subcat_letter").val()){
               case "Ration Card":
                //    alert($("#work_subcat_letter").val());
                   window.location = '../letter/rationCard/rationCardLetter.php?Id=' + Id;
               break;

               case "Identity card":
                // alert($("#work_subcat_letter").val());
                window.location = '../letter/identityCard/identityCardLetter.php?Id=' + Id;

               break;

               case "Residential Certificate":
                // alert($("#work_subcat_letter").val());
                window.location = '../letter/residentialLetter/residentialLetter.php?Id=' + Id;

                break;

                case "Other":
                    // alert($("#work_subcat_letter").val());
                    window.location = '../letter/customLetter/customLetter.php?Id=' + Id;

                    break;
           }

    break;
    }
}


function visitorDetail(){
    // alert($("#visitor_id").val());
    window.location = '../visitorDetail/visitorDetail.php?Id=' + $("#visitor_id").val();
}

function assignAdhikari(Id){
    // alert(Id);
    var workId = $("#work_id").val();
    $.ajax({
        url : "retriveWorkDetail.php",
        type : "Post",
        data : {work_Id : workId, action : "updateWork_assignAdhikari", AID: Id, VID: $("#visitor_id").val(), UID: $("#user_id").val()},
        dataType : "json",
        success:function(response){
            // alert(response);
            if(response.success == true){
                alert(response.messages);
                $("#adhikari_list").hide();
                location.reload(true);
            }else{
                alert(response.messages);
            }
        }
    });
}

function get_Adhikari_detail(Id){
    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "get_Adhikari_detail", AID : Id},
        dataType : "json",
        success:function(response){
            // alert(response);

            $("#adhikari_status").val(response.AD_Status);
            $("#adhikari_department").val(response.AD_Department+" | "+response.AD_Occupation);
            $("#adhikari_name").val(response.AD_Name);
            $("#adhikari_contact").val(response.AD_Phone+" | "+response.AD_Email);


        }
    });
}

function dismissAdhikari(){

    $.ajax({
        url : "retriveWorkDetail.php",
        type : "Post",
        data : {work_Id : $("#work_id").val(), VID : $("#visitor_id").val(), UID : $("#user_id").val(), action : "removeAdhikari"},
        dataType : "json",
        success:function(response){
            // alert(response);
            if(response.success == true){

                alert(response.messages);
                // $("#karykarta_list").hide();
                location.reload(true);

            }else{
                alert(response.messages);
            }
        }
    });

}
