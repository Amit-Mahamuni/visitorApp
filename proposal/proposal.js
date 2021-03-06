$(document).ready(function(){
    $("#status_txt").hide();

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

        // alert(proposal_Id);

        $('#proposal_frm')[0].reset();

        $.ajax({
            url : "function.php",
            type : "Post",
            data : {proposal_Id : proposal_Id, action: "getData"},
            dataType : "json",
            success:function(response){         

                $("#proposal_id").val(response.P_Id);
                $("#proposal_to").val(response.P_To);
                $("#proposal_subject").val(response.P_Subject);
                $("#proposal_detail").val(response.P_Detail);
                $("#proposal_end").val(response.P_End);
                $("#proposal_note").val(response.P_Note);
                $("#proposal_name").val(response.P_Name);
                $("#proposal_phone").val(response.P_Phone);
                $("#proposal_priority").val(response.P_Priority);
                $("#proposal_status").val(response.P_Status);          
                
                var proposal_doc_path = "../image/proposal/"+response.P_Doc;
                if(response.P_Doc != null || response.P_Doc == ""){
                    
                    $('#doc_pre').attr('src', proposal_doc_path);
                    $('#doc_link').attr('href', proposal_doc_path);
                }   
                
                if(response.P_Status == "Complete" || response.P_Status == "Under Process"){
                    $("#add_proposal").hide();
                    $("#status_txt").show();
                    $("#status_txt").html("Proposal is : "+response.P_Status);
                }
            
            }
            
        });
        

    }


       //code for add data to database by ajax
       $('#proposal_frm').on('submit', function(event){
        event.preventDefault();
        var error = '';  
        
        var extension = $('#doc_pre_file').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
         if(jQuery.inArray(extension, ['gif','png','jpg','jpeg', 'pdf']) == -1)
         {
          alert("Invalid Image File");
          error += "<p>Invalid Image File</p>";
          $('#doc_pre_file').val('');
          return false;
         }
        }         


        if(error == '')
        {

            $.ajax({
                url:"addproposal.php",
                method:"post",
                data:new FormData(this),
                contentType:false,
                processData:false,
                dataType : "json",
                success:function(d)
                {  
                    alert(d.messages);
                    if(d.success == true){

                        alert(d.messages);
                        $('#proposal_frm')[0].reset();
                        $('#group_table').find("tr:gt(0)").remove();
                        window.location = '../proposal/proposal.html';
                        location.reload(true);

                        
                    }else{
                        alert("fail");
                    }                  
   
                }
            }); 
        }
        else
        {
             $('#error').html('<div class="alert alert-danger">'+error+'</div>');
        }
    });


    



});


var input = document.querySelector("#doc_pre_file");
input.addEventListener('change',preview_work_profile);
function preview_work_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#doc_pre");
        img.setAttribute("src", result);
    }
}