<script>
(function($){
    $(document).ready(function(){
        
        $('.case_type li').on('click', function () {
            initConstructorHelpTour();
	});
        
        function initConstructorHelpTour(){
        
            /* Vars */
            var tour;
            var page_blocks = [
                $('.logo').get()[0],                //Логотип
                $('.profile').get()[0],             //Кнопка "Профиль"
                $('.device-desc').get()[0],         //Описание устройства
                $('button.shuffle').get()[0],       //Кнопка "Случайно"
                $('button.reset').get()[0],         //Кнопка "Сброс"
                $('button.remove').get()[0],        //Кнопка "Удалить"
                $('button.zindex').get()[0],        //Кнопка "Пререместить слой"
                $('.colorset').get()[0],            //Выбор цвета
                $('.canvas-block').get()[0],        //Изображение телефона
                $('.add_button_this').get()[0],     //Кнопки внизу конструктора
                $('.sidebar>header').get()[0],      //Навигация по этапам
                $('.constructor').get()[0]          //Тело конструктора
            ];

            /* Configurate */
            tour = new Shepherd.Tour({
              defaults: {
                classes: 'shepherd-theme-arrows',
                scrollTo: true,
                showCancelLink: true
              }
            });

            /* Step 1 */
            tour.addStep('help-step-1', {
                text: '<?php echo $tour_texts['step-1']; ?>',
                attachTo: '.constructor .grid>ul left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 2 */
            tour.addStep('help-step-2', {
                text: '<?php echo $tour_texts['step-2']; ?>',
                attachTo: '.constructor .tabs label[for="tab1"] left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab1"]').click();
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 3 */
            tour.addStep('help-step-3', {
                text: '<?php echo $tour_texts['step-3']; ?>',
                attachTo: '.constructor .tabs label[for="tab2"] left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab2"]').click();
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 4 */
            tour.addStep('help-step-4', {
                text: '<?php echo $tour_texts['step-4']; ?>',
                attachTo: '.design>.activeti left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab3"]').click();
                    $('label[for="tab4"]').click();
                    $('.bg_categories>li:first-child').click();
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 5 */
            tour.addStep('help-step-5', {
                text: '<?php echo $tour_texts['step-5']; ?>',
                attachTo: '.constructor .design>.activeti left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab3"]').click();
                    $('label[for="tab5"]').click();
                    $('.emoji_categories>li:first-child').click();
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 6 */
            tour.addStep('help-step-6', {
                text: '<?php echo $tour_texts['step-6']; ?>',
                attachTo: '.constructor label[for="tab6"] left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: function(){
                            // Open colorset
                            $('.colorset').each(function(){
                                if(!$(this).hasClass('upend')){$(this).click();}
                            });
                            // Show next step only when colorset will be open
                            setTimeout(function(){
                                tour.next();
                            }, 200);
                    }}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab3"]').click();
                    $('label[for="tab6"]').click();
                    $('.colorset.upend').click();//закрыть
                    var constructor = $('.constructor').get()[0];
                    focusShadowOn(constructor);
                }
            });
            /* Step 7 */
            tour.addStep('help-step-7', {
                text: '<?php echo $tour_texts['step-7']; ?>',
                attachTo: '.colorset bottom',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('label[for="tab1"]').click();
                    var colorset = $('.colorset').get()[0];
                    focusShadowOn(colorset);
                }
            });
            /* Step 8 */
            tour.addStep('help-step-8', {
                text: '<?php echo $tour_texts['step-8']; ?>',
                attachTo: '.controls>ul .shuffle right',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: function(){
                            // Open colorset
                            $('.colorset').each(function(){
                                if(!$(this).hasClass('upend')){$(this).click();}
                            });
                            // Show next step only when colorset will be open
                            setTimeout(function(){
                                tour.back();
                            }, 200);
                    }},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    $('.colorset.upend').click();//закрыть
                    var button = $('button.shuffle').get()[0];
                    focusShadowOn(button);
                }
            });
            /* Step 9 */
            tour.addStep('help-step-9', {
                text: '<?php echo $tour_texts['step-9']; ?>',
                attachTo: '.controls>ul .reset right',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    var button = $('button.reset').get()[0];
                    focusShadowOn(button);
                }
            });
            /* Step 10 */
            tour.addStep('help-step-10', {
                text: '<?php echo $tour_texts['step-10']; ?>',
                attachTo: '.controls>ul .remove right',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    var button = $('button.remove').get()[0];
                    focusShadowOn(button);
                }
            });
            /* Step 11 */
            tour.addStep('help-step-11', {
                text: '<?php echo $tour_texts['step-11']; ?>',
                attachTo: 'button.zindex left',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Назад', action: tour.back},
                    {text: 'Далее', action: tour.next}
                ],
                beforeShowPromise: function(){
                    var button = $('button.zindex').get()[0];
                    focusShadowOn(button);
                }
            });
            /* Step 12 */
            tour.addStep('help-step-12', {
                text: '<?php echo $tour_texts['step-12']; ?>',
                attachTo: '',
                classes: 'shepherd-theme-arrows',
                buttons: [
                    {text: 'Ok', action: tour.complete}
                ],
                beforeShowPromise: function(){
                    hideShadow();
                }
            });

            /* Tour events */
            tour.on('start', function(){
                for(var i=0; i < page_blocks.length; i++){
                    $(page_blocks[i]).addClass('no-clicks');
                }
            });
            tour.on('complete', function(){
                finishTour();
            });
            tour.on('cancel', function(){
                finishTour();
            });

            /* Start help tour */
            tour.start();
            
            function finishTour(){
                for(var i=0; i < page_blocks.length; i++){
                    $(page_blocks[i]).removeClass('no-clicks');
                }
                hideShadow();
                $.ajax({
                    type: 'POST',
                    url: '/site/change-constructor-help-tour-status',
                    data : {
                        help_tour_status : 'finished'
                    },
                    success: function (data) {}
                });
            }

            function focusShadowOn(element, shadow_margin=10){
                /* Create canvas */
                var canvas = document.getElementById("dark-master-canvas");
                var ctx = canvas.getContext('2d');
                /* Clean canvas */
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                /* Make canvas fullscreen */
                canvas.width  = $('#dark-master').width();
                canvas.height = $('#dark-master').height();
                /* Calculate coordinates */
                var x1 = parseInt($(element).offset().left);
                var y1 = parseInt($(element).offset().top);
                var width = parseInt($(element).width());
                var height = parseInt($(element).height());
                /* Fill black square */
                ctx.fillStyle="rgba(0, 0, 0, 0.5)";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                /* Clear square */
                ctx.clearRect((x1-shadow_margin), (y1-shadow_margin), width+shadow_margin*2, height+shadow_margin*2);
                /* Show canvas */
                $('#dark-master').show();
            }

            function hideShadow(){
                $('#dark-master').hide();
            }
        }
        
    });
})(jQuery);
</script>