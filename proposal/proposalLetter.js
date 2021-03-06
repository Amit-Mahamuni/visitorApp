$(document).ready(function(){

    $("#status_txt").hide();

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
    
    var proposal_Id = qsParm[key]


    if(parms != ""){   
        
        $("#work_id").html(proposal_Id);

        $.ajax({
                    url : "function.php",
                    type : "Post",
                    data : {action : "getProposalData", Proposal_Id : proposal_Id },
                    dataType : "json",
                    success:function(response){
                        // alert(response);

                        $("#l_id_txt").html(proposal_Id);
                        $("#Proposal_Id").val(response.P_Id);

                        $("#proposal_note").val(response.P_Note);
                        $("#proposal_add_date").val(response.P_Add_Date);
                        $("#proposal_status").val(response.P_Status);
                        $("#proposal_priority").val(response.P_Priority);

                        $("#proposal_name").val(response.P_Name);
                        $("#proposal_phone").val(response.P_Phone);

                        $("#letter_to").val(response.P_To);
                        $("#letter_subject").val(response.P_Subject);
                        $("#letter_detail").val(response.P_Detail);
                        $("#letter_sign").val(response.P_Sign);   
                        
                        if(response.P_Status == "Complete" && response.P_FLetter != ""){
                            $("#uploadLetterModalBtn").hide();
                            $("#updateML").hide();
                            $("#print_ML").hide();
                            $("#status_txt").show();
                            $("#status_txt").html("Proposal is : "+response.P_Status);
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
        formData.append("action","updateProposalLetter");
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
    $("#uploadLetterModalBtn").on('click',function(){
        $("#upload_file")[0].reset();

        $('#upload_file').on('submit', function(event){
            event.preventDefault();
    
            // alert("letter upload on");
    
            var formData_ul = new FormData(this);
            formData_ul.append("action","uploadProposalFile");
            formData_ul.append("P_Id",$("#Proposal_Id").val());

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