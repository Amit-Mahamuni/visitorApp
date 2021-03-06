$(document).ready(function(){

    fill_table();

    function fill_table(stat = '', cate = '')
    {
        connector_dt = $('#connector_datatable').DataTable({
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
            // buttons: [
            //     'print',
            //     {
            //         extend: 'csvHtml5',
            //         text: 'Export',
            //         bom: true,
            //     }
            // ],
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
              ]
        });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#connector_datatable').DataTable().destroy();

        fill_table($("#adhikari_status_f").val(), $("#adhikari_department_f").val());

    });

     $(document).on('click', '#clear_filter', function(){

        $('#connector_datatable').DataTable().destroy();

        fill_table();

    });


    connectorOccupation_dt = $('#connectorOccupation_datatable').DataTable({
        "order" : [],
        "ajax" : {
         url:"function.php",
         type:"POST",
         data:{
            action : "getOccputionList"
         },
        },
        fixedHeader: true,
        responsive: true,
    });



    // $(document).on('change','#adhikari_department_up',function(){
    //     var adhikariDep_txt_up = $(this).val();
    //     $.ajax({
    //         url:"function.php",
    //         method:"post",
    //         data : {adhikari_department : adhikariDep_txt_up, action : 'getOccupationsDetail'},
    //         success:function(response)
    //         {   // alert(response);
    //             $("#adhikari_occupation_up").html(response);
    //         }
    //     });
    // });
    //
    // $(document).on('change','#adhikari_department',function(){
    //     var adhikariDep_txt = $(this).val();
    //     $.ajax({
    //         url:"function.php",
    //         method:"post",
    //         data : {adhikari_department : adhikariDep_txt, action : 'getOccupationsDetail'},
    //         success:function(response)
    //         {   // alert(response);
    //             $("#adhikari_occupation").html(response);
    //         }
    //     });
    // });

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
            $("#connector_city").append('<option>'+response[i].ADD_Address+'</option>');
        }
      }
  });

$(document).on('change','#connector_city',function(){
    var addressCity_txt = $(this).val();
    for(var i=0; i <= addressArry.length; i++){
        if(addressCity_txt == addressArry[i].ADD_Address){
          $("#connector_pincode").val(addressArry[i].ADD_Pincode);
        }
    }
});



});


$("#add_connector_btn").on('click', function(){
    $("#add_connector_frm")[0].reset();
    $("#addConnBtn").show();
    $("#add_connector_div").show();
    $("#messages").html('');

    $('#add_connector_frm').on('submit', function(event){
        event.preventDefault();
        var fromData_add = new FormData(this);
        fromData_add.append("user_id", $("#user_id").val());
        var error = '';

        var extension = $('#connector_profile').val().split('.').pop().toLowerCase();
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

                        connector_dt.ajax.reload(null, false);
                        $("#addConnBtn").hide();
                        $("#add_connector_div").hide();

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        connector_dt.ajax.reload(null, false);
                        $("#addConnBtn").hide();
                        $("#add_connector_div").hide();
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


function rmoveConnector(Id){
    $("#remove_Paragraph").show();
    $("#rmoveBtn").show();
    $("#removeMsg").html('');
    if(Id){
        // alert(Id);
        $("#rmoveBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "remove.php",
                type : "Post",
                data : {connector_id : Id, user_id : $("#user_id").val()},
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

                       connector_dt.ajax.reload(null, false);

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       connector_dt.ajax.reload(null, false);

                    }
                }
            });
        });
    }else{
        alert("Error: Refresh the page again");
    }
}


function editConnector(Id){
    if(Id){

            $("#messages_up").html("");
            $("#update_connector_frm")[0].reset();
            $("#updateConnBtn").show();
            $("#update_div").show();

            $.ajax({
                url : "getSelectedRow.php",
                type : "Post",
                data : {Connector_Id : Id},
                dataType : "json",
                success:function(response){

                  // `CO_Id`, `CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`, `CO_Address`,
                  // `CO_City`, `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`, `CO_Profile_img`

                    // alert(response.Name);
                    $("#connector_id_txt").html(" Id : "+response.CO_Id);
                    $("#connector_Id_up").val(response.CO_Id);
                    $("#connector_name_up").val(response.CO_Name);
                    $("#connector_phone_up").val(response.CO_Phone);
                    $("#connector_email_up").val(response.CO_Mail);
                    $("#connector_gender_up").val(response.CO_Gender);
                    $("#connector_dob_up").val(response.CO_Dob);
                    $("#connector_address_up").val(response.CO_Address);
                    $("#connector_city_up").val(response.CO_City);
                    $("#connector_pincode_up").val(response.CO_Pincode);
                    $("#connector_status_up").val(response.CO_Status);
                    $("#connector_occupation_up").val(response.CO_Occupation);

                    var profile_path = "../image/Connector_Profile/"+response.CO_Profile_img;
                    if(response.CO_Profile_img != null || response.CO_Profile_img == ""){

                        $('#connector_img_pre_up').attr('src', profile_path);
                        $('#connector_pro_href').attr('href', profile_path);
                    }

                    $('#update_connector_frm').on('submit', function(event){
                        event.preventDefault();
                        var fromData_update = new FormData(this);
                        fromData_update.append("user_id", $("#user_id").val());
                        var error = '';

                        var extension = $('#connector_profile_up').val().split('.').pop().toLowerCase();
                        if(extension != '')
                        {
                            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                            {
                                alert("Invalid Image File");
                                error += "<p>Invalid Image File</p>";
                                $('#connector_profile_up').val('');
                                return false;
                            }
                        }

                        if(error == '')
                        {
                            $.ajax({
                                url:"update.php",
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

                                        connector_dt.ajax.reload(null, false);
                                        $("#update_div").hide();

                                    }else{
                                        $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                       '</div>');

                                        connector_dt.ajax.reload(null, false);
                                        $("#update_div").hide();

                                    }

                                    $("#updateConnBtn").hide();

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


var input = document.querySelector("#connector_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#connector_img_pre");
        img.setAttribute("src", result);
    }
}

var input_up = document.querySelector("#connector_profile_up");
input_up.addEventListener('change',preview_karykarta_profile_up);
function preview_karykarta_profile_up(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#connector_img_pre_up");
        img.setAttribute("src", result);
    }
}


function infoConnector(Id){
    // alert(Id);
    window.location = '../connector/connectorDetail.php?Id=' + Id;
}

function editOccupation(Id){

  // alert(Id);

  $("#add_occupation_frm")[0].reset();

  $.ajax({
        url:"function.php",
        type:"post",
        data:{occupation_id : Id, action : "getSingleOccupationData"},
        dataType : "json",
        success:function(response)
        {
          // alert(response);
          // `CN_Id`, `CN_Occupation_mr`, `CN_Occupation_en`, `ADD_Id`, `CN_Detail`
          $("#occupation_id").val(response.CN_Id);
          $("#Occupation_name_mr").val(response.CN_Occupation_mr);
          $("#Occupation_name_en").val(response.CN_Occupation_en);
          $("#Occupation_detail").val(response.CN_Detail);

        }

  });


}






$('#add_occupation_btn').on('click', function(){

    $.ajax({
        url:"function.php",
        type:"post",
        data:{user_id : $("#user_id").val(), action : "addConnectorOccupation"
        , occupation_id : $("#occupation_id").val(), Occupation_name_mr : $("#Occupation_name_mr").val()
        , Occupation_name_en : $("#Occupation_name_en").val() , Occupation_detail : $("#Occupation_detail").val()},
        dataType : "json",
        success:function(response)
        {
            if(response.success == true){

                $("#occupation_messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
               '<br>For any Query - Contact IT Department</div>');

                connectorOccupation_dt.ajax.reload(null, false);
                $("#add_occupation_frm")[0].reset();

            }else{
                $("#occupation_messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
               '</div>');

                connectorOccupation_dt.ajax.reload(null, false);
                $("#add_occupation_frm")[0].reset();

            }

        }
    });

});

function rmoveOccupation(Id){
  // alert(Id);
  $.ajax({
      url:"function.php",
      type:"post",
      data:{user_id : $("#user_id").val(), action : "deleteConnectorOccupation"
      , occupation_id : Id},
      dataType : "json",
      success:function(response)
      {
          if(response.success == true){

              $("#occupation_messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
             '<br>For any Query - Contact IT Department</div>');

              connectorOccupation_dt.ajax.reload(null, false);
              // $("#add_occupation_frm")[0].reset();

          }else{
              $("#occupation_messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
             '</div>');

              connectorOccupation_dt.ajax.reload(null, false);
              // $("#add_occupation_frm")[0].reset();

          }

      }
  });
}
