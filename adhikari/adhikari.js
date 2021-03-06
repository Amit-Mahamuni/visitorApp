$(document).ready(function(){

    fill_table();

    function fill_table(stat = '', cate = '')
    {
        adhikari_dt = $('#adhikari_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"retrive.php",
             type:"POST",
             data:{
                status : stat, category : cate
             }
            },
            fixedHeader: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
                'print',
                {
                    extend: 'csvHtml5',
                    text: 'Export',
                    bom: true,
                }
            ],
        });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#adhikari_datatable').DataTable().destroy();

        fill_table($("#adhikari_status_f").val(), $("#adhikari_department_f").val());

    });

     $(document).on('click', '#clear_filter', function(){

        $('#adhikari_datatable').DataTable().destroy();

        fill_table();

    });



    $(document).on('change','#adhikari_department_up',function(){
        var adhikariDep_txt_up = $(this).val();
        $.ajax({
            url:"function.php",
            method:"post",
            data : {adhikari_department : adhikariDep_txt_up, action : 'getOccupationsDetail'},
            success:function(response)
            {   // alert(response);
                $("#adhikari_occupation_up").html(response);
            }
        });
    });

    $(document).on('change','#adhikari_department',function(){
        var adhikariDep_txt = $(this).val();
        $.ajax({
            url:"function.php",
            method:"post",
            data : {adhikari_department : adhikariDep_txt, action : 'getOccupationsDetail'},
            success:function(response)
            {   // alert(response);
                $("#adhikari_occupation").html(response);
            }
        });
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
                $("#adhikari_city").append('<option>'+response[i].ADD_Address+'</option>');
            }
          }
      });

    $(document).on('change','#adhikari_city',function(){
        var addressCity_txt = $(this).val();
        for(var i=0; i <= addressArry.length; i++){
            if(addressCity_txt == addressArry[i].ADD_Address){
              $("#adhikari_pincode").val(addressArry[i].ADD_Pincode);
            }
        }
    });





});


$("#add_adhikari_btn").on('click', function(){
    $("#add_adhikari_frm")[0].reset();
    $("#addKaryBtn").show();
    $("#add_adhikari_div").show();
    $("#messages").html('');

    $('#add_adhikari_frm').on('submit', function(event){
        event.preventDefault();
        var fromData_add = new FormData(this);
        fromData_add.append("user_id", $("#user_id").val());
        var error = '';

        var extension = $('#adhikari_profile').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
                error += "<p>Invalid Image File</p>";
                $('#visitor_profile').val('');
                return false;
            }
        }

        if(error == '')
        {
            $.ajax({
                url:"insert.php",
                type:"post",
                data:fromData_add,
                contentType:false,
                processData:false,
                dataType : "json",
                success:function(response)
                {
                    // alert(response);

                    if(response.success == true){
                        // alert(response.messages);

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                       '<br>For any Query - Contact IT Department</div>');

                        adhikari_dt.ajax.reload(null, false);
                        $("#addKaryBtn").hide();
                        $("#add_adhikari_div").hide();

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        adhikari_dt.ajax.reload(null, false);
                        $("#addKaryBtn").hide();
                        $("#add_adhikari_div").hide();
                    }

                }
            });
        }
        else
        {
            alert(error);
        }
    });

});


function rmoveAdhikari(Id){
    $("#remove_Paragraph").show();
    $("#rmoveBtn").show();
    $("#removeMsg").html('');
    if(Id){
        // alert(Id);
        $("#rmoveBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "remove.php",
                type : "Post",
                data : {adhikari_id : Id, user_id : $("#user_id").val()},
                dataType : "json",
                success:function(response){

                    // alert(response)

                    if(response.success == true){
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       adhikari_dt.ajax.reload(null, false);

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       adhikari_dt.ajax.reload(null, false);

                    }
                }
            });
        });
    }else{
        alert("Error: Refresh the page again");
    }
}


function editKarykarta(Id){
    if(Id){

            $("#messages_up").html("");
            $("#update_adhikari_frm")[0].reset();
            $("#updateAdhBtn").show();
            $("#update_div").show();

            $.ajax({
                url : "getSelectedRow.php",
                type : "Post",
                data : {Adhikari_Id : Id},
                dataType : "json",
                success:function(response){
                        // `AD_Id`, `AD_Name`, `AD_Phone`, `AD_Email`, `AD_GENDER`, `AD_Dob`, `AD_Address`, `AD_City`, `AD_Pincode`,
                        // `AD_Department`, `AD_SubDepartment`, `AD_Occupation`, `AD_Status`, `AD_Visibility`, `AD_Profile_img`
                    // alert(response.Name);
                    $("#adhikari_id_txt").html("Adhikari Id : "+response.AD_Id);
                    $("#adhikari_Id_up").val(response.AD_Id);
                    $("#adhikari_name_up").val(response.AD_Name);
                    $("#adhikari_phone_up").val(response.AD_Phone);
                    $("#adhikari_email_up").val(response.AD_Email);
                    $("#adhikari_gender_up").val(response.AD_GENDER);
                    $("#adhikari_dob_up").val(response.AD_Dob);
                    $("#adhikari_address_up").val(response.AD_Address);
                    $("#adhikari_city_up").val(response.AD_City);
                    $("#adhikari_pincode_up").val(response.AD_Pincode);
                    $("#adhikari_status_up").val(response.AD_Status);
                    $("#adhikari_dep_occ").val(response.AD_Department+" | "+response.AD_Occupation);
                    $("#adhikari_department_up").val(response.AD_Department);
                    $("#adhikari_occupation_up").val(response.AD_Occupation);

                    var adhikari_profile_path = "../image/Adhikari_Profile/"+response.AD_Profile_img;
                    if(response.AD_Profile_img != null || response.AD_Profile_img == ""){
                        // alert("visitor profile path " +visitor_profile_path );
                        $('#adhikari_img_pre_up').attr('src', adhikari_profile_path);
                        $('#adhikari_pro_href').attr('href', adhikari_profile_path);
                    }

                    $('#update_adhikari_frm').on('submit', function(event){
                        event.preventDefault();
                        var fromData_update = new FormData(this);
                        fromData_update.append("user_id", $("#user_id").val());
                        var error = '';

                        var extension = $('#adhikari_profile').val().split('.').pop().toLowerCase();
                        if(extension != '')
                        {
                            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                            {
                                alert("Invalid Image File");
                                error += "<p>Invalid Image File</p>";
                                $('#visitor_profile').val('');
                                return false;
                            }
                        }

                        if(error == '')
                        {
                            $.ajax({
                                url:"updateadhikari.php",
                                type:"post",
                                data:fromData_update,
                                contentType:false,
                                processData:false,
                                dataType : "json",
                                success:function(response)
                                {
                                    // alert(response);

                                    if(response.success == true){

                                        // alert(response.messages);

                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                                       '<br>For any Query - Contact IT Department</div>');

                                        adhikari_dt.ajax.reload(null, false);
                                        $("#update_div").hide();

                                    }else{
                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                       '</div>');

                                        adhikari_dt.ajax.reload(null, false);
                                        $("#update_div").hide();

                                    }

                                    $("#updateAdhBtn").hide();

                                }
                            });
                        }
                        else
                        {
                            alert(error);
                        }
                    });
                }
            });
        // });
    }else{
        alert("Error: Refresh the page again");
    }
}


var input = document.querySelector("#adhikari_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#adhikari_img_pre");
        img.setAttribute("src", result);
    }
}

var input_up = document.querySelector("#adhikari_profile_up");
input_up.addEventListener('change',preview_karykarta_profile_up);
function preview_karykarta_profile_up(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#adhikari_img_pre_up");
        img.setAttribute("src", result);
    }
}


function infoAdhikari(Id){
    // alert(Id);
    window.location = '../adhikari/adhikariDetail.php?Id=' + Id;
}
