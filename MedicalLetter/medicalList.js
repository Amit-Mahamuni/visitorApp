$(document).ready(function(){

    fill_table();

    function fill_table(status = '', priority = '', date_form = '', date_end = '')
    {
        hospital_dt = $('#hospital_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                status : status, priority : priority, dateform : date_form,  dateend : date_end, action : 'medical_List_retrive'
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

        $('#hospital_datatable').DataTable().destroy();
    
        fill_table($("#work_status_f").val(), $("#work_priority_f").val(), 
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());
    
     });
    
     $(document).on('click', '#clear_filter', function(){
    
        $('#hospital_datatable').DataTable().destroy();
    
        fill_table();
    
     });


    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayMedicalEntry"},
        // dataType : "json",
        success:function(response_t){
            // alert(response_t);
            $("#today_work").html(response_t);

        }
    });


});

function editML(Id){

    // alert(Id);
    $("#messages").html('');
    $("#from_data").show();   

    if(Id){

        getMedicalData(Id);
        $("#removeBtn").hide();
        $("#updateBtn").show();

        //code for add data to database by ajax
        $("#medical_frm").on('submit', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            formData.append("action", "updateMedicalSingleData");
            // formData.append("u_id", "1");  
 
            $.ajax({
                url:"function.php",
                type:"post",
                data:formData,
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

                        hospital_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        // alert(response);

                        $("#from_data").hide();
                        $("#updateBtn").hide();
                        hospital_dt.ajax.reload(null, false);


                    }


                    // alert(response);
                    // // visitor_dt.ajax.reload(null, false);
                    $("#updateBtn").hide();
                    
                }
            });

        });  

    }else{
        alert("Error: no id found Refresh the page again");
    }
}





function rmoveML(Id){

    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getMedicalData(Id);
        $("#updateBtn").hide();


        $("#removeBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {M_Id : Id, VID: $("#v_id").val(), WID : $("#w_id").val(), UID : $("#user_id").val(), action : "removeMedicalDetail"},
                dataType : "json",
                success:function(response){

                    // alert(response);

                    if(response.success == true){
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Remove from Database.'+
                        '<br>For Restore - Contact IT Department</div>');
                            $("#from_data").hide();
                            $("#removeBtn").hide();
                            //    $("#rmKaryModelBtn").html("Close");
                            hospital_dt.ajax.reload(null, false);
                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                        '</div>');
                        // alert(response.messages);
                            $("#from_data").hide();
                            $("#removeBtn").hide();
                            hospital_dt.ajax.reload(null, false);
                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}



function getMedicalData(Id){
    // alert(Id);

    $('#medical_frm')[0].reset();

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {M_Id : Id, action: "getMedicalData"},
        dataType : "json",
        success:function(response){
          
            // alert(response);

            $("#medical_id_txt").html(' '+response.ML_Id);
            $("#work_id_txt").html(' '+response.W_Id);

            $("#w_id").val(response.W_Id);
            $("#v_id").val(response.V_Id);
            $("#work_status").val(response.Status);
            $("#work_priority").val(response.Priority);
            $("#work_title").val(response.Work_title);
            $("#work_detail").val(response.Work_detail);

            $("#m_Id").val(response.ML_Id);
            $("#patient_name").val(response.ML_PName);
            $("#patient_dob").val(response.ML_PDob);
            $("#patient_gender").val(response.ML_PGender);
            $("#patient_relation").val(response.ML_PRelation);
            $("#hospital_name").val(response.ML_Hospital);
            $("#hospital_ward").val(response.ML_Ward);
            $("#hospital_bed").val(response.ML_Bed);
            $("#admit_date").val(response.ML_Admit_Date);
            $("#Disease").val(response.ML_Disease);

            $("#visitor_name").val(response.V_Name);
            $("#visitor_voter").val(response.J_Dob);
            $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
            $("#visitor_detail").val(response.V_Gender+" | "+response.V_Dob);
            $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);
         
            
            
            if(response.Visitor_Profile != null || response.Visitor_Profile == ""){
                $("#visitor_profile_div").show();
                var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;

                $('#visitor_profile').attr('src', visitor_profile_path);
                $('#visitor_pro_downoad').attr('href', visitor_profile_path);

            }else{
                $("#visitor_profile_div").hide();
            }

            if(response.Work_Doc != null || response.Work_Doc == ""){
                $("#work_doc_div").show();

                var work_file_path = "../image/Work_File/"+response.Work_Doc;

                var extension = work_file_path.split('.').pop().toLowerCase();

                if(extension != '')
                {
                    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                    {
                        //not a image
                        $('#work_doc').attr('src', '../image/icon/pdf.png');
                        $('#work_doc_downoad').attr('href', work_file_path);

                    }else{
                        //image
                        $('#work_doc').attr('src', work_file_path);
                        $('#work_doc_downoad').attr('href', work_file_path);
                    }

                }

            }else{
                $("#work_doc_div").hide();
            }

            if(response.ML_Final_Letter != null || response.ML_Final_Letter == ""){
                $("#m_final_letter_div").show();
                var Medical_FL_path = "../image/Work_File/ml_letter/"+response.ML_Final_Letter;
                $('#m_final_letter').attr('href', Medical_FL_path);

            }else{
                $("#m_final_letter_div").hide();
            }
            
        }
        
    });
    
}

function detailWork(Id){
    // alert("Work Id is"+Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}

