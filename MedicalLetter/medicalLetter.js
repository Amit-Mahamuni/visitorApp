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
                        $("#visitor_id").val(response.V_Id);
                        $("#visitor_name").val(response.V_Name);
                        $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
                        $("#visitor_detail").val(response.V_Dob+" | "+response.V_Gender);
                        $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);

                        $("#hospital_name").val(response.ML_Hospital);
                        $("#hospital_ward").val(response.ML_Ward);
                        $("#hospital_bed").val(response.ML_Bed);
                        $("#admit_date").val(response.ML_Admit_Date);
                        $("#Disease").val(response.ML_Disease);

                        $("#patient_name").val(response.ML_PName);
                        $("#patient_dob").val(response.ML_PDob);
                        $("#patient_gender").val(response.ML_PGender);
                        $("#patient_relation").val(response.ML_PRelation);


                        if(response.ML_To == ""){
                            // alert("empty");
                            //get data from row 1 - default one
                            $.ajax({
                                url : "function.php",
                                type : "Post",
                                data : {action : "getData", Work_Id : workId },
                                dataType : "json",
                                success:function(response_default){

                                    // alert(response_default);

                                    $("#medicalletter_to").val(response_default.ML_To);
                                    $("#medicalletter_subject").val(response_default.ML_Subject);
                                    $("#medicalletter_detail").val(response_default.ML_Detail);
                                    $("#medicalletter_sign").val(response_default.ML_Sign);



                                    $("#visitor_id").val(response.V_Id);
                                    $("#work_id").val(workId);
                                    $("#ml_id").val(response.ML_Id);
                                    $("#ml_id_txt").html(response.ML_Id+"|"+response.V_Id+"|"+workId);

                                    var Obj = { 
                                        "%NAME%" : response.ML_PName,
                                        "%HOSPITAL_NAME%" : response.ML_Hospital, 
                                        "%WARD_NO%" : response.ML_Ward, 
                                        "%BED_NO%": response.ML_Bed,
                                        "%DISEASE%": response.ML_Disease,
                                        "%DATE_ADMIT%": response.ML_Date
                                    }; 
                                    var medicalletter_detail_new = $("#medicalletter_detail").val().replace(/%NAME%|%HOSPITAL_NAME%|%WARD_NO%|%BED_NO%|%DISEASE%|%DATE_ADMIT%/g, m => Obj[m]);    
                                    $("#medicalletter_detail").val(medicalletter_detail_new); 
                                    var medicalletter_to_new = $("#medicalletter_to").val().replace("%HOSPITAL_NAME%", response.ML_Hospital); 
                                    $("#medicalletter_to").val(medicalletter_to_new); 


                                }
                            });

                        }else{
                            // alert("have data");

                            $("#medicalletter_to").val(response.ML_To);
                            $("#medicalletter_subject").val(response.ML_Subject);
                            $("#medicalletter_detail").val(response.ML_Detail);
                            $("#medicalletter_sign").val(response.ML_Sign);

                            $("#visitor_id").val(response.V_Id);
                            $("#work_id").val(workId);
                            $("#ml_id").val(response.ML_Id);
                            $("#ml_id_txt").html(response.ML_Id+"|"+response.V_Id+"|"+workId);

                        }                      
    
    
                    }        
                });

    }else{
        alert("No Id pass ...! Contact IT Department Please..!");
    }

    $(".textarea_l").css({"border-color": "white", "border": "0"});


    //code for add data to database by ajax
    $('#medical_letter_frm').on('submit', function(event){
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("action","updateML_ID");
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
                // alert(response);
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
    $('#upload_file').on('submit', function(event){
        event.preventDefault();

        // var ML_Id = $("#ml_id").val();

        var formData = new FormData(this);
        formData.append("action","uploadFile");
        formData.append("ML_Id",$("#ml_id").val());
        formData.append("W_ID",$("#work_id").val());
        formData.append("U_ID",$("#user_id").val());
        formData.append("visitor_id",$("#visitor_id").val());

        var error = '';
                
        var extension = $('#ml_final_document').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf']) == -1)
            {
            alert("Invalid File Format");
            error += "<p>Invalid File Format</p>";
            $('#ml_final_document').val('');
            return false;
            }
        }      


        if(error == '')
        {

            $.ajax({
                url:"function.php",
                method:"post",
                data:formData,
                contentType:false,
                processData:false,
                success:function(response)
                {
                    alert(response);                  

                    
                }
            });
        }
        else
        {
            $('#error').html('<div class="alert alert-danger">'+error+'</div>');
        }



    });



















});

var input = document.querySelector("#ml_final_document");
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








