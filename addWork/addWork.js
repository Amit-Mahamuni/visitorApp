$(document).ready(function(){

    // alert("jnk");

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
    
    var visitorId = qsParm[key]; 
    // alert(visitorId);

    getVisitorDetail(visitorId);

    $("#group_row").hide();
    //hide all subcategory
    $("#work_subcategory_gov").show();
    $("#work_subcategory_per").hide();
    $("#work_subcategory_inv").hide();
    $("#work_subcategory_job").hide();   
    

    $("input[type='radio']").click(function(){
        var radioValue = $("input[name='visitor_category']:checked").val();
        if(radioValue == "Group"){
            // alert("Your are a - " + radioValue);
            $("#group_row").show();
        }else if(radioValue == "Single"){
            $("#group_row").hide();
        }
    });


    $('#work_category').on('click',function(){

        var optionText = $("#work_category option:selected").text();
        if(optionText == "Government"){
           $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control'>"+                                
                                        "<option value='Complaint' selected>Complaint</option>"+                                
                                        "<option value='Letter'>Letter</option>"+                                
                                        "<option value='Other'>Other</option>"+
                                        "</select>");       

        }else if(optionText == "Personal"){
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control'>"+                                
                                        "<option value='Medical Letter'selected>Medical Letter</option>"+                                
                                        "<option value='Other'>Other</option>"+                               
                                        "</select>"); 

        }else if(optionText == "Invitation"){
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control'>"+                       
                                        "<option value='Wedding' selected>Wedding</option>"+                                
                                        "<option value='Opening'>Opening</option> "+                                
                                        "<option value='Other'>Other</option>"+
                                        "</select>"); 

        }else if(optionText == "Job"){
            $("#work_subcat_div").html("<select id='work_subcategory' name='work_subcategory' class='form-control'>"+                                
                                        "<option value='Vacany' selected>Vacany</option>"+                                
                                        "<option value='Job Letter'>Job Letter</option>"+                                
                                        "<option value='Other'>Other</option>"+
                                        "</select>");     
           
        }else{
            $("#work_subcat_div").html("");     
        }

    });




    $(document).on('click','.add',function(){
        var html='';
        html += '<tr>';
        html += '<td><input type="text" name="gvisitor_name[]" class="form-control gvisitor_name" /></td>';
        html += '<td><input type="tel" name="gvisitor_phone[]" class="form-control gvisitor_phone" minlength="10" maxlength="10" pattern="[0-9]{10}" /></td>';       
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-minus" aria-hidden="true"></i> Remove</button></td></tr>';
        $('#group_table').append(html);
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });


    //code for add data to database by ajax
    $('#frm').on('submit', function(event){
        event.preventDefault();
        var error = '';
        $('.gvisitor_name').each(function(){
            var count = 1;
            if($(this).val() == '')
            {
                error += "<p>Enter Name at "+count+" Row</p>";
                return false;
            }
            count = count + 1;
        });
        
        $('.gvisitor_phone').each(function(){
            var count = 1;
            if($(this).val() == '')
            {
                error += "<p>Enter Phone Number at "+count+" Row</p>";
                return false;
            }
            count = count + 1;
        });   
        
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
                url:"addwork.php",
                method:"post",
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(d)
                {
                    alert(d);
                    $("#frm")[0].reset();
                    $('#group_table').find("tr:gt(0)").remove();
                    $("#group_row").hide();
                    location.reload(true);
                    
                }
            });
        }
        else
        {
             $('#error').html('<div class="alert alert-danger">'+error+'</div>');
        }



    });



});


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

var input = document.querySelector("#work_file");
input.addEventListener('change',preview_work_profile);
function preview_work_profile(){
    var fileObject = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function(){
        var result = fileReader.result;
        var img = document.querySelector("#work_file_pre");
        img.setAttribute("src", result);
    }
}


function getVisitorDetail(Id){
    $.ajax({
        url : "function.php",
        type : "Post",
        data : {visitor_Id : Id, action: "getData"},
        dataType : "json",
        success:function(response){
            // visitor field --->
            // `V_Id`, `V_Name`, `V_Phone`, `V_Email`, `V_Dob`, `V_Gender`, `V_Address`, `V_City`, 
            //`V_Pincode`, `R_Name`, `R_Phone`, `V_Type`, `V_Category`, `V_Visibility`, `Visitor_Profile`
            //`V_Adhar_Card`, `V_Voter_Card`, `V_Pan_Card`

            // alert(response);
            $("#visitor_id").val(response.V_Id);
            // $("#visitor_id_txt").html('<strong>Visitor Id : '+response.V_Id+'</strong>')
            $("#visitor_type").val(response.V_Type);
            $("#visitor_name").val(response.V_Name);
            $("#visitor_phone").val(response.V_Phone);
            $("#visitor_email").val(response.V_Email);
            $("#visitor_gender").val(response.V_Gender);
            $("#visitor_dob").val(response.V_Dob);
            $("#visitor_address").val(response.V_Address);
            $("#visitor_city").val(response.V_City);
            $("#visitor_pincode").val(response.V_Pincode);            
            $("#refernce_name").val(response.R_Name);
            $("#refernce_phone").val(response.R_Phone);
            $("#v_adhar_card").val(response.V_Adhar_Card);
            $("#v_voter_card").val(response.V_Voter_Card);
            $("#v_pan_card").val(response.V_Pan_Card);

            var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;
            if(response.Visitor_Profile != null || response.Visitor_Profile == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#visitor_img_pre').attr('src', visitor_profile_path);
            }           
           
        }
        
    });
}