$("#document").ready(function(){

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "getdefaultData"},
        dataType : "json",
        success:function(response){
            // alert(response);
            $("#jobletter_to").val(response.J_LTo);
            $("#jobletter_subject").val(response.J_LSubject);
            $("#jobletter_detail").val(response.J_LDetail);
            $("#jobletter_sign").val(response.J_LSign);

        }

    }); 


});


$('#job_letter_frm').on('submit', function(event){
    event.preventDefault();  

    var formData = new FormData(this);
    formData.append("action","updateDefaultJobLetterFormat");

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