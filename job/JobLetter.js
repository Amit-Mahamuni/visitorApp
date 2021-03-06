$(document).ready(function(){

    var d = new Date();
    var current_Date = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();

    $("#current_date").html(current_Date);

    $("#messages_ml_id").html('');

    var qsParm = new Array();
    var query = window.location.search.substring(1);
    var parms = query.split('&');
    for (var i=0; i < parms.length; i++) {
        var pos = parms[i].indexOf('=');
        if (pos > 0) {
            var key = parms[i].substring(0, pos);
            var val = parms[i].substring(pos + 1);
            qsParm[key] = val;
        }
    } 
    
    var workId = qsParm[key];
    if(parms != ""){   
        
        $("#work_id").html(workId);

        $.ajax({
                    url : "function.php",
                    type : "Post",
                    data : {action : "getVisitorData", Work_Id : workId },
                    dataType : "json",
                    success:function(response){
                        // alert(response);

                        // `J_Id`, `J_Name`, `J_Dob`, `J_Gender`, `J_Email`, `J_Phone`, `J_Qualification`, `J_Exp`, `J_Old_Company`, 
                        // `V_Id`, `W_Id`, `J_Type`, `J_Relative`, `J_Visibility`, `J_LTo`, `J_LSubject`, `J_LDetail`, `J_LSign`, `J_LFinal` 
                        $("#visitor_id").val(response.V_Id);
                        $("#visitor_name").val(response.V_Name);
                        $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
                        $("#visitor_detail").val(response.V_Dob+" | "+response.V_Gender);
                        $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);

                        $("#job_name").val(response.J_Name);
                        $("#job_detail").val(response.J_Dob+" | "+response.J_Gender);
                        $("#job_relation").val(response.J_Relative);
                        $("#job_contact").val(response.J_Phone+" | "+response.J_Email);
                        $("#job_qualification").val(response.J_Qualification);

                        $("#job_exp").val(response.J_Exp);
                        $("#job_company").val(response.J_Old_Company);



                        if(response.J_LTo == ""){
                            // alert("empty");
                            //get data from row 1 - default one
                            $.ajax({
                                url : "function.php",
                                type : "Post",
                                data : {action : "getdefaultData", Work_Id : workId },
                                dataType : "json",
                                success:function(response_default){

                                    // alert(response_default);

                                    $("#jobletter_to").val(response_default.J_LTo);
                                    $("#jobletter_subject").val(response_default.J_LSubject);
                                    $("#jobletter_detail").val(response_default.J_LDetail);
                                    $("#jobletter_sign").val(response_default.J_LSign);



                                    // $("#visitor_id").val(response.V_Id);
                                    $("#work_id").val(workId);
                                    $("#Jl_id").val(response.J_Id);
                                    $("#ml_id_txt").html(response.J_Id+"|"+response.V_Id+"|"+workId);

                                    var Obj = { 
                                        "%NAME%" : response.J_Name,
                                        "%TO_NAME%" : response.J_Old_Company, 
                                        "%QUALIFICATION%" : response.J_Qualification, 
                                        "%EXPERIENCES%": response.J_Exp,
                                       
                                    }; 
                                    var job_detail_new = $("#jobletter_detail").val().replace(/%NAME%|%TO_NAME%|%QUALIFICATION%|%EXPERIENCES%/g, m => Obj[m]);    
                                    $("#jobletter_detail").val(job_detail_new); 
                                    var job_to_new = $("#jobletter_to").val().replace("%TO_NAME%", response.J_Old_Company); 
                                    $("#jobletter_to").val(job_to_new); 


                                }
                            });

                        }else{

                            // alert("have data");
                            $("#jobletter_to").val(response.J_LTo);
                            $("#jobletter_subject").val(response.J_LSubject);
                            $("#jobletter_detail").val(response.J_LDetail);
                            $("#jobletter_sign").val(response.J_LSign);



                            $("#visitor_id").val(response.V_Id);
                            $("#work_id").val(workId);
                            $("#Jl_id").val(response.J_Id);
                            $("#ml_id_txt").html(response.J_Id+"|"+response.V_Id+"|"+workId);

                        }                      
    
    
                    }        
                });

    }else{
        alert("No Id pass ...! Contact IT Department Please..!");
    }

    $(".textarea_l").css({"border-color": "white", "border": "0"});


    //code for add data to database by ajax
    $('#job_letter_frm').on('submit', function(event){
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("action","updateJobLetter");
        formData.append("U_ID",$("#user_id").val());
        $.ajax({
            url:"function.php",
            type:"post",
            data:formData,
            contentType:false,
            processData:false,
            dataType : "json",
            success:function(response)
            {
                if(response.success == true){

                    $("#messages_ml_id").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                    '<br>For any Query - Contact IT Department</div>');

                }else{
                    $("#messages_ml_id").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');              
                }
                
            }
        });


    });


    

    $('#print_ML').click(function () {   
       window.print();
    });


    //code for add data to database by ajax
    $("#uploadLetterModalBtn").on('click',function(){
        $("#upload_file")[0].reset();

        $('#upload_file').on('submit', function(event){
            event.preventDefault();
    
            // alert("letter upload on");
    
            var formData_ul = new FormData(this);
            formData_ul.append("action","uploadFile");
            formData_ul.append("Jl_id",$("#Jl_id").val());
            formData_ul.append("W_ID",$("#work_id").val());
            formData_ul.append("U_ID",$("#user_id").val());
            formData_ul.append("visitor_id",$("#visitor_id").val());

            var error = '';
                    
            var extension = $('#jl_final_document').val().split('.').pop().toLowerCase();
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf']) == -1)
                {
                alert("Invalid File Format");
                error += "<p>Invalid File Format</p>";
                $('#jl_final_document').val('');
                return false;
                }
            }      
    
    
            if(error == '')
            {
    
                $.ajax({
                    url:"function.php",
                    method:"post",
                    data:formData_ul,
                    contentType:false,
                    processData:false,
                    success:function(response_ul)
                    {
                        alert(response_ul);                 
    
                        
                    }
                });
            }
            else
            {
                alert("Error "+error);
                // $('#error').html('<div class="alert alert-danger">'+error+'</div>');
            }   
    
    
        });


    });


   




});

var input = document.querySelector("#jl_final_document");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#doc_img_pre");
        img.setAttribute("src", result);
    }
}








