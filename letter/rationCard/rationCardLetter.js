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

                        $("#visitor_id").val(response.V_Id);
                        $("#visitor_name").val(response.V_Name);
                        $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
                        $("#visitor_detail").val(response.V_Dob+" | "+response.V_Gender);
                        $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);

                        $("#ration_l_tman").val(response.RC_TM);
                        $("#ration_l_twoman").val(response.RC_TW);
                        $("#ration_l_tlive").val(response.RC_TY);

                        if(response.RC_LTo == ""){

                            $.ajax({
                                url : "function.php",
                                type : "Post",
                                data : {action : "getdefaultData", Work_Id : workId },
                                dataType : "json",
                                success:function(response_default){

                                    // alert(response_default);

                                    $("#letter_to").val(response_default.RC_LTo);
                                    $("#letter_subject").val(response_default.RC_LSubject);
                                    $("#letter_detail").val(response_default.RC_LDetail);
                                    $("#letter_sign").val(response_default.RC_LSign);

                                    $("#visitor_id").val(response.V_Id);
                                    $("#work_id").val(workId);
                                    $("#id").val(response.RC_Id);
                                    $("#l_id_txt").html(response.RC_Id+"|"+response.V_Id+"|"+workId);

                                    var a = response.RC_TM;
                                    var b = response.RC_TW;
                                    var total = a + b; 

                                    var Obj = { 

                                        "%NAME%" : response.V_Name,
                                        "%ADDRESS%" : response.V_Address+", "+response.V_City+", "+response.V_Pincode,
                                        "%TOTAL_MAN%" : response.RC_TM, 
                                        "%TOTAL_WOMAN%" : response.RC_TW, 
                                        "%TOTAL%": total,
                                        "%TOTAL_YEAR%": response.RC_TY,
                                       
                                    }; 
                                    
                                    var detail_new = $("#letter_detail").val().replace(/%NAME%|%ADDRESS%|%TOTAL_MAN%|%TOTAL_WOMAN%|%TOTAL%|%TOTAL_YEAR%/g, m => Obj[m]);    
                                    $("#letter_detail").val(detail_new); 
                                    // var job_to_new = $("#jobletter_to").val().replace("%TO_NAME%", response.J_Old_Company); 
                                    // $("#jobletter_to").val(job_to_new); 
                                }
                            });

                        }else{

                            // alert("have data");

                            $("#letter_to").val(response.RC_LTo);
                            $("#letter_subject").val(response.RC_LSubject);
                            $("#letter_detail").val(response.RC_LDetail);
                            $("#letter_sign").val(response.RC_LSign);

                            $("#visitor_id").val(response.V_Id);
                            $("#work_id").val(workId);
                            $("#id").val(response.RC_Id);
                            $("#l_id_txt").html(response.RC_Id+"|"+response.V_Id+"|"+workId);

                        }                   
                    }        
                });

    }else{
        alert("No Id pass ...! Contact IT Department Please..!");
    }

    $(".textarea_l").css({"border-color": "white", "border": "0"});


    //code for add data to database by ajax
    $('#letter_frm').on('submit', function(event){
        event.preventDefault();
        var formData = new FormData(this);

        formData.append("action", "updateLetter");        
        formData.append("U_ID", $("#user_id").val());

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
            formData_ul.append("Rl_id",$("#id").val());
            formData_ul.append("W_ID",$("#work_id").val());
            formData_ul.append("U_ID",$("#user_id").val());
            formData_ul.append("visitor_id",$("#visitor_id").val());

            var error = '';
                    
            var extension = $('#final_document').val().split('.').pop().toLowerCase();
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf']) == -1)
                {
                alert("Invalid File Format");
                error += "<p>Invalid File Format</p>";
                $('#final_document').val('');
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

var input = document.querySelector("#final_document");
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








