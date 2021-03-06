$(document).ready(function(){

    // alert($("#user_id").val());

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {user_Id : $("#user_id").val(), action : 'getSingleDetail'},
        dataType : "json",
        success:function(response){
            // `U_Id`, `U_Status`, `U_Department`, `U_Name`, `U_Phone`, `U_Email`, `U_Gender`, `U_Dob`, `U_Address`, `U_City`, `U_Pincode`, `U_Visibility`, `U_Profile_Img`
            // alert(response);
            $("#user_department").val(response.U_Department);
            $("#user_status").val(response.U_Status);
            $("#user_name").val(response.U_Name);
            $("#user_detail").val(response.U_Gender+" | "+response.U_Dob);
            $("#user_contact").val(response.U_Phone+" | "+response.U_Email);
            $("#user_address").val(response.U_Address+" | "+response.U_City+" | "+response.U_Pincode);
            $("#login_user_name").val(response.U_Username);

            var User_profile_path = "../image/User_Profile/"+response.U_Profile_Img;
            if(response.U_Profile_Img != null || response.U_Profile_Img == ""){
                // alert("visitor profile path " +visitor_profile_path );
                $('#user_profile').attr('src', User_profile_path);
            }
        }
    }); 


});