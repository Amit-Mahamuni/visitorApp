$(document).ready(function(){

    fill_table();

    function fill_table(status = '', cate = '',  date_form = '', date_end = '')
    {
        job_dt = $('#job_datatable').DataTable({
            "order" : [],
            // "scrollX": "100%",
            "ajax" : {
             url:"job_List_retrive.php",
             type:"POST",
             data:{
                status : status, category : cate, dateform : date_form,  dateend : date_end
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

        $('#job_datatable').DataTable().destroy();
    
        fill_table($("#work_status_f").val(), $("#work_category_f").val(), 
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());
    
     });
    
     $(document).on('click', '#clear_filter', function(){
    
        $('#job_datatable').DataTable().destroy();
    
        fill_table();
    
     });



    // job_dt = $("#job_datatable").DataTable({
    //     "ajax" : "job_List_retrive.php",
    //     "order" : []
    // });

    $("#job_resume").hide();


    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayJobEntry"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#today_Job_work").html(response_t);

        }
    });


});

function editJob(Id){

    // alert(Id);
    $("#messages").html('');
    $("#from_data").show();   

    if(Id){

        getjobData(Id);
        $("#removeBtn").hide();
        $("#updateBtn").show();

        //code for add data to database by ajax
        $("#job_frm").on('submit', function(event){
            event.preventDefault();
            var error = '';
            var extension = $('#job_profile').val().split('.').pop().toLowerCase();

            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg', 'pdf']) == -1)
                {
                    alert("Invalid Image File");
                    error += "<p>Invalid Image File</p>";
                    $('#job_profile').val('');
                    return false;
                }
            }            

            if(error == '')
            { 
                $.ajax({
                    url:"updateJobDetail.php",
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
    
                            job_dt.ajax.reload(null, false);
    
                        }else{
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                           '</div>');
    
                            // alert(response);
    
                            $("#from_data").hide();
                            $("#updateBtn").hide();
                            job_dt.ajax.reload(null, false);
    
    
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





function rmoveJob(Id){

    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getjobData(Id);
        $("#updateBtn").hide();


        $("#removeBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {J_Id : Id, VID: $("#v_id").val(), WID : $("#w_id").val(), UID : $("#user_id").val(), action : "removeJobDetail"},
                dataType : "json",
                success:function(response){

                    if(response.success == true){

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Remove from Database.'+
                        '<br>For Restore - Contact IT Department</div>');

                            $("#from_data").hide();
                            $("#removeBtn").hide();
                            //    $("#rmKaryModelBtn").html("Close");

                            job_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                        '</div>');

                        // alert(response.messages);

                            $("#from_data").hide();
                            $("#removeBtn").hide();
                            job_dt.ajax.reload(null, false);

                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}


function getjobData(Id){
    // alert(Id);

    $('#job_frm')[0].reset();

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {job_Id : Id, action: "getData"},
        dataType : "json",
        success:function(response){

            $("#j_id").val(response.J_Id);
            $("#v_id").val(response.V_Id);
            $("#w_id").val(response.W_Id);
            $("#Job_id_txt").html('<strong>'+response.J_Id+'</strong>');

            $("#work_status").val(response.Status);
            $("#job_name").val(response.J_Name);
            $("#job_dob").val(response.J_Dob);
            $("#job_gender").val(response.J_Gender);
            $("#job_relation").val(response.J_Relative);
            $("#job_email").val(response.J_Email);
            $("#job_phone").val(response.J_Phone);
            $("#job_qualification").val(response.J_Qualification);
            $("#job_exp").val(response.J_Exp);
            $("#job_company").val(response.J_Old_Company);
            $("#job_type").val(response.J_Type);
         
            
            var job_resume_path = "../image/Work_File/"+response.Work_Doc;
            if(response.Work_Doc != null || response.Work_Doc == ""){

                $('#job_img_pre').attr('src', job_resume_path);

                var extension = job_resume_path.split('.').pop().toLowerCase();

                if(extension != '')
                {
                    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                    {
                        $('#job_img_pre').attr('src', job_resume_path);
                        $("#job_resume").hide();
                        $('#job_resume').attr('href', job_resume_path);

                    }else{
                        $('#job_resume').attr('href', job_resume_path);

                        $("#job_resume").show();
                    }
                }
            }else{

                $("#job_resume").hide();

            }
            
            


           
        }
        
    });
    
}




function detailWork(Id){
    // alert("Work Id is"+Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}



var input = document.querySelector("#job_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#job_img_pre");
        img.setAttribute("src", result);
    }
}