/**
 * Created by max on 13.04.17.
 */
$( document ).ready(function() {
   $('td .slider').on('click',function () {
        var couponId = $(this).closest('label[data-coupon-id]').data('coupon-id');
        var val = $(this).closest('label[data-coupon-id]').find('input').val();
        if(val == '1'){
            $(this).closest('label[data-coupon-id]').find('input').val('0');
            val = 0;
        }else{
            $(this).closest('label[data-coupon-id]').find('input').val('1');
            val = 1;
        }
       $.ajax({
           url: apiPoint + '/coupons/update-active/'+couponId,
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
               alert('error33!');
           }
       });
   });
});