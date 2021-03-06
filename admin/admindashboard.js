$(document).ready(function(){

    gettotalwork();
    getvisitordetail();

    getUserLogDetail();

    $(document).on('click', '#filter_fun', function(){
    
        gettotalwork($("#work_date_from_f").val(), $("#work_date_end_f").val());
    
     });
    
     $(document).on('click', '#clear_filter', function(){
    
        gettotalwork();
    
     });


});

function gettotalwork(date_form = '', date_end = ''){

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "totalWorkDetail", dateform : date_form,  dateend : date_end},
        dataType : "json",
        success:function(response){

            $("#total_work").html(response.length);
            
            var gov_count = 0 ;
            var gov_complete_count = 0;
            var gov_pending_count = 0;
            var gov_underprocess_count = 0;

            var per_count = 0 ;
            var per_complete_count = 0;
            var per_pending_count = 0;
            var per_underprocess_count = 0;

            var inv_count = 0 ;
            var inv_complete_count = 0;
            var inv_pending_count = 0;
            var inv_underprocess_count = 0;

            var job_count = 0 ;
            var job_complete_count = 0;
            var job_pending_count = 0;
            var job_underprocess_count = 0;

            var oth_count = 0 ;
            var oth_complete_count = 0;
            var oth_pending_count = 0;
            var oth_underprocess_count = 0;

            for(var i = 0 ; i < response.length; i++ ){
                switch(response[i].Work_Category){
                    case "Government":
                         gov_count = gov_count + 1;
                        switch(response[i].Status){
                            case "Complete":
                                    gov_complete_count = gov_complete_count + 1 
                                break;
                            case "Pending":
                                    gov_pending_count = gov_pending_count + 1;
                                break;
                            case "Under Process":
                                    gov_underprocess_count = gov_underprocess_count + 1;
                                break;

                        }
                         
                    break;

                    case "Personal":
                        per_count = per_count + 1;
                        switch(response[i].Status){
                            case "Complete":
                                per_complete_count = per_complete_count + 1 
                                break;
                            case "Pending":
                                per_pending_count = per_pending_count + 1;
                                break;
                            case "Under Process":
                                per_underprocess_count = per_underprocess_count + 1;
                                break;

                        }
                         
                    break;

                    case "Invitation":
                        inv_count = inv_count + 1;
                        switch(response[i].Status){
                            case "Complete":
                                inv_complete_count = inv_complete_count + 1 
                                break;
                            case "Pending":
                                inv_pending_count = inv_pending_count + 1;
                                break;
                            case "Under Process":
                                inv_underprocess_count = inv_underprocess_count + 1;
                                break;

                        }
                         
                    break;

                    case "Job":
                        job_count = job_count + 1;
                        switch(response[i].Status){
                            case "Complete":
                                job_complete_count = job_complete_count + 1 
                                break;
                            case "Pending":
                                job_pending_count = job_pending_count + 1;
                                break;
                            case "Under Process":
                                job_underprocess_count = job_underprocess_count + 1;
                                break;

                        }
                         
                    break;


                    case "Other":
                        oth_count = oth_count + 1;
                       switch(response[i].Status){
                           case "Complete":
                            oth_complete_count = oth_complete_count + 1 
                               break;
                           case "Pending":
                            oth_pending_count = oth_pending_count + 1;
                               break;
                           case "Under Process":
                            oth_underprocess_count = oth_underprocess_count + 1;
                               break;

                       }
                        
                   break;

                }
            }

            $("#gov_total").html(gov_count);
            $("#gov_c_total").html(gov_complete_count);
            $("#gov_p_total").html(gov_pending_count);
            $("#gov_up_total").html(gov_underprocess_count);

            $("#per_total").html(per_count);
            $("#per_c_total").html(per_complete_count);
            $("#per_p_total").html(per_pending_count);
            $("#per_up_total").html(per_underprocess_count);

            $("#inv_total").html(inv_count);
            $("#inv_c_total").html(inv_complete_count);
            $("#inv_p_total").html(inv_pending_count);
            $("#inv_up_total").html(inv_underprocess_count);

            $("#job_total").html(job_count);
            $("#job_c_total").html(job_complete_count);
            $("#job_p_total").html(job_pending_count);
            $("#job_up_total").html(job_underprocess_count);

            $("#oth_total").html(oth_count);
            $("#oth_c_total").html(oth_complete_count);
            $("#oth_p_total").html(oth_pending_count);
            $("#oth_up_total").html(oth_underprocess_count);

        }
    });

}

function getvisitordetail(){

    // var d = new Date();
    // var current_Date =  d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
    // $("#today_date").html(current_Date);

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "totalVisitorDetail"},
        dataType : "json",
        success:function(response_v){

            var total_visitor = response_v.length;
            $("#total_visitor").html(total_visitor);
            var total_voter = 0;

            for(var i = 0 ; i < response_v.length; i++ ){

                switch(response_v[i].V_Voter){
                    case "Yes":
                        total_voter = total_voter+1;
                    break;
                    // case "No":
                    // break;

                    // case "Unknown":
                    // break;
                }

            }

            $("#total_voter").html(total_voter);

        }
    });

    $.ajax({
        url : "function.php",
        type : "Post",
        data : {action : "totalVisitor"},
        dataType : "json",
        success:function(response_tv){

            $("#today_visitor").html(response_tv);

        }
    });


}

function getUserLogDetail(){

    user_Log_dt = $('#user_log_table').DataTable({
        "order" : [],
        "ajax" : {
         url:"function.php",
         type:"POST",
         data:{
            action : 'getUserLog'
         }
        },
        responsive: true,
        
    });
    
}