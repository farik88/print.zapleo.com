$(document).ready(function () {
    var fadeSpeed = 300;

    function sendUserInfo(data, $self) {
        $.ajax({
            method: 'POST',
            url: '/profile/set-info-user',
            data: data,
            success: function(response){
                $self.closest('label').find('.save').css({'display': 'none'});
                $self.closest('label').find('.edit').css({'display': 'inline-block'});
                console.log(response);
            },
            error: function () {
                alert('error');
            }
        });
    }

    function getLiqPayButton(order_id) {
        console.log(order_id);
        if(!order_id){
            alert('order not found');
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

    //Input enabled
    $('.edit').on('click', function () {
        $(this).fadeOut('fast', function() {
            $(this).prev().fadeIn('fast').prev().removeAttr('disabled').focus();
        });
    });
    //Input disabled
    $('.save').on('click', function () {
        $(this).prev().attr('disabled', 'disabled');
        $(this).fadeOut('fast', function() {
            $(this).next().fadeIn('fast');
        });
    });

    $('#usermail, #username, .adres').change(function () {
        var params = {};
        params[$(this).attr('name')] = $(this).val();
        params['address_id'] = $(this).data('address-id');
        sendUserInfo(params,$(this));
    });

        $('.add_address').change(function () {
           var $self = $(this);
        $.ajax({
            method: 'POST',
            url: '/profile/add-user-address',
            data: { val: $(this).val()},
            success: function(response){
                $self.closest('label').find('.save').css({'display': 'none'});
                $self.closest('label').find('.edit').css({'display': 'inline-block'});
                console.log(response);
            },
            error: function () {
                alert('error');
            }
        });
    });
    //
    // console.log(order);
    // console.log(order_prod);

    // $.each(order_prod,function (index,value) {
    //     $.each(value,function (k,v) {
    //         // console.log(v['order_id']);
    //         $.each(order, function (oK,oV) {
    //             if(v['order_id'] == oV['id']){
    //                 if(oV['status_payment'] !== 0){
    //                     getLiqPayButton(v['order_id'],$('.orders-list li[data-order-id='+v['order_id']+'] .liqpa_form'));
    //                 }
    //             }
    //         })
    //     })
    // });

    $('.pay_now').on('click',function () {
        getLiqPayButton($(this).data('order-id'));
    });



});