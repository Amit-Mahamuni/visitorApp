$(document).ready(function(){

    $("#group_row").hide();

    $('#countryList').fadeOut();

    $("input[type='radio']").click(function(){
        var radioValue = $("input[name='visitor_category']:checked").val();
        if(radioValue == "Group"){
            // alert("Your are a - " + radioValue);
            $("#group_row").show();
        }else if(radioValue == "Single"){
            $("#group_row").hide();
        }
    });


    var qsParm = new Array();
    var qsKey = new Array();
    var query = window.location.search.substring(1);
    // alert(query);
    var parms = query.split('&');

    for (var i=0; i < parms.length; i++) {
        var pos = parms[i].indexOf('=');
        if (pos > 0) {
            var key = parms[i].substring(0, pos);
            var val = parms[i].substring(pos + 1);
            qsParm[val] = val;
            qsKey[key] = key;
        }
    }

    var key =  qsKey[key];

    var Id = qsParm[val];

    if(parms != ""){
        // $("#visitor_id").html(visitorId_vd);

        switch (key) {
          case "wId":
              // alert(key);
              selectWork(Id);
            break;
          case "vId":
              selectVisitor(Id);
            break;

        }
    }


    $('#visitor_name').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
            $.ajax({
                url:"search.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                $('#countryList').fadeIn();
                $('#countryList').html(data);

                }
            });
        }
   });


    $(document).on('click', 'li', function(){
        // $('#visitor_name').val($(this).text());
        if($(this).text() == "" || $(this).text()== "Name Not Found" || $(this).text()== "Clear" ){

            $('#countryList').fadeOut();
            $("#visitor_id").val();

        }else{
            // $('#visitor_name').val($(this).text());
            $('#countryList').fadeOut();
        }

    });

    var addressArry = [];
      $.ajax({
          url:"function.php",
          method:"post",
          data : {action : 'getAddressDetail'},
          dataType : "json",
          success:function(response)
          {
             Object.assign(addressArry, response);
            for(var i=0; i <= response.length; i++){
                $("#visitor_city").append('<option>'+response[i].ADD_Address+'</option>');
            }
          }
      });

    $(document).on('change','#visitor_city',function(){
        var addressCity_txt = $(this).val();
        for(var i=0; i <= addressArry.length; i++){
            if(addressCity_txt == addressArry[i].ADD_Address){
              $("#visitor_pincode").val(addressArry[i].ADD_Pincode);
            }
        }
    });


    $(document).on('change','#work_category',function(){

        var optionText = $("#work_category option:selected").text();

        if(optionText == "Government"){
            $("#form_layout").html("");
           $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control form-control-sm'>"+
                                        "<option value='Nothing'selected>Select..</option>"+
                                        "<option value='Complaint'>Complaint</option>"+
                                        "<option value='Letter'>Letter</option>"+
                                        "<option value='Other'>Other</option>"+
                                        "</select><small id='work_subcategory' class='form-text text-muted'>work Sub-Category</small>");

        }else if(optionText == "Personal"){
            $("#form_layout").html("");
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control form-control-sm'>"+
                                        "<option value='Nothing selected'selected>Select...</option>"+
                                        "<option value='Medical Letter'>Medical Letter</option>"+
                                        "<option value='Education'>Education</option>"+
                                        "<option value='Other'>Other</option>"+
                                        "</select><small id='work_subcategory' class='form-text text-muted'>work Sub-Category</small>");

        }else if(optionText == "Invitation"){
            $("#form_layout").html("");
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control form-control-sm'>"+
                                        "<option value='Nothing' selected>Select</option>"+
                                        "<option value='Wedding'>Wedding</option>"+
                                        "<option value='Opening'>Opening</option> "+
                                        "<option value='Dashkriya'>Dashkriya</option>"+
                                        "<option value='Birthday'>Birthday</option>"+
                                        "<option value='Collage / School Program'>Collage / School Program</option>"+
                                        "<option value='Government Program / Meeting'>Government Program / Meeting</option>"+
                                        "<option value='Other Invitation'>Other Invitation</option>"+
                                        "</select><small id='work_subcategory' class='form-text text-muted'>work Sub-Category</small>");

        }else if(optionText == "Job"){
            $("#form_layout").html("");
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control form-control-sm'>"+
                                        "<option value='Nothing' selected>Select</option>"+
                                        "<option value='Vacany'>Vacany</option>"+
                                        "<option value='Job Letter'>Job Letter</option>"+
                                        "<option value='Other'>Other</option>"+
                                        "</select><small id='work_subcategory' class='form-text text-muted'>work Sub-Category</small>");

        }else{
            $("#work_subcat_div").html("");
            $("#form_layout").html("");
        }

    });



    $(document).on('change','#work_subcategory',function(){

        var optionText_sub = $(this).val();



       switch(optionText_sub){

            case "Complaint":
                $("#form_layout").html("");
                $("#form_layout").html("<hr>"+
                "<h6 class='mb-3'>Select Complaint Type</h6>"+
                "<div class='form-row'>"+
                    "<div class='form-group col-md-6'>"+
                        "<select id='complaint_type' name='complaint_type' class='form-control form-control-sm'>"+
                            "<option value='Nothing' selected>Select Type</option>"+
                            "<option value='Pipeline'>Pipeline</option>"+
                            "<option value='Public Transport'>Public Transport</option>"+
                            "<option value='Roads'>Roads</option>"+
                            "<option value='Waste Management'>Waste Management</option>"+
                            "<option value='Government scheme'>Government scheme</option>"+
                            "<option value='Other'>Other</option>"+
                    "</select><small id='complaint_type' class='form-text text-muted'> Select Complaint Type</small>"+
                    "</div>"+
                    "<div id='compaint_cat_div' class='form-group col-md-6'></div>"+
                "</div>"
                );


                $(document).on('change','#complaint_type',function(){
                    var optionText_complaint = $(this).val();

                    switch(optionText_complaint){

                        case "Pipeline":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html(
                                "<select id='complaint_cat' name='complaint_cat' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Category</option>"+
                                    "<option value='Pipeline drainage'>Pipeline drainage</option>"+
                                    "<option value='Pipeline Repair'>Pipeline Repair</option>"+
                                    "<option value='New Pipeline connection'>New Pipeline connection</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='complaint_cat' class='form-text text-muted'> Select Complaint Category</small>"
                                )
                        break;

                        case "Roads":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html(
                                "<select id='complaint_cat' name='complaint_cat' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Category</option>"+
                                    "<option value='Pipeline drainage'>Road Repair</option>"+
                                    "<option value='Pipeline Repair'>New road</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='complaint_cat' class='form-text text-muted'> Select Complaint Category</small>"
                                )
                        break;

                        case "Waste Management":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html(
                                "<select id='complaint_cat' name='complaint_cat' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Category</option>"+
                                    "<option value='Dumping ground'>Dumping ground</option>"+
                                    "<option value='Waste Vehicle'>Waste Vehicle</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='complaint_cat' class='form-text text-muted'> Select Complaint Category</small>"
                                )
                        break;

                        case "Public Transport":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html(
                                "<select id='complaint_cat' name='complaint_cat' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Category</option>"+
                                    "<option value='Request for a new bus'>Request for a new bus</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='complaint_cat' class='form-text text-muted'> Select Complaint Category</small>"
                                )
                        break;

                        case "Government scheme":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html(
                                "<select id='complaint_cat' name='complaint_cat' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Category</option>"+
                                    "<option value='Health plans'>Health plans (आरोग्य योजना)</option>"+
                                    "<option value='Crop insurance'>Crop insurance (पीकविमा)</option>"+
                                    "<option value='Fields'>Fields (शेततळे)</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='complaint_cat' class='form-text text-muted'> Select Complaint Category</small>"
                                )
                        break;

                        case "Other":
                            // alert("Pipeline");
                            $("#compaint_cat_div").html("")
                        break;


                    }
                });

                break;


            case "Medical Letter":
                        //  alert(optionText_sub);
                        $("#form_layout").html("");
                            $("#form_layout").html("<hr>"+
                            "<h6 class='mb-3'>Hospital Detail</h6>"+
                            "<div class='form-row'>"+
                            "<input type='hidden' class='form-control form-control-sm' id='medical_id' name='medical_id' >"+
                            "<div class='form-group col-md-12'>"+
                                "<input type='text' class='form-control form-control-sm' id='patient_name' name='patient_name' placeholder='Patient Name' >"+
                                "<small id='patient_name' class='form-text text-muted'>Patient Name</small>"+
                            " </div>"+
                        "</div>"+
                        " <div class='form-row'>"+
                            "<div class='form-group col-md-4'>"+
                                "<input type='date' class='form-control form-control-sm' id='patient_dob' name='patient_dob' placeholder='Patient DOB' >"+
                            " <small id='patient_name' class='form-text text-muted'>Patient DOB</small>"+
                            "</div>"+
                            "<div class='form-group col-md-4'> "+
                                "<select id='patient_gender' name='patient_gender' class='form-control form-control-sm'>"+
                                    "<option value='Male' selected>Male</option>"+
                                    "<option value='Female'>Female</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='patient_gender' class='form-text text-muted'>Patient Gender</small>"+
                            "</div> "+
                            "<div class='form-group col-md-4'>"+
                                "<select id='patient_relation' name='patient_relation' class='form-control form-control-sm'>"+
                                    "<option value='Son/Daughter of Visitor' selected>Son/Daughter of Visitor</option>"+
                                    "<option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>"+
                                    "<option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>"+
                                    "<option value='GrandParent of Visitor'>GrandParent of Visitor</option>"+
                                    "<option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>"+
                                    "<option value='Self'>Self</option>"+
                                    "<option value='Other'>Other</option>"+
                                "</select><small id='patient_relation' class='form-text text-muted'>Patient Related to Visitor</small>"+
                            "</div>" +
                        "</div>"+
                            "<div class='form-row'>"+
                                "<div class='form-group'>"+
                                "<textarea class='form-control form-control-sm' name='hospital_name' id='hospital_name' rows='1' cols='100%' maxlength='100' placeholder='Hospital Name'></textarea>"+
                                    "<small id='work_detail' class='form-text text-muted'>Hospital Name | Max. Word 100. | Format - Name , Address </small>"+
                            " </div>"+
                            "</div>"+
                            "<div class='form-row'>"+
                                "<div class='form-group col-md-4'>"+
                                    "<input type='text' class='form-control form-control-sm' id='hospital_ward' name='hospital_ward' placeholder='Hospital Ward' >"+
                                " <small id='hospital_ward' class='form-text text-muted'>Hospital Ward</small>"+
                                "</div>"+
                                "<div class='form-group col-md-4'> "+
                                    "<input type='text' class='form-control form-control-sm' id='hospital_bed' name='hospital_bed' placeholder='Bed No.'>"+
                                " <small id='hospital_bed' class='form-text text-muted'>Bed No.</small>"+
                                "</div> "+
                                "<div class='form-group col-md-4'>"+
                                    "<input type='date' class='form-control form-control-sm' id='admit_date' name='admit_date'>"+
                                    "<small id='admit_date' class='form-text text-muted'>Date Of Admit</small>"+
                                "</div>" +
                            "</div>"+
                            "<div class='form-row'>"+
                                "<div class='form-group col-md-12'>"+
                                    "<input type='text' class='form-control form-control-sm' id='Disease' name='Disease' placeholder='Disease' >"+
                                    " <small id='Disease' class='form-text text-muted'>Disease</small>"+
                                "</div>"+
                        "</div>"+
                        "<hr>");
            break;

            case "Wedding":
                            // alert("wedding");
                        $("#form_layout").html("");
                        $("#form_layout").html("<hr>"+
                        "<h6 class='mb-3'>Wedding Detail</h6>"+
                        "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                        "<div class='form-group'>"+
                        "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='wedding Address | Street, Village/City, Pincode' required>"+
                        "<small id='invitation_address' class='form-text text-muted'>wedding Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"+
                        "<div class='form-row'>"+
                            "<div class='form-group col-md-6'>"+
                            " <input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                                "<small id='invitation_date' class='form-text text-muted'>Wedding Date</small>"+
                            "</div>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                                "<small id='invitation_time' class='form-text text-muted'>Wedding Time</small>"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group'>"+
                            "<input type='text' class='form-control form-control-sm' id='Wedding_Boy_Name' name='Wedding_Boy_Name' placeholder='Wedding Boy Name' required>"+
                            "<small id='refernce_address' class='form-text text-muted'>Wedding Boy Name | First Name, Middle Name, Last Name</small>"+
                        "</div>"+
                        "<div class='form-group'>"+
                            "<input type='text' class='form-control form-control-sm' id='Wedding_Girl_Name' name='Wedding_Girl_Name' placeholder='Wedding Girl Name' required>"+
                            "<small id='Wedding_Girl_Name' class='form-text text-muted'>Wedding Girl Name | First Name, Middle Name, Last Name</small>"+
                        "</div>"+
                        "<hr>");

            break;

            case "Opening":
                        // alert("Opening");
                        $("#form_layout").html("");
                        $("#form_layout").html("<hr>"+
                        "<h6 class='mb-3'>Opening Detail</h6>"+
                        "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                        "<div class='form-group'>" +
                            " <input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Opening Of' required>"+
                            "<small id='invitation_title' class='form-text text-muted'>Opening Of - Shop | Hotel | Other</small>"+
                        "</div>"+

                        " <div class='form-group'> "  +
                            "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Opening Address | Street, Village/City, Pincode' required>"+
                            "<small id='invitation_address' class='form-text text-muted'>Opening Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"+

                        "<div class='form-row'>"+
                            "<div class='form-group col-md-6'>"+
                                " <input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                                "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                            "</div>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                                "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                            "</div>"+
                        "</div>" +
                        "<hr>");
            break;

            case "Dashkriya":
                $("#form_layout").html("");
                $("#form_layout").html("<hr>"+
                "<h6 class='mb-3'>Dashkriya Detail</h6>"+
                "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                "<div class='form-group'>"  +
                    "<input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Name' required>"+
                    "<small id='invitation_title' class='form-text text-muted'>Name</small>"+
                "</div>"+

                "<div class='form-group'>" +
                    "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Address | Street, Village/City, Pincode' required>"+
                    "<small id='invitation_address' class='form-text text-muted'>Address | Format - Street, Village/City, Pincode</small>"+
                "</div>"+

                "<div class='form-row'>"+
                    "<div class='form-group col-md-6'>"+
                        "<input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                        "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                    "</div>"+
                    "<div class='form-group col-md-6'>"+
                        "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                        "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                    "</div>"+
                "</div> " +
                "<hr>");
                break;

                case "Birthday":
                    $("#form_layout").html("");
                    $("#form_layout").html("<hr>"+
                    "<h6 class='mb-3'>Birthday Detail</h6>"+
                    "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                    "<div class='form-group'>"  +
                        "<input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Name' required>"+
                        "<small id='invitation_title' class='form-text text-muted'>Name</small>"+
                    "</div>"+

                    "<div class='form-group'>" +
                        "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Address | Street, Village/City, Pincode' required>"+
                        "<small id='invitation_address' class='form-text text-muted'>Address | Format - Street, Village/City, Pincode</small>"+
                    "</div>"+

                    "<div class='form-row'>"+
                        "<div class='form-group col-md-6'>"+
                            "<input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                            "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                        "</div>"+
                        "<div class='form-group col-md-6'>"+
                            "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                            "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                        "</div>"+
                    "</div> " +
                    "<hr>");
                    break;

                    case "Collage / School Program":
                        $("#form_layout").html("");
                        $("#form_layout").html("<hr>"+
                        "<h6 class='mb-3'>Collage / School Program Detail</h6>"+
                        "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                        "<div class='form-group'>"  +
                            "<input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Program detail' required>"+
                            "<small id='invitation_title' class='form-text text-muted'>Program detail</small>"+
                        "</div>"+

                        "<div class='form-group'>" +
                            "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Address | Street, Village/City, Pincode' required>"+
                            "<small id='invitation_address' class='form-text text-muted'>Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"+

                        "<div class='form-row'>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                                "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                            "</div>"+
                            "<div class='form-group col-md-6'>"+
                                "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                                "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                            "</div>"+
                        "</div> " +
                        "<hr>");
                        break;

                        case "Government Program / Meeting":
                            $("#form_layout").html("");
                            $("#form_layout").html("<hr>"+
                            "<h6 class='mb-3'>Government Program / Meeting Detail</h6>"+
                            "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                            "<div class='form-group'>"  +
                                "<input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Program detail' required>"+
                                "<small id='invitation_title' class='form-text text-muted'>Program detail</small>"+
                            "</div>"+

                            "<div class='form-group'>" +
                                "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Address | Street, Village/City, Pincode' required>"+
                                "<small id='invitation_address' class='form-text text-muted'>Address | Format - Street, Village/City, Pincode</small>"+
                            "</div>"+

                            "<div class='form-row'>"+
                                "<div class='form-group col-md-6'>"+
                                    "<input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                                    "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                                "</div>"+
                                "<div class='form-group col-md-6'>"+
                                    "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                                    "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                                "</div>"+
                            "</div> " +
                            "<hr>");
                            break;

                            case "Other Invitation":
                                $("#form_layout").html("");
                                $("#form_layout").html("<hr>"+
                                "<h6 class='mb-3'>Other Invitation Detail</h6>"+
                                "<input type='hidden' class='form-control form-control-sm' id='invitation_id' name='invitation_id'>"+
                                "<div class='form-group'>"  +
                                    "<input type='text' class='form-control form-control-sm' id='invitation_title' name='invitation_title' placeholder='Program detail' required>"+
                                    "<small id='invitation_title' class='form-text text-muted'>Program detail</small>"+
                                "</div>"+

                                "<div class='form-group'>" +
                                    "<input type='text' class='form-control form-control-sm' id='invitation_address' name='invitation_address' placeholder='Address | Street, Village/City, Pincode' required>"+
                                    "<small id='invitation_address' class='form-text text-muted'>Address | Format - Street, Village/City, Pincode</small>"+
                                "</div>"+

                                "<div class='form-row'>"+
                                    "<div class='form-group col-md-6'>"+
                                        "<input type='date' class='form-control form-control-sm' name='invitation_date' id='invitation_date' required>"+
                                        "<small id='invitation_date' class='form-text text-muted'>Date</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-6'>"+
                                        "<input type='time' class='form-control form-control-sm' name='invitation_time' id='invitation_time'>"+
                                        "<small id='invitation_time' class='form-text text-muted'>Time</small>"+
                                    "</div>"+
                                "</div> " +
                                "<hr>");
                                break;


                case "Education":
                        $("#form_layout").html("");
                        $("#form_layout").html("<hr>"+
                        "<h6 class='mb-3'>Education Detail</h6>"+
                        "<input type='hidden' class='form-control form-control-sm' id='education_id' name='education_id'>"+
                        "<div class='form-group'>"  +
                            "<input type='text' class='form-control form-control-sm' id='student_name' name='student_name' placeholder='Student Name' required>"+
                            "<small id='student_name' class='form-text text-muted'>Student Name</small>"+
                        "</div>"+

                        "<div class='form-group'>"    +
                            "<input type='text' class='form-control form-control-sm' id='collage_Name' name='collage_Name' placeholder='Collage Name' required>"+
                            "<small id='collage_Name' class='form-text text-muted'>Collage Name | Address</small>"+
                        "</div>"+

                        "<div class='form-row'>"+
                           " <div class='form-group col-md-4'>"+
                                "<input type='text' class='form-control form-control-sm' name='student_class' id='student_class' placeholder='Student Class' required>"+
                                "<small id='student_class' class='form-text text-muted'>Student Class</small>"+
                            "</div>"+
                            "<div class='form-group col-md-4'>"+
                                "<input type='text' class='form-control form-control-sm' name='student_fee_total' id='student_fee_total' placeholder='Student Fee Total' >"+
                                "<small id='student_fee' class='form-text text-muted'>Student Fee Total</small>"+
                            "</div>"+
                            "<div class='form-group col-md-4'>"+
                                "<input type='text' class='form-control form-control-sm' name='student_discount_fee' id='student_discount_fee' placeholder='Need Fee Discount' >"+
                                "<small id='student_discount_fee' class='form-text text-muted'>Need Fee Discount</small>"+
                           " </div>"+
                        "</div>"+
                        "<hr>");
                    break;



                case "Vacany":
                    $("#form_layout").html("");
                    $("#form_layout").html("<hr>"+
                                 "<h6 class='mb-3'>Job Relate Detail</h6>"+
                                 "<input type='hidden' class='form-control form-control-sm' id='job_id' name='job_id'>"+
                                 "<input type='hidden' class='form-control form-control-sm' id='job_type' name='job_type' value='Vacany'>"+
                                 "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                        "<input type='text' class='form-control form-control-sm' id='job_name' name='job_name' placeholder='Name' >"+
                                        "<small id='job_name' class='form-text text-muted'>Name</small>"+
                                    "</div>"+
                                "</div>"+
                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-4'>"+
                                        "<input type='date' class='form-control form-control-sm' id='job_dob' name='job_dob' >"+
                                    " <small id='job_dob' class='form-text text-muted'>DOB</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-4'> "+
                                        "<select id='job_gender' name='job_gender' class='form-control form-control-sm'>"+
                                            "<option value='Male' selected>Male</option>"+
                                            "<option value='Female'>Female</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='job_gender' class='form-text text-muted'>Gender</small>"+
                                    "</div> "+
                                    "<div class='form-group col-md-4'>"+
                                        "<select id='job_relation' name='job_relation' class='form-control form-control-sm'>"+
                                            "<option value='Son/Daughter of Visitor' selected>Son/Daughter of Visitor</option>"+
                                            "<option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>"+
                                            "<option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>"+
                                            "<option value='GrandParent of Visitor'>GrandParent of Visitor</option>"+
                                            "<option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>"+
                                            "<option value='Self'>Self</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='job_relation' class='form-text text-muted'> Related to Visitor</small>"+
                                    "</div>" +
                                "</div>"+

                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-6'>"+
                                        "<input type='email' class='form-control form-control-sm' id='job_email' name='job_email' placeholder='Email'>"+
                                    " <small id='job_email' class='form-text text-muted'>Email</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-6'> "+
                                        "<input type='tel' class='form-control form-control-sm' id='job_phone' name='job_phone' minlength='10' maxlength='10' pattern='[0-9]{10}' placeholder='Phone' >"+
                                        " <small id='job_phone' class='form-text text-muted'>Phone</small>"+
                                    "</div> "+
                                "</div>"+

                                "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                        "<input type='text' class='form-control form-control-sm' id='job_qualification' name='job_qualification' placeholder='Qualification' >"+
                                        "<small id='job_qualification' class='form-text text-muted'>Qualification | E.g. BE(Mech.)</small>"+
                                    " </div>"+
                                "</div>"+

                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-4'>"+
                                        "<input type='number' class='form-control form-control-sm' id='job_exp' name='job_exp' placeholder='Experience'>"+
                                    " <small id='job_exp' class='form-text text-muted'>Experiences | In Year</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-8'> "+
                                        "<input type='text' class='form-control form-control-sm' id='job_company' name='job_company' placeholder='Last Company Name' >"+
                                        " <small id='job_phone' class='form-text text-muted'>Last Company Name</small>"+
                                    "</div> "+
                                "</div>"+

                                 "<hr>");

                    break;

                    case "Job Letter":
                    $("#form_layout").html("");
                    $("#form_layout").html("<hr>"+
                                 "<h6 class='mb-3'>Job Relate Detail</h6>"+
                                 "<input type='hidden' class='form-control form-control-sm' id='job_id' name='job_id'>"+
                                 "<input type='hidden' class='form-control form-control-sm' id='job_type' name='job_type' value='Job Letter'>"+
                                 "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                        "<input type='text' class='form-control form-control-sm' id='job_name' name='job_name' placeholder='Name' >"+
                                        "<small id='job_name' class='form-text text-muted'>Name</small>"+
                                    " </div>"+
                                "</div>"+
                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-4'>"+
                                        "<input type='date' class='form-control form-control-sm' id='job_dob' name='job_dob' >"+
                                    " <small id='job_dob' class='form-text text-muted'>DOB</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-4'> "+
                                        "<select id='job_gender' name='job_gender' class='form-control form-control-sm'>"+
                                            "<option value='Male' selected>Male</option>"+
                                            "<option value='Female'>Female</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='job_gender' class='form-text text-muted'>Gender</small>"+
                                    "</div> "+
                                    "<div class='form-group col-md-4'>"+
                                        "<select id='job_relation' name='job_relation' class='form-control form-control-sm'>"+
                                            "<option value='Son/Daughter of Visitor' selected>Son/Daughter of Visitor</option>"+
                                            "<option value='Brother/Sister of Visitor'>Brother/Sister of Visitor</option>"+
                                            "<option value='Father/Mother of Visitor'>Father/Mother of Visitor</option>"+
                                            "<option value='GrandParent of Visitor'>GrandParent of Visitor</option>"+
                                            "<option value='Friends/Family of Visitor'>Friends/Family of Visitor</option>"+
                                            "<option value='Self'>Self</option>"+
                                            "<option value='Other'>Other</option>"+
                                        "</select><small id='job_relation' class='form-text text-muted'> Related to Visitor</small>"+
                                    "</div>" +
                                "</div>"+

                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-6'>"+
                                        "<input type='email' class='form-control form-control-sm' id='job_email' name='job_email' placeholder='Email'>"+
                                    " <small id='job_email' class='form-text text-muted'>Email</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-6'> "+
                                        "<input type='tel' class='form-control form-control-sm' id='job_phone' name='job_phone' minlength='10' maxlength='10' pattern='[0-9]{10}' placeholder='Phone' >"+
                                        " <small id='job_phone' class='form-text text-muted'>Phone</small>"+
                                    "</div> "+
                                "</div>"+

                                "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                        "<input type='text' class='form-control form-control-sm' id='job_qualification' name='job_qualification' placeholder='Qualification' >"+
                                        "<small id='job_qualification' class='form-text text-muted'>Qualification | E.g. BE(Mech.)</small>"+
                                    " </div>"+
                                 "</div>"+

                                " <div class='form-row'>"+
                                    "<div class='form-group col-md-4'>"+
                                        "<input type='number' class='form-control form-control-sm' id='job_exp' name='job_exp' placeholder='Experience'>"+
                                    " <small id='job_exp' class='form-text text-muted'>Experiences | In Year</small>"+
                                    "</div>"+
                                    "<div class='form-group col-md-8'> "+
                                        "<input type='text' class='form-control form-control-sm' id='job_company' name='job_company' placeholder='Last Company Name' >"+
                                        " <small id='job_phone' class='form-text text-muted'>Last Company Name</small>"+
                                    "</div> "+
                                "</div>"+

                                 "<hr>");

                    break;


                    case "Letter":
                        // alert("letter");
                        $("#form_layout").html("");
                        $("#form_layout").html("<hr>"+
                        "<h6 class='mb-3'>Select Letter</h6>"+
                        "<div class='form-row'>"+
                            "<div class='form-group col-md-12'>"+
                                "<select id='letter_type' name='letter_type' class='form-control form-control-sm'>"+
                                    "<option value='Nothing' selected>Select Letter</option>"+
                                    "<option value='Ration Card'>For Ration Card</option>"+
                                    "<option value='Identity card'>For Identity card</option>"+
                                    "<option value='Residential Certificate'>For Residential Certificate</option>"+
                                    "<option value='Other Letter'>Other Letter</option>"+
                            "</select><small id='letter_type' class='form-text text-muted'> Select Letter</small>"+
                            "</div>"+
                        "</div>"
                        );



                        $(document).on('change','#letter_type',function(){
                            var optionText_letter = $(this).val();

                            switch(optionText_letter){
                                case "Ration Card":
                                    // alert("Ration Card");
                                    $("#letter_cat").html("<h6 class='mb-3'>Detail For Ration Card Letter</h6>"+
                                        "<input type='hidden' id='RC_Id' name='RC_Id'>"+
                                        "<div class='form-row'>"+
                                        "<div class='form-group col-md-4'>"+
                                        "<input type='number' id='ration_l_tman' name='ration_l_tman' class='form-control form-control-sm' >"+
                                        "<small id='ration_l_tman' class='form-text text-muted'>Total Man in Family</small>"+
                                        "</div>"+
                                        "<div class='form-group col-md-4'>"+
                                        "<input type='number' id='ration_l_twoman' name='ration_l_twoman' class='form-control form-control-sm' >"+
                                        "<small id='ration_l_twoman' class='form-text text-muted'>Total WoMan in Family</small>"+
                                        "</div>"+
                                        "<div class='form-group col-md-4'>"+
                                        "<input type='number' id='ration_l_tlive' name='ration_l_tlive' class='form-control form-control-sm' >"+
                                        "<small id='ration_l_tlive' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                        "</div>"+
                                        "</div>")
                                break;
                                case "Identity card":
                                    // alert("Identity card");
                                    $("#letter_cat").html("<h6 class='mb-3'>Detail For Identity Card Letter</h6>"+
                                    "<input type='hidden' id='ID_Id' name='ID_Id'>"+
                                    "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                       "<input type='number' id='identityC_Year' name='identityC_Year' class='form-control form-control-sm' minlength='1' maxlength='2'>"+
                                       "<small id='identityC_Year' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                    "</div>"+
                                    "</div>")

                                break;
                                case "Residential Certificate":
                                    // alert("Residential Certificate");
                                    $("#letter_cat").html("<h6 class='mb-3'>Detail For Residential Letter</h6>"+
                                    "<input type='hidden' id='RC_Id' name='RC_Id'>"+
                                    "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                       "<input type='text' id='residentialL_For' name='residentialL_For' class='form-control form-control-sm'>"+
                                       "<small id='residentialL_For' class='form-text text-muted'>Residential Letter For</small>"+
                                    "</div>"+
                                    "</div>"+
                                    "<div class='form-row'>"+
                                    "<div class='form-group col-md-12'>"+
                                       "<input type='number' id='residentialL_Year' name='residentialL_Year' class='form-control form-control-sm' minlength='1' maxlength='2'>"+
                                       "<small id='residentialL_Year' class='form-text text-muted'>Total Year Lived in Maval</small>"+
                                    "</div>"+
                                    "</div>")
                                break;

                                case "Other Letter":
                                    // alert("Residential Certificate");
                                    $("#letter_cat").html("<input type='hidden' id='CUSTL_Id' name='CUSTL_Id'>");
                                break;
                            }
                        });



                    break;

                case "Other":
                    $("#form_layout").html("");
                      // alert("Other Letter");
                    // $("#letter_cat").html("<input type='hidden' id='CUSTL_Id' name='CUSTL_Id'>");
                break;
                default:
                    $("#form_layout").html("");
                    break;
       }


    });


    $(document).on('click','.add',function(){
        var html='';
        html += '<tr>';
        html += '<td><input type="text" name="gvisitor_name[]" class="form-control gvisitor_name" placeholder="Name" /></td>';
        html += '<td><input type="tel" name="gvisitor_phone[]" class="form-control gvisitor_phone" minlength="10" maxlength="10" placeholder="Phone" /></td>';
        html += '<td><select id="refernce_gender" name="gvisitor_gender[]" class="form-control">'+
                        '<option selected>Male</option>'+
                        '<option>Female</option>'+
                        '<option>Other</option>'+
                    '</td>';
        html += '<td><input type="date" class="form-control" id="gvisitor_dob[]" name="gvisitor_dob[]"></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-minus" aria-hidden="true"></i> Remove</button></td></tr>';
        $('#group_table').append(html);
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

    $('#visitor_profile').on('change', function(evt) {
     // console.log(this.files[0].size/(1024*1024));
     var f = this.files[0]
     if (f.size > 3500000 || f.fileSize > 3500000)
    { alert("Allowed Image size exceeded. (Max. 2 MB). Current Image Size is "+ Math.round(f.size/(1024*1024))+" MB");
       this.value = null;
       $("#visitor_img_pre").attr('src', "../image/default_img.png");
    }
   });

   $('#work_file').on('change', function(evt) {
    // console.log(this.files[0].size/(1024*1024));
    var f_work = this.files[0]
    if (f_work.size > 3500000 || f_work.fileSize > 3500000)
   { alert("Allowed file size exceeded. (Max. 2 MB) Current File Size is "+ Math.round(f_work.size/(1024*1024))+" MB");
      this.value = null;
      $("#visitor_img_pre").attr('src', "../image/default_img.png");
   }
  });

    //code for add data to database by ajax
    $('#frm').on('submit', function(event){
        event.preventDefault();
        var error = '';
        $('.gvisitor_name').each(function(){
            var count = 1;
            if($(this).val() == '')
            {
                error += "<p>Enter Name at "+count+" Row</p>";
                return false;
            }
            count = count + 1;
        });

        $('.gvisitor_phone').each(function(){
            var count = 1;
            if($(this).val() == '')
            {
                error += "<p>Enter Phone Number at "+count+" Row</p>";
                return false;
            }
            count = count + 1;
        });

        var extension = $('#visitor_profile').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
         if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
         {
          alert("Invalid Image File");
          error += "<p>Invalid Image File</p>";
          $('#visitor_profile').val('');
          return false;
         }

         $('#visitor_profile').on('change', function(evt) {
          console.log(this.files[0].size);
          // error += "<p>Invalid Image File</p>";
        });

        }


        if(error == '')
        {
            // alert($("#visitor_id").val());

            $.ajax({
                url:"addwork.php",
                method:"post",
                data:new FormData(this),
                contentType:false,
                processData:false,
                dataType : "json",
                success:function(d)
                {
                    // alert(d);
                    if(d.success == true){
                        alert(d.messages);
                        $.ajax({
                            url:"function.php",
                            method:"post",
                            data : {V_ID : d.VID, W_ID : d.WID, action : 'getVisitorData'},
                            dataType : "json",
                            success:function(response)
                            {
                                // alert(response);
                                $("#PrintModal").modal("show");
                                $("#print_modal_close").hide();
                                $("#pv_vid").html(d.VID);
                                $("#pv_wid").html(d.WID);
                                $("#work_id_make_change").val(d.WID);
                                $("#pv_name").html(response.V_Name);
                                $("#pv_detail").html(response.V_Gender+" | "+response.V_Dob);
                                $("#pv_contact").html(response.V_Phone+" | "+response.V_Email);
                                $("#pv_address").html(response.V_Address+","+response.V_City+","+response.V_Pincode);

                                var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;
                                if(response.Visitor_Profile != null || response.Visitor_Profile == ""){

                                    $('#visitor_profile_print').attr('src', visitor_profile_path);
                                    $('#visitor_profile_print_f').attr('src', visitor_profile_path);
                                }

                                $("#pv_work").html(response.Work_title);

                                if(response.W_LType != null){
                                    $("#pv_work_cat").html(response.Work_Category+" | "+response.Work_Subcategory+"  "+response.W_LType);
                                }else{
                                    $("#pv_work_cat").html(response.Work_Category+" | "+response.Work_Subcategory);
                                }

                                $("#pv_work_c_date").html(response.Work_add_date);
                                $("#pv_work_detail").html(response.Work_detail);


                                //for office div
                                $("#pv_vid_f").html(d.VID);
                                $("#pv_wid_f").html(d.WID);
                                $("#pv_name_f").html(response.V_Name);
                                $("#pv_detail_f").html(response.V_Gender+" | "+response.V_Dob);
                                $("#pv_contact_f").html(response.V_Phone+" | "+response.V_Email);
                                $("#pv_address_f").html(response.V_Address+","+response.V_City+","+response.V_Pincode);

                                $("#pv_work_f").html(response.Work_title);
                                if(response.W_LType != null){
                                    $("#pv_work_cat_f").html(response.Work_Category+" | "+response.Work_Subcategory+"  "+response.W_LType);
                                }else{
                                    $("#pv_work_cat_f").html(response.Work_Category+" | "+response.Work_Subcategory);
                                }
                                $("#pv_work_c_date_f").html(response.Work_add_date);
                                $("#pv_work_detail_f").html(response.Work_detail);
                            }
                        });
                    }else{
                        alert("fail");
                    }
                }
            });
        }
        else
        {
             $('#error').html('<div class="alert alert-danger">'+error+'</div>');
        }
    });
});

function print_visitor_btn(){
    window.print();
    $("#print_modal_close").show();
}


function close_print_modal(){
    $("#frm")[0].reset();
    $('#group_table').find("tr:gt(0)").remove();
    $("#group_row").hide();
    window.location = '../addVisitor/addvisitor.php';
    // location.reload(true);
}

var input = document.querySelector("#visitor_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#visitor_img_pre");
        img.setAttribute("src", result);
    }
}

var input = document.querySelector("#work_file");
input.addEventListener('change',preview_work_profile);
function preview_work_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#work_file_pre");
        img.setAttribute("src", result);
    }
}


function selectVisitor(ID){
    // alert(ID);

    $.ajax({
        url:"search.php",
        method:"POST",
        data:{VID:ID, action:"getVisitorData"},
        dataType : "json",
        success:function(response)
        {
            // alert(response);

            $("#visitor_id").val(ID);
            // $("#visitor_id_txt").html('<strong>Visitor Id : '+response.V_Id+'</strong>')
            // $("#visitor_type").val(response.V_Type);
            $("#visitor_name").val(response.V_Name);
            $("#visitor_phone").val(response.V_Phone);
            $("#visitor_email").val(response.V_Email);
            $("#visitor_gender").val(response.V_Gender);
            $("#visitor_dob").val(response.V_Dob);
            $("#visitor_address").val(response.V_Address);
            $("#visitor_city").val(response.V_City).change();
            $("#visitor_pincode").val(response.V_Pincode);
            $("#v_adhar_card").val(response.V_Adhar_Card);
            $("#v_voter_card").val(response.V_Voter_Card);
            $("#v_pan_card").val(response.V_Pan_Card);
            $("#visitor_voter").val(response.V_Voter);


            var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;
            if(response.Visitor_Profile != null || response.Visitor_Profile == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#visitor_img_pre').attr('src', visitor_profile_path);
            }

        }
   });

}

function selectVoter(Id){

    alert(Id);

    $("#visitor_voter").val("Yes")

    $.ajax({
        url:"search.php",
        method:"POST",
        data:{VoterID:Id, action:"getVoterData"},
        dataType : "json",
        success:function(response)
        {
            // alert(response);

            $("#visitor_name").val(response.Voter_name);
            $("#visitor_phone").val(response.Voter_mobile);

            switch(response.Voter_sex){
                case "M":
                $("#visitor_gender").val("Male");
                break;
                case "F":
                $("#visitor_gender").val("Female");
                break;
                default:
                    $("#visitor_gender").val("Male");
                    break;
            }

            $("#visitor_pincode").val(response.Voter_pincode);
            $("#v_voter_card").val(response.Voter_cardno);

        }
   });
}

function refernce_detail(){
    var checkBox = document.getElementById("refernce_detail_check");

    if (checkBox.checked == true){

        $("#refernce_detail_div").html("<h5 class='mb-3'>Refernce Detail</h5>"+
                        "<div class='form-row'>"+
                           " <div class='form-group col-md-6'> "+
                               " <input type='hidden' class='form-control form-control-sm' id='refernce_id' name='refernce_id' >"+
                                "<input type='text' class='form-control form-control-sm' id='refernce_name' name='refernce_name' placeholder='Refernce Name' >"+
                            "</div>"+
                            "<div class='form-group col-md-6'>" +
                                "<input type='tel' class='form-control form-control-sm' id='refernce_phone' name='refernce_phone' minlength='10' maxlength='10' placeholder='Refernce Phone' >"+
                            "</div>" +
                        "</div>"+
                        "<div class='form-row'>"+
                            "<div class='form-group col-md-4'>" +
                               " <input type='date' class='form-control form-control-sm' id='refernce_dob' name='refernce_dob' placeholder='DOB' aria-describedby='refernce_dob' >"+
                                "<small id='refernce_dob' class='form-text text-muted'>Refernce Date of Birth</small>" +
                            "</div>"+
                            "<div class='form-group col-md-4'>" +
                                "<select id='refernce_gender' name='refernce_gender' class='form-control form-control-sm' aria-describedby='refernce_gender' >" +
                                    "<option selected>Male</option>"+
                                    "<option>Female</option>"+
                                    "<option>Other</option>"+
                               "</select>"+
                                "<small id='refernce_gender' class='form-text text-muted'>Gender</small>"+
                            "</div>"+
                            "<div class='form-group col-md-4'>" +
                                "<input type='text' class='form-control form-control-sm' id='refernce_occupation' name='refernce_occupation' placeholder='Refernce Occupation' >"+
                                "<small id='refernce_occupation' class='form-text text-muted'>e.g. Nagar Sevak, Sarpanch, Other</small>"+
                            "</div>"+
                        "</div>"+
                        "<div class='form-group'>"+
                            "<input type='text' class='form-control form-control-sm' id='refernce_address' name='refernce_address' placeholder='Refernce Address | Street, Village/City, Pincode' >"+
                            "<small id='refernce_address' class='form-text text-muted'>Refernce Address | Format - Street, Village/City, Pincode</small>"+
                        "</div>"
                        );

    } else {
        $("#refernce_detail_div").html("");

    }
}

function selectWork(Id){

  $.ajax({
      url:"function.php",
      method:"POST",
      data:{WID:Id, action:"getWorkData"},
      dataType : "json",
      success:function(response)
      {
          // alert(response);
          console.log(response);

          $("#visitor_id").val(response.workdata.V_Id);
          // $("#visitor_id_txt").html('<strong>Visitor Id : '+response.V_Id+'</strong>')
          // $("#visitor_type").val(response.V_Type);
          $("#visitor_name").val(response.workdata.V_Name);
          $("#visitor_phone").val(response.workdata.V_Phone);
          $("#visitor_email").val(response.workdata.V_Email);
          $("#visitor_gender").val(response.workdata.V_Gender);
          $("#visitor_dob").val(response.workdata.V_Dob);
          $("#visitor_address").val(response.workdata.V_Address);
          $("#visitor_city").val(response.workdata.V_City);
          $("#visitor_pincode").val(response.workdata.V_Pincode);
          $("#v_adhar_card").val(response.workdata.V_Adhar_Card);
          $("#v_voter_card").val(response.workdata.V_Voter_Card);
          $("#v_pan_card").val(response.workdata.V_Pan_Card);
          $("#visitor_voter").val(response.workdata.V_Voter);
          var visitor_profile_path = "../image/Visitor_Profile/"+response.workdata.Visitor_Profile;
          if(response.workdata.Visitor_Profile != null || response.workdata.Visitor_Profile == ""){
              // alert("visitor profile path " +visitor_profile_path );
              $('#visitor_img_pre').attr('src', visitor_profile_path);
          }
          $("#work_id").val(response.workdata.W_Id);
          $("#work_priority").val(response.workdata.Priority);
          $("#work_category").val(response.workdata.Work_Category).change();
          $("#work_subcategory").val(response.workdata.Work_Subcategory).change();
          $("#work_title").val(response.workdata.Work_title);
          $("#work_detail").val(response.workdata.Work_detail);
          var visitor_profile_path = "../image/Work_File/"+response.workdata.Work_Doc;
          if(response.workdata.Work_Doc != null || response.workdata.Work_Doc == ""){
              // alert("visitor profile path " +visitor_profile_path );
              $('#work_file_pre').attr('src', visitor_profile_path);
          }

          switch (response.workdata.Work_Category) {
            case "Government":
                  if (response.workdata.Work_Subcategory == "Letter") {
                    $("#letter_type").val(response.workdata.W_LType).change();
                    switch (response.workdata.W_LType) {
                      case "Ration Card":
                            $("#ration_l_tman").val(response.Ration_Card.RC_TM);
                            $("#ration_l_twoman").val(response.Ration_Card.RC_TW);
                            $("#'ration_l_tlive").val(response.Ration_Card.RC_TY);
                            $("#RC_Id").val(response.Ration_Card.RC_Id);

                        break;
                      case "Identity card":
                            $("#ID_Id").val(response.Identity_card.ID_Id);
                            $("#identityC_Year").val(response.Identity_card.ID_TYear);

                        break;
                      case "Residential Certificate":
                            $("#RC_Id").val(response.Residential_Certificate.RL_Id);
                            $("#residentialL_For").val(response.Residential_Certificate.RL_For);
                            $("#residentialL_Year").val(response.Residential_Certificate.RL_TYear);
                        break;
                        case "Other Letter":
                              $("#CUSTL_Id").val(response.Other_Letter.CL_Id);
                          break;
                      default:

                    }
                  }else if (response.workdata.Work_Subcategory == "Complaint") {
                    $("#complaint_type").val(response.workdata.W_CType).change();
                    $("#complaint_cat").val(response.workdata.W_CCat).change();
                  }
              break;
            case "Invitation":
                if (response.workdata.Work_Subcategory == "Wedding") {
                  $("#invitation_id").val(response.Invitation.I_Id);
                  $("#invitation_address").val(response.Invitation.I_Address);
                  $("#invitation_date").val(response.Invitation.I_Date);
                  $("#invitation_time").val(response.Invitation.I_Time);
                  $("#Wedding_Boy_Name").val(response.Invitation.WI_BName);
                  $("#Wedding_Girl_Name").val(response.Invitation.WI_GName);
                }else {
                  $("#invitation_id").val(response.Invitation.I_Id);
                  $("#invitation_address").val(response.Invitation.I_Address);
                  $("#invitation_date").val(response.Invitation.I_Date);
                  $("#invitation_time").val(response.Invitation.I_Time);
                  $("#invitation_title").val(response.Invitation.I_Title);
                }
              break;
            case "Job":
                $("#job_id").val(response.Job.J_Id);
                $("#job_name").val(response.Job.J_Name);
                $("#job_dob").val(response.Job.J_Dob);
                $("#job_gender").val(response.Job.J_Gender).change();
                $("#job_relation").val(response.Job.J_Relative).change();
                $("#job_email").val(response.Job.J_Email);
                $("#job_phone").val(response.Job.J_Phone);
                $("#job_qualification").val(response.Job.J_Qualification);
                $("#job_exp").val(response.Job.J_Exp);
                $("#job_company").val(response.Job.J_Old_Company);
              break;
            case "Personal":
                switch (response.workdata.Work_Subcategory) {
                  case "Education":
                        $("#education_id").val(response.Education.E_Id);
                        $("#student_name").val(response.Education.E_Student_Name);
                        $("#collage_Name").val(response.Education.E_Collage_Name);
                        $("#student_class").val(response.Education.E_Class);
                        $("#student_fee_total").val(response.Education.E_T_Fee);
                        $("#student_discount_fee").val(response.Education.E_D_Fee);
                    break;
                  case "Medical Letter":
                        $("#medical_id").val(response.Medical.ML_Id);
                        $("#patient_name").val(response.Medical.ML_PName);
                        $("#patient_dob").val(response.Medical.ML_PDob);
                        $("#patient_gender").val(response.Medical.ML_PGender).change();
                        $("#patient_relation").val(response.Medical.ML_PRelation).change();
                        $("#hospital_name").val(response.Medical.ML_Hospital);
                        $("#hospital_ward").val(response.Medical.ML_Ward);
                        $("#hospital_bed").val(response.Medical.ML_Bed);
                        $("#admit_date").val(response.Medical.ML_Admit_Date);
                        $("#Disease").val(response.Medical.ML_Disease);
                    break;
                  default:
                }
              break;
            default:
          }
      }
 });

}

function Make_Change_btn(){
  window.location = '../addVisitor/addvisitor.php?wId='+$("#work_id_make_change").val();
  // location.reload(true);
}
