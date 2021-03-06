$(document).ready(function(){

    fill_table();

    function fill_table(dep = '')
    {
        department_dt = $('#department_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                department : dep, action : "departmentList"
             }
            },
            fixedHeader: true,
            responsive: true,
            dom: "lBfrtip",
            buttons: [
                {
                  extend: "csv",
                  className: "btn-sm mx-2",
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
        $('#department_datatable').DataTable().destroy();
        fill_table($("#adhikari_department_f").val());
    });

     $(document).on('click', '#clear_filter', function(){
        $('#department_datatable').DataTable().destroy();
        fill_table();
    });


    $(document).on('change','#address_type',function(){
        var address_type_txt = $(this).val();
        $.ajax({
            url:"function.php",
            method:"post",
            data : {address_type : address_type_txt, action : 'getAddressDetail'},
            success:function(response)
            {   // alert(response);
                $("#address_name").html(response);
            }
        });
    });

    $(document).on('change','#address_type_occ',function(){
        var address_type_txt_occ = $(this).val();
        $.ajax({
            url:"function.php",
            method:"post",
            data : {address_type : address_type_txt_occ, action : 'getAddressDetail'},
            success:function(response)
            {   // alert(response);
                $("#address_name_occ").html(response);
            }
        });
    });

    $(document).on('change','#address_type_up',function(){
        var address_type_txt_up = $(this).val();
        $.ajax({
            url:"function.php",
            method:"post",
            data : {address_type : address_type_txt_up, action : 'getAddressDetail'},
            success:function(response)
            {   // alert(response);
                $("#address_name_up").html(response);
            }
        });
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

                    department_dt.ajax.reload(null, false);
                    $("#addDepBtn").hide();
                    $("#add_department_div").hide();

                }else{
                    $("#messages_department").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');

                    department_dt.ajax.reload(null, false);
                    $("#addDepBtn").hide();
                    $("#add_department_div").hide();
                }

            }
        });

    });

});

$("#add_occupation_btn").on('click', function(){
    $("#add_occupation_frm")[0].reset();
    $("#addOccBtn").show();
    $("#add_occ_div").show();
    $("#messages_occupation").html('');

    $('#add_occupation_frm').on('submit', function(event){
        event.preventDefault();
        var fromData_add = new FormData(this);
        fromData_add.append("user_id", $("#user_id").val());
        fromData_add.append("action", "addOccupation");

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

                    $("#messages_occupation").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                    '<br>For any Query - Contact IT Department</div>');

                    department_dt.ajax.reload(null, false);
                    $("#addOccBtn").hide();
                    $("#add_occ_div").hide();

                }else{
                    $("#messages_occupation").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');

                    department_dt.ajax.reload(null, false);
                    $("#addOccBtn").hide();
                    $("#add_occ_div").hide();
                }

            }
        });

    });

});


function rmoveDepartment(Id){
    $("#remove_Paragraph").show();
    $("#rmoveBtn").show();
    $("#removeMsg").html('');
    if(Id){
        // alert(Id);
        $("#rmoveBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {department_id : Id, user_id : $("#user_id").val(), action : "removeDepartment"},
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

                       department_dt.ajax.reload(null, false);

                    }else{
                        $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                       '</div>');

                       $("#remove_Paragraph").hide();
                       $("#rmoveBtn").hide();
                       $("#rmKaryModelBtn").html("Close");

                       department_dt.ajax.reload(null, false);

                    }
                }
            });
        });
    }else{
        alert("Error: Refresh the page again");
    }
}

function editDepartment(Id){
    if(Id){

            $("#messages_up").html("");
            $("#update_department_frm")[0].reset();
            $("#updateDepBtn").show();
            $("#add_update_div").show();

            $.ajax({
                url : "function.php",
                type : "Post",
                data : {Department_Id : Id, action : "getSingleDepartmentData"},
                dataType : "json",
                success:function(response){

                    // alert(response);
                    $("#department_up_id").val(response.ADE_Id);
                    $("#department_up").val(response.ADE_Department);
                    $("#occupation_up").val(response.ADE_Occupation);
                    $("#department_detail_up").val(response.ADE_Detail);
                    $("#department_add_txt").val(response.ADD_Address+" - ( "+response.ADD_Type+" )");


                    $('#update_department_frm').on('submit', function(event){
                        event.preventDefault();
                        var fromData_update = new FormData(this);
                        fromData_update.append("user_id", $("#user_id").val());
                        fromData_update.append("action", "updateDepartment");

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

                                    department_dt.ajax.reload(null, false);
                                    $("#add_update_div").hide();

                                }else{
                                    $("#messages_up").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                                    '</div>');

                                    department_dt.ajax.reload(null, false);
                                    $("#add_update_div").hide();

                                }

                                $("#updateDepBtn").hide();

                            }
                        });

                    });
                }
            });

    }else{
        alert("Error: Refresh the page again");
    }
}
