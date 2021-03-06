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

    // var karykartaId = qsParm[key];
    var karykartaId = 0;

    // alert($("#user_id").val());

    if(parms != "" || $("#user_id").val() != ""){
        // alert(karykartaId);

        if(parms == "" && $("#user_id").val() != ""){

            karykartaId = $("#user_id").val();
            $("#karykarta_id").html(karykartaId);
            getData(karykartaId);

        }else if(parms != "" && $("#user_id").val() == ""){

            karykartaId = qsParm[key];
            $("#karykarta_id").html(karykartaId);
            getData(karykartaId);
        }

    }else{

        alert("No Id Get Pass..! Contact IT Department..!")

    }

});

function workDetail(Id){
    // alert(Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}

function getData(karykartaId){

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {karykarta_Id : karykartaId, action : "karykartaDetail"},
        dataType : "json",
        success:function(response){

            if(response != ""){

                $("#karykarta_status").val(response.K_Status);
                $("#karykarta_department").val(response.K_Department);
                $("#karykarta_name").val(response.K_Name);
                $("#karykarta_contact").val(response.K_Phone+" | "+response.K_Email);
                $("#karykarta_detail").val(response.K_Gender+" | "+response.K_Dob);
                $("#karykarta_address").val(response.K_Address+" | "+response.K_City+" | "+response.K_Pincode);

                var Karykarta_profile_path = "../image/Karykarta_Profile/"+response.K_Profile_Img;
                if(response.K_Profile_Img != null || response.K_Profile_Img == ""){
                    // alert("visitor profile path " +visitor_profile_path );
                    $('#karykarta_profile').attr('src', Karykarta_profile_path);
                }


            }else{
                alert("Karykarta Remove Or Inactive From While...! Please Contact IT Department..!");
            }

        }

    });

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {karykarta_Id : karykartaId, action : "karykartaWorkList"},
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
