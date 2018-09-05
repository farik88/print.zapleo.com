$( document ).ready(function() {
    $('th[data-col-seq="1"]').append('<input type="checkbox" />');



    $('.confirm').on('click',function () {
        var emails = [];
        $('#w4-container input:checked').each(function () {
            emails.push($(this).val());
        });
        var text = $('#message_text').val();
        if(text !== ''){
            $.ajax({
                url: apiPoint + '/emails/send-to/',
                method: 'POST',
                data: {
                    emails: emails,
                    text : text
                },
                success: function(response) {
                    alert('В success');
                },
                error: function() {
                    alert('error3!');
                }
            });
        }else {
            alert('Заполните текст сообщения');
        }

    });
});