/**
 * Created by max on 13.05.17.
 */
$(document).ready(function () {
//Amount of cases
    $('.amt .dec').on('click', function () {
        var $output = $(this).parent().next().find('output');
        if( Number($output.val()) > 1 ) {
            $output.val( Number($output.val()) - 1 );
        }
        //edit quantity
        var cartId = $(this).closest('tr[data-cart-id]').data('cart-id');
        var $self = $(this);
        $.ajax({
            method: 'POST',
            url: '/order/edit-count',
            data: {
                val: $output.val(),
                cart_id : cartId
            },
            success: function(response){
                console.log(response);
                if (response == 200){
                    alert(phrases.cart1);
                    location.reload();
                }else{
                    alert(phrases.cart2);
                }
            },
            error: function () {
                alert(phrases.cart3);
            }
        });

    });
    $('.amt .inc').on('click', function () {
        var $output = $(this).parent().prev().find('output');
        $output.val( Number($output.val()) + 1 );
        console.log($output.val());
        var cartId = $(this).closest('tr[data-cart-id]').data('cart-id');
        console.log(cartId);
        $.ajax({
            method: 'POST',
            url: '/order/edit-count',
            data: {
                val: $output.val(),
                cart_id : cartId
            },
            success: function(response){
                console.log(response);
                if (response == 200){
                    location.reload();
                    alert(phrases.cart1);
                }else{
                    alert(phrases.cart2);
                }
            },
            error: function () {
                alert(phrases.cart3);
            }
        });
    });
//Delete product from cart
    $('.remove').on('click', function () {
        var $self = $(this);
        var cartId = $(this).closest('tr[data-cart-id]').data('cart-id');
        if(confirm(phrases.cart4)){
            $.ajax({
                method: 'POST',
                url: '/cart/remove/'+cartId,
                success: function(response){
                    if (response ==200){
                        $self.closest('tr').fadeOut(300);
                        $self.closest('tr').remove();
                        // alert('Удалили');
                        location.reload();
                    }else{
                        alert(phrases.cart5);
                    }
                },
                error: function () {
                    alert(phrases.cart6);
                }
            });
        }
    });

    //coupon
    $('.coupon').on('click',function () {
        var hashCode =$(this).closest('p').find('.coupon_hash').val();
        $.ajax({
            method: 'POST',
            url: '/order/check-coupon',
            data:{hash: hashCode},
            success: function(response){
                if(response){
                    location.reload();
                }
            },
            error: function () {
                alert(phrases.cart7);
            }
        });
    });
});