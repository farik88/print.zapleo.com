$( document ).ready(function() {

   $('#resources-del-btn').on('click',function (e) {
       e.preventDefault();
        var id = $(this).data('resources-id');
        var  obj = $(this).closest('tr[data-key]');
       if (confirm('Вы действительно хотите удалить ресурс?')) {
           $.ajax({
               url: apiPoint + '/folders/remove-resources/' + id,
               method: 'POST',
               success: function (response) {
                   obj.remove();
               },
               error: function () {
                   alert('error3!');
               }
           });
       }
   });
});