$(document).ready(function(){

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
    

    if(parms != ""){

        // alert(adhikariId);
        var adhikariId = qsParm[key];
        $("#karykarta_id").html(adhikariId);
        getData(adhikariId);
        

    }else{

        alert("No Id Get Pass..! Contact IT Department..!")

    }

});

function workDetail(Id){
    // alert(Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}

function getData(adhikariId){

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {adhikari_Id : adhikariId, action : "adhikariDetail"},
        dataType : "json",
        success:function(response){ 

            // `AD_Id`, `AD_Name`, `AD_Phone`, `AD_Email`, `AD_GENDER`, `AD_Dob`, `AD_Address`, `AD_City`, `AD_Pincode`,
            //  `AD_Department`, `AD_SubDepartment`, `AD_Occupation`, `AD_Status`, `AD_Visibility`, `AD_Profile_img`

            if(response != ""){

                $("#adhikari_status").val(response.AD_Status);
                $("#adhikari_department").val(response.AD_Department);
                $("#adhikari_occupation").val(response.AD_Occupation);
                $("#adhikari_name").val(response.AD_Name);
                $("#adhikari_contact").val(response.AD_Phone+" | "+response.AD_Email);
                $("#adhikari_detail").val(response.AD_GENDER+" | "+response.AD_Dob);
                $("#adhikari_address").val(response.AD_Address+" | "+response.AD_City+" | "+response.AD_Pincode);

                var adhikari_profile_path = "../image/Adhikari_Profile/"+response.AD_Profile_img;
                if(response.AD_Profile_img != null || response.AD_Profile_img == ""){
                    // alert("visitor profile path " +visitor_profile_path );
                    $('#adhikari_profile').attr('src', adhikari_profile_path);
                    $('#adhikari_pro_href').attr('href', adhikari_profile_path);
                } 
                

            }else{
                alert("Karykarta Remove Or Inactive From While...! Please Contact IT Department..!");
            }
            
        }

    });

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {adhikari_Id : adhikariId, action : "adhikariWorkList"},
        dataType : "json",
        success:function(response){

            if(response.status == "ok"){

                $("#total_work").html(response.total);

                    for(var i=0; i <= response.workdata.length; i++){
                        $("#work_table_body").append('<tr><td>'+response.workdata[i].W_Id+'</td>'+
                        '<td>'+response.workdata[i].Work_title+'</td>'+
                        '<td>'+response.workdata[i].Work_Category+' | '+response.workdata[i].Work_Subcategory+'</td>'+
                        '<td>'+response.workdata[i].Work_add_date+'</td>'+
                        '<td>'+response.workdata[i].Status+'</td>'+
                        "<td><button class='btn btn-sm btn-info' onclick='workDetail("+response.workdata[i].W_Id+")'>Info</button></td>"+
                        '</tr>');
                    }     

            }else{
                alert(response.workdata);
            } 
        }    
    });


}