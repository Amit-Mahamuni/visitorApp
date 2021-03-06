$(document).ready(function(){

    fill_table();

    function fill_table(stat = '', cate = '')
    {
        karykarta_dt = $('#Karykarta_datatable').DataTable({
            // "processing" : true,
            // "serverSide" : true,
            "order" : [],
            // "scrollX": "100%",
            // "searching" : false,
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

        $('#Karykarta_datatable').DataTable().destroy();

        fill_table($("#karykarta_status_f").val(), $("#work_category_f").val() );

     });

     $(document).on('click', '#clear_filter', function(){

        $('#Karykarta_datatable').DataTable().destroy();

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

                        karykarta_dt.ajax.reload(null, false);
                        $("#addKaryBtn").hide();

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        karykarta_dt.ajax.reload(null, false);
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
                data : {karykarta_Id : Id, user_id: $("#user_id").val()},
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

                       karykarta_dt.ajax.reload(null, false);

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       karykarta_dt.ajax.reload(null, false);

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
                data : {karykarta_Id : Id},
                dataType : "json",
                success:function(response){
                    // `Id`, `Name`, `Phone`, `Email`, `Gender`, `Dob`, `Address`, `City`, `Pincode`, `Status`, `Department`
                    // alert(response.Name);
                    $("#karykarta_Id_up").val(response.K_Id);
                    $("#karykarta_name_up").val(response.K_Name);
                    $("#karykarta_phone_up").val(response.K_Phone);
                    $("#karykarta_email_up").val(response.K_Email);
                    $("#karykarta_gender_up").val(response.K_Gender);
                    $("#karykarta_dob_up").val(response.K_Dob);
                    $("#karykarta_address_up").val(response.K_Address);
                    $("#karykarta_city_up").val(response.K_City);
                    $("#karykarta_pincode_up").val(response.K_Pincode);
                    $("#karykarta_status_up").val(response.K_Status);
                    $("#karykarta_department_up").val(response.K_Department);

                    var Karykarta_profile_path = "../image/Karykarta_Profile/"+response.K_Profile_Img;
                    if(response.K_Profile_Img != null || response.K_Profile_Img == ""){
                        // alert("visitor profile path " +visitor_profile_path );
                        $('#karykarta_img_pre_up').attr('src', Karykarta_profile_path);
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
                                    // alert(response);

                                    if(response.success == true){

                                        // alert(response.messages);

                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                                       '<br>For any Query - Contact IT Department</div>');

                                        // karykarta_dt.ajax.reload(null, false);

                                    }else{
                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                       '</div>');

                                        // karykarta_dt.ajax.reload(null, false);

                                    }


                                    // alert(response);
                                        karykarta_dt.ajax.reload(null, false);
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
    window.location = '../karykartaDetail/karykartaDetail.php?Id=' + Id;
}
