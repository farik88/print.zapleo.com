/**
 * Created by max on 18.05.17.
 */
var order = null;
$(document).ready(function () {
    $('input[type=tel]').mask("(999) 999-9999");
    var fadeSpeed = 300;
    //Попап с выбором оплаты
    $('.close').on('click', function () {
        $(this).closest('.pay').fadeOut(fadeSpeed);
    });
    $('.notice').on('click', function (e) {
        e.stopPropagation();
    });
    $('.pay').on('click', function (e) {
        $('.pay').fadeOut(fadeSpeed);
    });

    $('.go_pay').on('click',function () {

        if(order){
            getLiqPayButton(order);
            return;
        }

        var deliveryId = $('select[name=delivery] option:selected').attr('value');
        var paymentId = $('select[name=payment] option:selected').attr('value');
        var comment = $('.comment').val();
        var address = $('.address').val();
        var tel = $('input[type=tel]').val();
        if(!(deliveryId && paymentId)) {
            alert(phrases.order1);
            return;
        }
        if(address === ""){
            alert(phrases.order2);
            return;
        }
        if(tel === ""){
            alert(phrases.order3);
            return;
        }

        $.ajax({
            method: 'POST',
            url: '/order/create',
            data: {delivery_id:deliveryId, payment_id : paymentId, comment:comment, address:address },
            success: function(response){

                order = response;
                console.log(response);
                getLiqPayButton(response);

            },
            error: function () {
                alert('error');
            }
        });
    });
    function getLiqPayButton(order_id) {
        console.log(order_id);
        if(!order_id){
            alert(phrases.order4);
            return;
        }

        $.ajax({
            method: 'POST',
            url: '/order/pay-order/'+order_id,
            success: function(response){
                if(response){
                    $('#liqpa_form').html(response);
                    console.log(response);
					//LiqPay button's customization
					$('.pay').fadeIn(fadeSpeed).find('[name="btn_text"]').attr({"type":"submit", "value":phrases.payment}).removeAttr('src', '');
                }
            },
            error: function () {
                alert('error');
            }
        });
    }
});