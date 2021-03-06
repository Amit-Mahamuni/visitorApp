$(document).ready(function(){

    fill_table();

    function fill_table(pri = '', status = '', cate = '', subcate = '',  date_form = '', date_end = '')
    {
         work_dt = $('#visitor_work_datatable').DataTable({
            "order" : [],
            "ajax" : {
             url:"workList_retrive.php",
             type:"POST",
             data:{
                priorty : pri, status : status, category : cate, subcategory : subcate, dateform : date_form,  dateend : date_end
             }
            },

            fixedHeader: true,
            responsive: true,
            // dom: 'lBfrtip',
            // buttons: [
            //     'print',
            //     {
            //         extend: 'csvHtml5',
            //         text: 'Export',
            //         bom: true,
            //     }
            // ],

        });
    }

    $(document).on('click', '#filter_fun', function(){

        $('#visitor_work_datatable').DataTable().destroy();

        fill_table($("#work_priority_f").val(), $("#work_status_f").val(),
                    $("#work_category_f").val(), $("#work_subcat_f").val(),
                    $("#work_date_from_f").val(), $("#work_date_end_f").val());

     });

     $(document).on('click', '#clear_filter', function(){

        $('#visitor_work_datatable').DataTable().destroy();

        fill_table();

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
                "<option value='Birthday'>Birthday</option>"+
                "<option value='Collage / School Program'>Collage / School Program</option>"+
                "<option value='Government Program / Meeting'>Government Program / Meeting</option>"+
                "<option value='Other Invitation'>Other Invitation</option>"+
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



      $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "todayWorkEntry"},
        // dataType : "json",
        success:function(response_t){

            // alert(response_t);

            $("#today_total_work").html(response_t);

        }
    });


});

function editWork(Id){
    if(Id){
        window.location = '../addVisitor/addvisitor.php?wId=' + Id;
        // alert(Id);
        // $("#rmoveBtn").unbind('click').bind('click', function(){
            // $("#messages").html("");
            // // $("#addKaryBtn").hide();
            // $("#updateWorkBtn").show();
            // $.ajax({
            //     url : "getSelectedRow.php",
            //     type : "Post",
            //     data : {work_Id : Id},
            //     dataType : "json",
            //     success:function(response){
            //         // `Id`, `V_Id`, `Work_title`, `Priority`, `Work_Category`, `Work_Subcategory`,
            //         // `Work_detail`, `Work_add_date`, `Work_end_date`, `Status`
            //         // alert(response.Name);
            //         $("#work_id").val(response.W_Id);
            //         $("#work_id_txt").html("ID : " +response.W_Id);
            //         $("#work_title").val(response.Work_title);
            //         $("#work_cat").val(response.Work_Category);
            //         $("#work_subcat").val(response.Work_Subcategory);
            //         $("#work_priority").val(response.Priority);
            //         $("#work_detail").val(response.Work_detail);
            //         $("#work_add_date").val(response.Work_add_date);
            //         $("#work_complete_date").val(response.Work_end_date);
            //         $("#work_status").val(response.Status);
            //         if($("#work_status").val() == "complete"){
            //           $("#work_status").attr(disabled);
            //         }
            //         $("#visitor_id").val(response.V_Id);
            //         $("#visitor_name").val(response.V_Name);
            //         $("#visitor_contact").val(response.V_Phone+" | "+response.V_Email);
            //         $("#visitor_detail").val(response.V_Gender+" | "+response.V_Dob);
            //
            //         $("#updateWorkBtn").show();
            //
            //         $("#work_frm").on('submit', function(event){
            //           event.preventDefault();
            //           var formData = new FormData(this);
            //           formData.append("user_id", $("#user_id").val());
            //             // alert("hi");
            //
            //             $.ajax({
            //                 url : "updateWork.php",
            //                 type : "Post",
            //                 data:formData,
            //                 contentType:false,
            //                 processData:false,
            //                 dataType : "json",
            //                 success:function(response){
            //                     if(response.success == true){
            //
            //                         $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            //                         '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            //                         '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            //                         '</div>');
            //
            //                         work_dt.ajax.reload(null, false);
            //                         $("#updateWorkBtn").hide();
            //
            //                     }else{
            //
            //                         $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            //                         '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            //                         '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            //                         '</div>');
            //
            //                         work_dt.ajax.reload(null, false);
            //                         $("#updateWorkBtn").hide();
            //                     }
            //                 }
            //             });
            //         });
            //
            //     }
            // });
        // });
    }else{
        alert("Error: Refresh the page again");
        $("#updateWorkBtn").hide();
    }
  }

  function removeWork(Id){
      if(Id){

          $("#rmoveworkBtn").show();
          $( "#rmove_model_body").show();
          $("#removeMsg").html('');

          $.ajax({
              url : "getSelectedRow.php",
              type : "Post",
              data : {work_Id : Id},
              dataType : "json",
              success:function(response){
                  $("#work_id_r").val(response.W_Id);
                  $("#work_title_r").val(response.Work_title);
                  $("#work_cat_r").val(response.Work_Category);
                  $("#work_subcat_r").val(response.Work_Subcategory);
                  $("#work_priority_r").val(response.Priority);
                  $("#work_detail_r").val(response.Work_detail);
                  $("#work_add_date_r").val(response.Work_add_date);
                  $("#work_complete_date_r").val(response.Work_end_date);
                  $("#work_status_r").val(response.Status);
                  $("#visitor_id_r").val(response.V_Id);
                  $("#visitor_name_r").val(response.V_Name);
                  $("#visitor_contact_r").val(response.V_Phone+" | "+response.V_Email);
                  $("#visitor_detail_r").val(response.V_Gender+" | "+response.V_Dob);

              }
          });


          $("#rmoveworkBtn").unbind('click').bind('click', function(){
              var visitor_id_r = $("#visitor_id_r").val();
              // alert(visitor_id_r);
              $.ajax({
                  url : "removeWork.php",
                  type : "Post",
                  data : {Work_Id : Id, Visitor_Id : $("#visitor_id_r").val(), user_id : $("#user_id").val()},
                  dataType : "json",
                  success:function(response){
                        // alert(response);
                      if(response.success == true){
                          $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                         '</div>');

                            $("#remove_Paragraph").remove();
                            $("#rmoveworkBtn").hide();
                            $("#rmWorkModelBtn").html("Close");
                            $( "#rmove_model_body").hide();

                            work_dt.ajax.reload(null, false);

                      }else{
                          $("#removeMsg").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');
                      }
                  }
              });
          });
      }else{
          alert("Error: Refresh the page again");
      }
  }

  function detailWork(Id){
      // alert("Work Id is"+Id);
      window.location = '../workdetail/workdetail.php?Id=' + Id;
  }
