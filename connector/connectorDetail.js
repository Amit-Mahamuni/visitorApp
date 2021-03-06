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

        var connectorId = qsParm[key];
        $("#connector_id").html(connectorId);
        getData(connectorId);        

    }else{

        alert("No Id Get Pass..! Contact IT Department..!");
    }

});

function workDetail(Id){
    // alert(Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}

function getData(connectorId){

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {connector_Id : connectorId, action : "connectorDetail"},
        dataType : "json",
        success:function(response){ 

            // `CO_Id`, `CO_Name`, `CO_Phone`, `CO_Mail`, `CO_Gender`, `CO_Dob`, `CO_Address`,
            //  `CO_City`, `CO_Pincode`, `CO_Occupation`, `CO_Status`, `CO_Visibility`, `CO_Profile_img`

            if(response != ""){

                $("#connector_status").val(response.CO_Status);
                // $("#adhikari_department").val(response.AD_Department);
                $("#connector_occupation").val(response.CO_Occupation);
                $("#connector_name").val(response.CO_Name);
                $("#connector_contact").val(response.CO_Phone+" | "+response.CO_Mail);
                $("#connector_detail").val(response.CO_Gender+" | "+response.CO_Dob);
                $("#connector_address").val(response.CO_Address+" | "+response.CO_City+" | "+response.CO_Pincode);

                var profile_path = "../image/Connector_Profile/"+response.CO_Profile_img;
                if(response.CO_Profile_img != null || response.CO_Profile_img == ""){
                    // alert("visitor profile path " +visitor_profile_path );
                    $('#connector_profile').attr('src', profile_path);
                    $('#connector_pro_href').attr('href', profile_path);
                } 
                

            }else{
                alert("Connector Remove Or Inactive From While...! Please Contact IT Department..!");
            }
            
        }

    });

    // $.ajax({
    //     url : "function.php",
    //     type : "Post",
    //     data : {adhikari_Id : connectorId, action : "adhikariWorkList"},
    //     dataType : "json",
    //     success:function(response){

    //         if(response.status == "ok"){

    //             $("#total_work").html(response.total);

    //                 for(var i=0; i <= response.workdata.length; i++){
    //                     $("#work_table_body").append('<tr><td>'+response.workdata[i].W_Id+'</td>'+
    //                     '<td>'+response.workdata[i].Work_title+'</td>'+
    //                     '<td>'+response.workdata[i].Work_Category+' | '+response.workdata[i].Work_Subcategory+'</td>'+
    //                     '<td>'+response.workdata[i].Work_add_date+'</td>'+
    //                     '<td>'+response.workdata[i].Status+'</td>'+
    //                     "<td><button class='btn btn-sm btn-info' onclick='workDetail("+response.workdata[i].W_Id+")'>Info</button></td>"+
    //                     '</tr>');
    //                 }     

    //         }else{
    //             alert(response.workdata);
    //         } 
    //     }    
    // });


}