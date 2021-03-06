$(document).ready(function(){

    fill_table();

    function fill_table(stat = '', cate = '')
    {
        user_dt = $('#User_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"retrive.php",
             type:"POST",
             data:{
                status : stat, category : cate, action : 'getUserList'
             }
            },
            fixedHeader: true,
            responsive: true,
            dom: 'lBfrtip',
            buttons: [
              {
                extend: "csvHtml5",
                className: "btn-sm",
                text: 'Export'
              },
              {
                extend: "print",
                className: "btn-sm"
              }
            ],
           });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#User_datatable').DataTable().destroy();

        fill_table($("#karykarta_status_f").val(), $("#work_category_f").val() );

     });

     $(document).on('click', '#clear_filter', function(){

        $('#User_datatable').DataTable().destroy();

        fill_table();

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
                 $("#karykarta_city").append('<option>'+response[i].ADD_Address+'</option>');
                  $("#karykarta_city_up").append('<option>'+response[i].ADD_Address+'</option>');
             }
           }
       });

     $(document).on('change','#karykarta_city',function(){
         var addressCity_txt = $(this).val();
         for(var i=0; i <= addressArry.length; i++){
             if(addressCity_txt == addressArry[i].ADD_Address){
               $("#karykarta_pincode").val(addressArry[i].ADD_Pincode);
             }
         }
     });

     $(document).on('change','#karykarta_city_up',function(){
         var addressCity_txt = $(this).val();
         for(var i=0; i <= addressArry.length; i++){
             if(addressCity_txt == addressArry[i].ADD_Address){
               $("#karykarta_pincode_up").val(addressArry[i].ADD_Pincode);
             }
         }
     });


});


$("#add_karykarta_btn").on('click', function(){
    $("#add_karykarta_frm")[0].reset();
    $("#addKaryBtn").show();
    $("#messages").html('');

    $('#add_karykarta_frm').on('submit', function(event){
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("user_id", $("#user_id").val());
        var error = '';

        var extension = $('#karykarta_profile').val().split('.').pop().toLowerCase();
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
                data:formData,
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

                        user_dt.ajax.reload(null, false);
                        $("#addKaryBtn").hide();

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        user_dt.ajax.reload(null, false);
                        $("#addKaryBtn").hide();
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


function rmoveKarykarta(Id){
    $("#remove_Paragraph").show();
    $("#rmoveBtn").show();
    $("#removeMsg").html('');
    if(Id){
        // alert(Id);
        $("#rmoveBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "remove.php",
                type : "Post",
                data : {user_Id : Id, user_id: $("#user_id").val()},
                dataType : "json",
                success:function(response){
                    if(response.success == true){
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       user_dt.ajax.reload(null, false);

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       user_dt.ajax.reload(null, false);

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
            $("#update_karykarta_frm")[0].reset();
            $("#updateKaryBtn").show();
            $("#update_div").show();

            $.ajax({
                url : "getSelectedRow.php",
                type : "Post",
                data : {user_Id : Id},
                dataType : "json",
                success:function(response){
                    // `U_Id`, `U_Status`, `U_Department`, `U_Name`, `U_Phone`, `U_Email`, `U_Gender`, `U_Dob`, `U_Address`, `U_City`, `U_Pincode`, `U_Visibility`, `U_Profile_Img`
                    // alert(response.Name);
                    $("#karykarta_Id_up").val(response.U_Id);
                    $("#karykarta_name_up").val(response.U_Name);
                    $("#karykarta_phone_up").val(response.U_Phone);
                    $("#karykarta_email_up").val(response.U_Email);
                    $("#karykarta_gender_up").val(response.U_Gender);
                    $("#karykarta_dob_up").val(response.U_Dob);
                    $("#karykarta_address_up").val(response.U_Address);
                    $("#karykarta_city_up").val(response.U_City);
                    $("#karykarta_pincode_up").val(response.U_Pincode);
                    $("#karykarta_status_up").val(response.U_Status);
                    $("#karykarta_department_up").val(response.U_Department);
                    $("#user_name_up").val(response.U_Username);
                    $("#user_password_up").val(response.U_Password);

                    var User_profile_path = "../image/User_Profile/"+response.U_Profile_Img;
                    if(response.U_Profile_Img != null || response.U_Profile_Img == ""){
                        // alert("visitor profile path " +visitor_profile_path );
                        $('#karykarta_img_pre_up').attr('src', User_profile_path);
                    }

                    $('#update_karykarta_frm').on('submit', function(event){
                        event.preventDefault();
                        var formData_update = new FormData(this);
                        formData_update.append("user_id", $("#user_id").val());
                        var error = '';

                        var extension = $('#karykarta_profile').val().split('.').pop().toLowerCase();
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
                                url:"updatekarykarta.php",
                                type:"post",
                                data:formData_update,
                                contentType:false,
                                processData:false,
                                dataType : "json",
                                success:function(response)
                                {
                                    if(response.success == true){
                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                                       '<br>For any Query - Contact IT Department</div>');

                                    }else{
                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                       '</div>');
                                    }
                                    user_dt.ajax.reload(null, false);
                                    $("#updateKaryBtn").hide();
                                    $("#update_div").hide();
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


var input = document.querySelector("#karykarta_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#karykarta_img_pre");
        img.setAttribute("src", result);
    }
}

var input_up = document.querySelector("#karykarta_profile_up");
input_up.addEventListener('change',preview_karykarta_profile_up);
function preview_karykarta_profile_up(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#karykarta_img_pre_up");
        img.setAttribute("src", result);
    }
}


function infoKarykarta(Id){
    // alert(Id);
    window.location = '../User/UserDetail.php?Id=' + Id;
}
