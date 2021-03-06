$("#document").ready(function(){
   
    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "getData"},
        dataType : "json",
        success:function(response){
            
            $("#medicalletter_to").val(response.ML_To);
            $("#medicalletter_subject").val(response.ML_Subject);
            $("#medicalletter_detail").val(response.ML_Detail);
            $("#medicalletter_sign").val(response.ML_Sign);

        }

    }); 


});


$('#medical_letter_frm').on('submit', function(event){
    event.preventDefault();  

    var formData = new FormData(this);
    formData.append("action","updateML");

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