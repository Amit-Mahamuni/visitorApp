$(document).ready(function(){

    $(document).on('click','.add',function(){
        var html='';
        html += '<tr>';
        html += '<td><input type="text" name="gvisitor_name[]" class="form-control gvisitor_name" /></td>';
        html += '<td><input type="text" name="gvisitor_phone[]" class="form-control gvisitor_phone" /></td>';       
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-minus" aria-hidden="true"></i> Remove</button></td></tr>';
        $('#group_table').append(html);
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });


    $('#group_from').on('submit', function(event){
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

        var form_data = $(this).serialize();
        if(error == '')
        {
            $.ajax({
                url:"insert.php",
                method:"POST",
                data:form_data,
                // dataType : "json",
                success:function(response)
                {
                    // if(response == 'ok')
                    // {
                        $('#group_table').find("tr:gt(0)").remove();
                        $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                        // alert(data);
                    // }else{
                    //     alert('error for data = '+response);
                    // }
                }
            });
        }
        else
        {
             $('#error').html('<div class="alert alert-danger">'+error+'</div>');
        }
    });
       


});