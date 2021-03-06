$(document).ready(function(){

    fill_table();

    function fill_table(gov = '', type = '')
    {
        address_dt = $('#address_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                Goverment : gov, Type : type, action : "addressList"
             }
            },
            fixedHeader: true,
            responsive: true,
            // dom: "lBfrtip",
            // buttons: [
            //     {
            //       extend: "csv",
            //       className: "btn-sm mx-2",
            //       text: 'Export'
            //     },
            //     {
            //       extend: "print",
            //       className: "btn-sm"
            //     }
            //   ]
        });
    }

    $(document).on('click', '#filter_fun', function(){
        $('#address_datatable').DataTable().destroy();
        fill_table($("#address_gov_f").val(), $("#address_type_f").val());
    });

     $(document).on('click', '#clear_filter', function(){
        $('#address_datatable').DataTable().destroy();
        fill_table();
    });

});


$("#add_department_btn").on('click', function(){
    $("#add_department_frm")[0].reset();
    $("#addDepBtn").show();
    $("#add_department_div").show();
    $("#messages_department").html('');

    $('#add_department_frm').on('submit', function(event){
        event.preventDefault();
        var fromData_add = new FormData(this);
        fromData_add.append("user_id", $("#user_id").val());
        fromData_add.append("action", "addDepartment");

        $.ajax({
            url:"function.php",
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

                    $("#messages_department").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                    '<br>For any Query - Contact IT Department</div>');

                    address_dt.ajax.reload(null, false);
                    $("#addDepBtn").hide();
                    $("#add_department_div").hide();

                }else{
                    $("#messages_department").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');

                    address_dt.ajax.reload(null, false);
                    $("#addDepBtn").hide();
                    $("#add_department_div").hide();
                }

            }
        });

    });

});

$("#add_address_btn").on('click', function(){
    $("#add_address_frm")[0].reset();
    $("#addBtn").show();
    $("#add_address_div").show();
    $("#messages").html('');

    $('#add_address_frm').on('submit', function(event){
        event.preventDefault();
        var fromData_add = new FormData(this);
        fromData_add.append("user_id", $("#user_id").val());
        fromData_add.append("action", "addAddress");

        $.ajax({
            url:"function.php",
            type:"post",
            data:fromData_add,
            contentType:false,
            processData:false,
            dataType : "json",
            success:function(response)
            {
                // alert(response);

                if(response.success == true){

                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                    '<br>For any Query - Contact IT Department</div>');

                }else{

                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');

                }

                address_dt.ajax.reload(null, false);
                $("#addBtn").hide();
                $("#add_address_div").hide();

            }
        });

    });

});


function rmoveAddress(Id){
    $("#remove_Paragraph").show();
    $("#rmoveBtn").show();
    $("#removeMsg").html('');
    if(Id){
        // alert(Id);
        $("#rmoveBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {Address_Id : Id, user_id : $("#user_id").val(), action : "removeAddress"},
                dataType : "json",
                success:function(response){

                    // alert(response)

                    if(response.success == true){
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                    }

                    $("#remove_Paragraph").hide();
                    $("#rmoveBtn").hide();
                    $("#rmKaryModelBtn").html("Close");
                    address_dt.ajax.reload(null, false);
                }
            });
        });
    }else{
        alert("Error: Refresh the page again");
    }
}

function editAddress(Id){
    if(Id){

            $("#messages_up").html("");
            $("#update_address_frm")[0].reset();
            $("#updateBtn").show();
            $("#update_div").show();

            $.ajax({
                url : "function.php",
                type : "Post",
                data : {Address_Id : Id, action : "getSingleAddressData"},
                dataType : "json",
                success:function(response){

                    // alert(response);
                    $("#address_Id_up").val(response.ADD_Id);
                    $("#address_up").val(response.ADD_Address);
                    $("#address_type_up").val(response.ADD_Type);
                    $("#address_pincode_up").val(response.ADD_Pincode);
                    $("#address_gov_up").val(response.ADD_Gov);
                    $("#address_detail_up").val(response.ADD_Detail);



                    $('#update_address_frm').on('submit', function(event){
                        event.preventDefault();
                        var fromData_update = new FormData(this);
                        fromData_update.append("user_id",$("#user_id").val());
                        fromData_update.append("action", "updateAddress");

                        $.ajax({
                            url:"function.php",
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


                                }else{
                                    $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                    '</div>');

                                }

                                address_dt.ajax.reload(null, false);
                                $("#update_div").hide();
                                $("#updateBtn").hide();

                            }
                        });

                    });
                }
            });

    }else{
        alert("Error: Refresh the page again");
    }
}
