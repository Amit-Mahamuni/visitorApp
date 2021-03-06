$(document).ready(function(){

    fill_table();

    function fill_table(pri = '', status = '', date_form = '', date_end = '')
    {
        proposal_dt = $('#proposal_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"function.php",
             type:"POST",
             data:{
                priorty : pri, status : status, dateform : date_form,  dateend : date_end, action : 'getProposalList'
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

        $('#proposal_datatable').DataTable().destroy();
    
        fill_table($("#proposal_priority_f").val(), $("#proposal_status_f").val(), 
                    $("#proposal_date_from_f").val(), $("#proposal_date_end_f").val());
    
     });
    
     $(document).on('click', '#clear_filter', function(){
    
        $('#proposal_datatable').DataTable().destroy();
    
        fill_table();
    
     });


     $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todaytotalProposal"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#today_total_proposal").html(response_t);

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



function editProposal(Id){
    // alert(Id);
    $("#messages").html('');
    $("#from_data").show();   

    if(Id){

        getProposalData(Id);
        $("#removeBtn").hide();
        $("#updateBtn").show();

        //code for add data to database by ajax
        $("#proposal_frm").on('submit', function(event){
            event.preventDefault();
            var error = '';
            var extension = $('#doc_pre_file').val().split('.').pop().toLowerCase();

            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
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
                    type:"post",
                    data:new FormData(this),
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
                           
                            //$("#rmKaryModelBtn").html("Close");
    
                            proposal_dt.ajax.reload(null, false);
    
                        }else{
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                           '</div>');
    
                            //alert(response);
    
                            $("#from_data").hide();
                            $("#updateBtn").hide();
                            proposal_dt.ajax.reload(null, false);    
    
                        }                        
                    }
                });
            }
            else
            {
                alert(error);
            }
        });  

    }else{
        alert("Error: no id found Refresh the page again");
    }
}


function rmoveProposal(Id){

    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getProposalData(Id);
        $("#updateBtn").hide();


        $("#removeBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {P_Id : Id, action : "removeProposal"},
                dataType : "json",
                success:function(response){

                    // alert(response);

                    if(response.success == true){

                        // alert(response.messages);

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Remove from Database.'+
                        '<br>For Restore - Contact IT Department</div>');

                       $("#from_data").hide();
                       $("#removeBtn").hide();
                    //$("#rmKaryModelBtn").html("Close");

                         proposal_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                        '</div>');

                        // alert(response.messages);

                        $("#from_data").hide();
                        $("#removeBtn").hide();
                        proposal_dt.ajax.reload(null, false);

                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}



function getProposalData(Id){
    // alert(Id);
    $('#proposal_frm')[0].reset();

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {proposal_Id : Id, action: "getData"},
        dataType : "json",
        success:function(response){
        
        // alert(response);

            $("#proposal_id").val(response.P_Id);
            $("#proposal_id_txt").html('<strong>'+response.P_Id+'</strong>');
            $("#proposal_status").val(response.P_Status);
            $("#proposal_priority").val(response.P_Priority);
            $("#proposal_add_date").val(response.P_Add_Date);
            $("#proposal_to").val(response.P_To);
            $("#proposal_subject").val(response.P_Subject);
            $("#proposal_detail").val(response.P_Detail);
            $("#proposal_end").val(response.P_End);
            $("#proposal_note").val(response.P_Note);
            $("#proposal_name").val(response.P_Name);
            $("#proposal_phone").val(response.P_Phone);          
            
            var proposal_doc_path = "../image/proposal/"+response.P_Doc;
            if(response.P_Doc != null || response.P_Doc == ""){
                $('#doc_pre').attr('src', proposal_doc_path);
            }           
           
        }
        
    });
    
}

function detailProPosal(Id){
    window.location = '../proposal/proposal.php?Id='+Id;
}

function createLetter(){
    window.location = '../proposal/proposalLetter.php?Id=' + $("#proposal_id").val();
}