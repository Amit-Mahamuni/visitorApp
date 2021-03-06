$("#document").ready(function(){
    // `ID_LTitle`, `ID_LSubject`, `ID_LDetail`, `ID_LSign`

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "getdefaultData"},
        dataType : "json",
        success:function(response){
            // alert(response);
            // `RL_To`, `RL_Subject`, `RL_Detail`, `RL_Sign`
            $("#residentialL_to").val(response.RL_To);
            $("#residentialL_subject").val(response.RL_Subject);
            $("#residentialL_detail").val(response.RL_Detail);
            $("#residentialL_sign").val(response.RL_Sign);

        }

    }); 


});


$('#residential_letter_frm').on('submit', function(event){
    event.preventDefault();  

    var formData = new FormData(this);
    formData.append("action","updateDefaultResidentialLetterFormat");

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