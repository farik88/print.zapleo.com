(function($){
    $(document).ready(function(){
        
        /*** Vars ***/
        var widget = $('#lang-switcher-widget').get()[0];
        
        /*** Functions calls ***/
        startLangSwitcher();
        
        /*** Functions ***/
        function startLangSwitcher(){
            $(widget).find('.current-lang').on('click', function(){
                if($(widget).hasClass('open')){
                    $(widget).removeClass('open');
                    $(widget).addClass('closed');
                }else{
                    $(widget).removeClass('closed');
                    $(widget).addClass('open');
                }
            });
        }
    });
})(jQuery);