$("#document").ready(function(){


    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "getdefaultData"},
        dataType : "json",
        success:function(response){
            // alert(response);
            $("#letter_to").val(response.P_To);
            $("#letter_subject").val(response.P_Subject);
            $("#letter_detail").val(response.P_Detail);
            $("#letter_end").val(response.P_End);
            $("#letter_sign").val(response.P_Sign);

        }

    }); 


});


$('#proposal_letter_frm').on('submit', function(event){
    event.preventDefault();  

    var formData = new FormData(this);
    formData.append("action","updateDefaultProposalLetterFormat");

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

                    $("#messages_ml").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                    '<br>For any Query - Contact IT Department</div>');

                }else{
                    $("#messages_ml").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                    '</div>');               


                }
                
            }
        });

});