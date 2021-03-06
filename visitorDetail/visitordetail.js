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
    if(parms != ""){
        $("#visitor_id").html(visitorId);

        $.ajax({
            url : "retriveVisitorDetail.php",
            type : "Post",
            data : {visitorId : visitorId, action : "visitorDetail"},
            dataType : "json",
            success:function(response){

                $("#visitor_id").val(response.V_Id);
                $("#visitor_voterInfo").val(response.V_Voter);
                $("#visitor_name").val(response.V_Name);
                $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
                $("#visitor_detail").val(response.V_Gender+" | "+response.V_Dob);
                $("#visitor_address").val(response.V_Address+" | "+response.V_City+" | "+response.V_Pincode);
                $("#refernces_detail").val(response.R_Name+" | "+response.R_Phone);
                $("#visitor_type").val(response.V_Type);
                $("#v_adhar_card").val(response.V_Adhar_Card);
                $("#v_voter_card").val(response.V_Voter_Card);
                $("#v_pan_card").val(response.V_Pan_Card);
                var visitor_profile_path = "../image/Visitor_Profile/"+response.Visitor_Profile;


                if(response.Visitor_Profile != null || response.Visitor_Profile == ""){
                    // alert("visitor profile path " +visitor_profile_path );
                    $('#visitor_profile').attr('src', visitor_profile_path);
                }

            }

        });

        $.ajax({
            url : "workList_visitor_retrive.php",
            type : "Post",
            data : {visitor_Id : visitorId},
            dataType : "json",
            success:function(response){

                // alert(response);

                if(response.status == "ok"){

                    $("#total_work").html(response.total);

                    // console.log(response.workdata.length);
                    // $(response.workdata).each(function (i, val) {
                    //     $.each(val, function (k, v) {
                    //       console.log(k + " : " + v);
                    //     });
                    //   });

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
    else{
        alert("No Work Id Found!  Please Select from Work List");
    }



});


function workDetail(Id){
    // alert(Id);
    window.location = '../workdetail/workdetail.php?Id=' + Id;
}

function AddWork(){
    // alert( $("#visitor_id").text());
    var Visitor_Id = $("#visitor_id").text();
    window.location = '../addVisitor/addvisitor.php?vId=' + Visitor_Id;
}

function printDoc(){
    window.print();
}
