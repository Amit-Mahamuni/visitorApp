$(document).ready(function(){

    // education_dt = $("#education_datatable").DataTable({
    //     "ajax" : "edicationList_retrive.php",
    //     "order" : []
    //   });

    fill_table();

    function fill_table(pri = '', status = '',  date_form = '', date_end = '')
    {
        education_dt = $('#education_datatable').DataTable({
            "order" : [],
            "ajax" : {
            url:"edicationList_retrive.php",
            type:"POST",
            data:{
                priorty : pri, status : status, dateform : date_form,  dateend : date_end
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

        $('#education_datatable').DataTable().destroy();
    
        fill_table($("#work_priority_f").val(), $("#work_status_f").val(), 
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());
    
    });
    
    $(document).on('click', '#clear_filter', function(){
    
        $('#education_datatable').DataTable().destroy();
    
        fill_table();
    
    });
  
  
    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayWorkEntry"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#today_total_work").html(response_t);

        }
    });

});

function editEducation(Id){
    // alert(Id);
    $("#messages").html('');
    $("#from_data").show();   

    if(Id){

        getEducationData(Id);
        $("#removeBtn").hide();
        $("#updateBtn").show();

        //code for add data to database by ajax
        $("#education_frm").on('submit', function(event){
            // alert("asda");
            event.preventDefault();
            var error = '';
            var extension = $('#student_profile').val().split('.').pop().toLowerCase();

            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Invalid Image File");
                    error += "<p>Invalid Image File</p>";
                    $('#student_profile').val('');
                    return false;
                }
            }            

            if(error == '')
            { 
                $.ajax({
                    url:"updateEducationDetail.php",
                    type:"post",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    dataType : "json",
                    success:function(response)
                    {
                        // alert(response);

                        if(response.success == true){

                            //alert(response.messages);
    
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                            '<br>For any Query - Contact IT Department</div>');
    
                           $("#from_data").hide();
                           $("#updateBtn").hide();
                        //    $("#rmKaryModelBtn").html("Close");
    
                             education_dt.ajax.reload(null, false);
    
                        }else{
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                           '</div>');
    
                            // alert(response);
    
                            $("#from_data").hide();
                            $("#updateBtn").hide();
                            education_dt.ajax.reload(null, false);
    
    
                        }


                        // alert(response);
                        // // visitor_dt.ajax.reload(null, false);
                        // $("#updateBtn").hide();
                        
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

function removeEducation(Id){
    
    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getEducationData(Id);
        $("#updateBtn").hide();


        $("#removeBtn").unbind('click').bind('click', function(){
            alert($("#user_id").val());
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {E_Id : Id, VID : $("#v_id").val(), WID : $("#w_id").val(), U_ID : $("#user_id").val(), action : "removeEducation"},
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

                            education_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                        '</div>');

                        // alert(response.messages);

                        $("#from_data").hide();
                        $("#removeBtn").hide();
                        education_dt.ajax.reload(null, false);

                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}


function getEducationData(Id){
    // alert(Id);
    $('#education_frm')[0].reset();

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {education_Id : Id, action: "getDataEducation"},
        dataType : "json",
        success:function(response){

            // `E_Id`, `E_Student_Name`, `E_Collage_Name`, `E_Class`, `E_T_Fee`, `E_D_Fee`, `V_Id`, `W_Id`, `E_Visibility`
            // alert(response);

            $("#e_id").val(response.E_Id);
            $("#v_id").val(response.V_Id);
            $("#w_id").val(response.W_Id);
            $("#Education_id_txt").html('<strong>'+response.E_Id+'</strong>');

            $("#student_name").val(response.E_Student_Name);
            $("#collage_Name").val(response.E_Collage_Name);
            $("#student_class").val(response.E_Class);
            $("#student_discount_fee").val(response.E_D_Fee);
            $("#student_fee_total").val(response.E_T_Fee);
           
            
            var invition_card_path = "../image/Work_File/"+response.Work_Doc;
            if(response.Work_Doc != null || response.Work_Doc == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#student_img_pre').attr('src', invition_card_path);
            }           
           
        }
        
    });
    
}

function detailWork(Id){
    // alert("Work Id is"+Id);
    window.location = '../workdetail/workdetail.html?Id=' + Id;
}


var input = document.querySelector("#student_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#student_img_pre");
        img.setAttribute("src", result);
    }
}