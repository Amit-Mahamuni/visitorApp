$(document).ready(function(){

    fill_table();

    function fill_table(pri = '', status = '', cate = '',  date_form = '', date_end = '')
    {
        invitation_dt = $('#invitation_datatable').DataTable({
            "order" : [],
            // "scrollX": "100%",
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                priorty : pri, status : status, category : cate, dateform : date_form,  dateend : date_end, action : 'invitation'
             }
            }
        });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#invitation_datatable').DataTable().destroy();
    
        fill_table($("#work_priority_f").val(), $("#work_status_f").val(), 
                    $("#work_category_f").val(),
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());
    
     });
    
     $(document).on('click', '#clear_filter', function(){
    
        $('#invitation_datatable').DataTable().destroy();
    
        fill_table();
    
     });


    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayWorkEntry_invitation"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#today_total_work").html(response_t);

        }
    });


});


function editInvitation(Id){

    // alert(Id);
    $("#messages").html('');
    $("#from_data").show();   

    if(Id){

        getInvitationData(Id);
        $("#removeBtn").hide();
        $("#updateBtn").show();

        //code for add data to database by ajax
        $("#invitation_frm").on('submit', function(event){
            event.preventDefault();
            var error = '';
            var extension = $('#invitation_profile').val().split('.').pop().toLowerCase();

            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Invalid Image File");
                    error += "<p>Invalid Image File</p>";
                    $('#invitation_profile').val('');
                    return false;
                }
            }            

            if(error == '')
            { 
                $.ajax({
                    url:"../invitation/updateInvitationDetail.php",
                    type:"post",
                    data:new FormData(this),
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
    
                           $("#from_data").hide();
                           $("#updateBtn").hide();
    
                            invitation_dt.ajax.reload(null, false);
    
                        }else{
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                           '</div>');
    
                            $("#from_data").hide();
                            $("#updateBtn").hide();
                            invitation_dt.ajax.reload(null, false);    
    
                        }
                        
                    }
                });
            }
            else
            {
                alert(error);
            }
        });  

    }else{
        alert("Error: no id found Refresh the page again");
    }
}


function rmoveInvitation(Id){

    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getInvitationData(Id);
        $("#updateBtn").hide();


        $("#removeBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {WI_Id : Id, VID: $("#v_id").val(), WID : $("#w_id").val(), action : "removeInvitation"},
                dataType : "json",
                success:function(response){

                    // alert(response);

                    if(response.success == true){

                        // alert(response.messages);

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Remove from Database.'+
                        '<br>For Restore - Contact IT Department</div>');

                       $("#from_data").hide();
                       $("#removeBtn").hide();
                    //    $("#rmKaryModelBtn").html("Close");

                         invitation_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                        '</div>');

                        // alert(response.messages);

                        $("#from_data").hide();
                        $("#removeBtn").hide();
                        invitation_dt.ajax.reload(null, false);

                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}



function getInvitationData(Id){
    // alert(Id);
    $('#invitation_frm')[0].reset();

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {invition_Id : Id, action: "getData"},
        dataType : "json",
        success:function(response){
            // `I_Id`, `I_Title`, `I_Address`, `I_Date`, `I_Time`, `I_Type`, `I_Visibility`, `I_Status`, `W_Id`, `V_Id`, `WI_BName`, `WI_GName`
            // alert(response);

            $("#i_id").val(response.I_Id);
            $("#v_id").val(response.V_Id);
            $("#w_id").val(response.W_Id);
            $("#Invitation_id_txt").html('<strong>'+response.I_Id+'</strong>');

            $("#invitation_date").val(response.I_Date);
            $("#invitation_time").val(response.I_Time);
            $("#invitation_address").val(response.I_Address);
            $("#invitation_status").val(response.I_Status);
            $("#invitation_type").val(response.I_Type);
            $("#invitation_type_txt").val(response.I_Type);
            $("#invitation_title").val(response.I_Title);

            if(response.I_Type == "Wedding" && response.WI_BName !="" &&  response.WI_GName !=""){
                $("#Wedding_Boy_Name").val(response.WI_BName);
                $("#Wedding_Girl_Name").val(response.WI_GName);
                $("#wedding_info").show();
            }else{
                $("#wedding_info").hide();
            }            
            
            var invition_card_path = "../image/Work_File/"+response.Work_Doc;
            if(response.Work_Doc != null || response.Work_Doc == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#invitation_img_pre').attr('src', invition_card_path);
            }           
           
        }
        
    });
    
}
