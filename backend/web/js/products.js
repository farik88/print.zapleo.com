/**
 * Created by max on 09.06.17.
 */

$( document ).ready(function() {
    $('td .slider').on('click',function () {
        var saleId = $(this).closest('label[data-prod-id]').data('prod-id');
        var val = $(this).closest('label[data-prod-id]').find('input').val();
        if(val == '1'){
            $(this).closest('label[data-prod-id]').find('input').val('0');
            val = 0;
        }else{
            $(this).closest('label[data-prod-id]').find('input').val('1');
            val = 1;
        }
        $.ajax({
            url: apiPoint + '/products/update-active/'+saleId,
            method: 'POST',
            data: {
                val: val
            },
            success: function(response) {
                if(response == 200){
                    alert('Изменено');
                }else {
                    alert('Ошибка изменения');
                }
            },
            error: function() {
                alert('error3!');
            }
        });
    });
});