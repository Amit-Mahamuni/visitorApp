$(document).ready(function(){


    // visitor_dt = $("#visitor_datatable").DataTable({
    //     "ajax" : "visitor_List_retrive.php",
    //     "order" : []
    // });

    fill_table();

    function fill_table(pri = '', status = '', vot = '', gen = '', cate = '', subcate = '',  date_form = '', date_end = '')
    {
        visitor_dt = $('#visitor_datatable').DataTable({
            // "processing" : true,
            // "serverSide" : true,
            "order" : [],
            // "scrollX": "100%",
            // "searching" : false,
            "ajax" : {
             url:"visitor_List_retrive.php",
             type:"POST",
             data:{
                priorty : pri, status : status, voter : vot, gender : gen, category : cate, subcategory : subcate, dateform : date_form,  dateend : date_end
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

        $('#visitor_datatable').DataTable().destroy();
    
        fill_table($("#work_priority_f").val(), $("#work_status_f").val(), 
                    $("#visitor_voter_f").val(), $("#visitor_gender_f").val(),
                    $("#work_category_f").val(), $("#work_subcat_f").val(),
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());
    
    });
    
    $(document).on('click', '#clear_filter', function(){
    
        $('#visitor_datatable').DataTable().destroy();
    
        fill_table();
    
    });

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayEntry"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#total_entry").html(response_t);

        }
    });


    $(document).on('click','#work_category_f',function(){

        var optionText = $("#work_category_f option:selected").text();

        switch(optionText){
            case "Government":
                $("#work_subcat_div").html("<select id='work_subcat_f' name='work_subcat_f' class='form-control form-control-sm'>"+ 
                "<option value='All' selected>All</option>"+                               
                "<option value='Complaint'>Complaint</option>"+                                
                "<option value='Letter'>Letter</option>"+                                
                "<option value='Other'>Other</option>"+
                "</select><small id='work_subcat_f' class='form-text text-muted'>work Sub-Category</small>");
            break;
            
            case "Personal":
                $("#work_subcat_div").html("<select id='work_subcat_f' name='work_subcat_f' class='form-control form-control-sm'>"+                                
                "<option value='All' selected>All</option>"+ 
                "<option value='Medical Letter'>Medical Letter</option>"+
                "<option value='Education'>Education</option>"+                                
                "<option value='Other'>Other</option>"+                               
                "</select><small id='work_subcat_f' class='form-text text-muted'>work Sub-Category</small>"); 
            break;
            
            case "Invitation":
                $("#work_subcat_div").html("<select id='work_subcat_f' name='work_subcat_f' class='form-control form-control-sm'>"+                       
                "<option value='All' selected>All</option>"+ 
                "<option value='Wedding'>Wedding</option>"+                                
                "<option value='Opening'>Opening</option> "+                                
                "<option value='Dashkriya'>Dashkriya</option>"+
                "<option value='Other'>Other</option>"+
                "</select><small id='work_subcat_f' class='form-text text-muted'>work Sub-Category</small>"); 
            break;
            
            case "Job":
                $("#work_subcat_div").html("<select id='work_subcat_f' name='work_subcat_f' class='form-control form-control-sm'>"+                                
                "<option value='All' selected>All</option>"+ 
                "<option value='Vacany'>Vacany</option>"+                                
                "<option value='Job Letter'>Job Letter</option>"+                                
                "<option value='Other'>Other</option>"+
                "</select><small id='work_subcat_f' class='form-text text-muted'>work Sub-Category</small>"); 
            break;

            default:$("#work_subcat_div").html("");
                break;
        }


    });





});


function editVisitor(Id){

    $("#messages").html('');
    $("#from_data").show();
   
    // $("#visitor_frm")[0].reset();

    // alert(Id);

    if(Id){

        $("#visitor_frm")[0].reset();

        getVisitorData(Id);

        $("#removeBtn").hide();

        $("#updateVisitorBtn").show();

        //code for add data to database by ajax

        $('#visitor_frm').on('submit', function(event){
            event.preventDefault();
            var error = '';     
    
            var extension = $('#visitor_profile').val().split('.').pop().toLowerCase();
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Invalid Image File");
                    error += "<p>Invalid Image File</p>";
                    $('#visitor_profile').val('');
                    return false;
                }
            }            

            if(error == '')
            {
                $.ajax({
                    url:"updateVisitorDetail.php",
                    type:"post",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    dataType : "json",
                    success:function(response)
                    {
                        // alert(response);
                        if(response.success == true){

                            // alert(response.messages);
    
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Update in Database.'+
                           '<br>For any Query - Contact IT Department</div>');
    
                           $("#from_data").hide();
                           $("#updateVisitorBtn").hide();

                        //    $("#rmKaryModelBtn").html("Close");
    
                           visitor_dt.ajax.reload(null, false);
    
                        }else{
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                           '</div>');
    
                            // alert(response);
    
                            $("#from_data").hide();
                            $("#updateVisitorBtn").hide();
                            visitor_dt.ajax.reload(null, false);
    
    
                        }


                        // alert(response);
                        // // visitor_dt.ajax.reload(null, false);
                        // $("#updateVisitorBtn").hide();
                        
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


function rmoveVisitor(Id){

    $("#messages").html('');
    $("#from_data").show();
    $("#removeBtn").show();

    if(Id){

        getVisitorData(Id);
        $("#updateVisitorBtn").hide();

        $("#removeBtn").unbind('click').bind('click', function(){
            $.ajax({
                url : "function.php",
                type : "Post",
                data : {visitor_Id : Id, user_id : $("#user_id").val(), action : "removeVisitor"},
                dataType : "json",
                success:function(response){

                    if(response.success == true){

                        // alert(response.messages);

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>All Detail is Remove from Database.'+
                       '<br>For Restore - Contact IT Department</div>');

                       $("#from_data").hide();
                       $("#removeBtn").hide();
                    //    $("#rmKaryModelBtn").html("Close");

                       visitor_dt.ajax.reload(null, false);

                    }else{
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span>'+response.messages+'</strong><br><h6>Contact IT Department</h6>'+
                       '</div>');

                        // alert(response.messages);

                        $("#from_data").hide();
                        $("#removeBtn").hide();
                       visitor_dt.ajax.reload(null, false);


                    }

                }
            });
        });


    }else{
        alert("No Id Found");
    }
}



function getVisitorData(Id){
    // alert(Id);
    // $("#visitor_frm")[0].reset();
    
    $.ajax({
        url : "function.php",
        type : "Post",
        data : {visitor_Id : Id, action: "getData"},
        dataType : "json",
        success:function(response_vd){
            // visitor field --->
            // `V_Id`, `V_Name`, `V_Phone`, `V_Email`, `V_Dob`, `V_Gender`, `V_Address`, `V_City`, 
            //`V_Pincode`, `R_Name`, `R_Phone`, `V_Type`, `V_Category`, `V_Visibility`, `Visitor_Profile`
            //`V_Adhar_Card`, `V_Voter_Card`, `V_Pan_Card`

            // alert(response_vd);
            $("#visitor_id").val(Id);
            $("#visitor_id_txt").html('<strong>Visitor Id : '+Id+'</strong>')
            $("#visitor_type").val(response_vd.V_Type);
            $("#visitor_voter").val(response_vd.V_Voter);
            $("#visitor_name").val(response_vd.V_Name);
            $("#visitor_phone").val(response_vd.V_Phone);
            $("#visitor_email").val(response_vd.V_Email);
            $("#visitor_gender").val(response_vd.V_Gender);
            $("#visitor_dob").val(response_vd.V_Dob);
            $("#visitor_address").val(response_vd.V_Address);
            $("#visitor_city").val(response_vd.V_City);
            $("#visitor_pincode").val(response_vd.V_Pincode);
            $("#v_adhar_card").val(response_vd.V_Adhar_Card);
            $("#v_voter_card").val(response_vd.V_Voter_Card);
            $("#v_pan_card").val(response_vd.V_Pan_Card); 

            $("#refernce_id").val(response_vd.R_Id);
            $("#refernce_name").val(response_vd.R_Name);
            $("#refernce_phone").val(response_vd.R_Phone);
            $("#refernce_dob").val(response_vd.R_Dob );
            $("#refernce_gender").val(response_vd.R_Gender);
            $("#refernce_occupation").val(response_vd.R_Occupation);
            $("#refernce_address").val(response_vd.R_Address);



            var visitor_profile_path = "../image/Visitor_Profile/"+response_vd.Visitor_Profile;
            if(response_vd.Visitor_Profile != null || response_vd.Visitor_Profile == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#visitor_img_pre').attr('src', visitor_profile_path);
            }           
           
        }
        
    });
    
}



var input = document.querySelector("#visitor_profile");
input.addEventListener('change',preview_visitor_profile);
function preview_visitor_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#visitor_img_pre");
        img.setAttribute("src", result);
    }
}


function detailvisitor(Id){
    // alert("Work Id is"+Id);
    window.location = '../visitorDetail/visitorDetail.php?Id=' + Id;
}