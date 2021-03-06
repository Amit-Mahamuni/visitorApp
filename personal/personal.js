$(document).ready(function(){

    // `E_Id`, `E_Student_Name`, `E_Collage_Name`, `E_Class`, `E_T_Fee`, `E_D_Fee`, `V_Id`, `W_Id`, `E_Visibility`

    education_dt = $("#personal_datatable").DataTable({
        "processing": true,
        "serverSide": true,
        // "ajax" : "edicationList_retrive.php",
        "ajax" : {
            url:"edicationList_retrive.php",
            type:"POST"
           }


    });




});