/**
 * Created by max on 15.05.17.
 */
$(document).ready(function () {
    var fadeSpeed = 300;
    //Registration form
    $('.reg').on('click', function () {
        $('.tel').mask("(999) 999-9999");
        $('.data header, .data>div').fadeOut(fadeSpeed, function () {
            $('.registration').fadeIn(fadeSpeed);
        });
    });
});