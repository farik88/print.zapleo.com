/**
 * Created by max on 27.04.17.
 */
var apiPoint = yiiConfig["apiUrl"];
$(document).ready(function(){
    
    //Добавляем подчеркивание первой метки
    $('.brands li a:first').addClass('current');
    
    //Переключаем при выбори метки
    $('.brands a').on('click',function () {
        var label_id = $(this).data('label-id');
        $('.slider div, .slider button').remove();
        $('.slider').removeClass('slick-initialized','slick-slider');
        
        //Заполняем слайдер изображениями
        $.each(products, function (index,value) {
            var $self = value;
            $.each(value['productLabels'],function (index,value) {
                if (value['label_id'] != label_id) {
                    return;
                }
                var sales = '';
                if(($self['productSales'].length && $self['productSales'][0]['activeSale'])) {
                    var type = $self['productSales'][0]['activeSale']['type_text'];
                    var val = $self['productSales'][0]['activeSale']['value'];
                    sales = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"> \
                                <path d="M0 30.17A30.17 30.17 0 1 0 30.16 0 30.2 30.2 0 0 0 0 30.17zm2.4 0a27.75 27.75 0 1 1 27.76 27.75A27.78 27.78 0 0 1 2.4 30.17z"></path> \
                                <text fill="#333" transform="translate(30.4 36) scale(1)">-'+ val +' ' + type + '</text> \
                            </svg>';
                }
                $('.slider').append(
                    '<div>' +
                        '<figure>'+
                        '<a class="goToo sale" data-method="post" href="/'+lang_url+'/site/create/'+$self['id']+'" data-product-id="'+$self['id']+'">' +
                            sales +
                        '<img src="'+buploads+'/'+$self['file']['name']+'.'+$self['file']['ext']+'"/>'+
                            '<figcaption>'+
                                '<h4>'+$self['name'] + '</h4>'+
                            '</figcaption>'+
                        '</a>'+
                        '</figure>' +
                    '</div>'
                );
            });
        });
        $('.brands a').removeClass('current');
        $(this).addClass('current');
        
        // Create slider
        var mobile_breakpoint = 768;
        var slider = $('.slider').slick({
            lazyLoad: 'progressive',
            zIndex: 1,
            centerMode: true,
            autoplay: true,
            autoplaySpeed: 3000,
            centerPadding: '60px',
            slidesToShow: 5,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 980,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: mobile_breakpoint,
                    settings: {
                        arrows: false,
                        centerPadding: '22%',
                        slidesToShow: 1,
                        autoplay: false
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        arrows: false,
                        centerPadding: '19%',
                        slidesToShow: 1,
                        autoplay: false
                    }
                },
                {
                    breakpoint: 380,
                    settings: {
                        arrows: false,
                        centerPadding: '70px',
                        slidesToShow: 1,
                        autoplay: false
                    }
                }
            ]
        });
        
        /* Slider events */
        //Деактивируем клики по ссылкам, которые не на центральном слайде
        $(slider).find('a').on('click', function(){
            // Делаем только на мобильном разрешении экрана
            if($('body').width() <= mobile_breakpoint){
                var link = this;
                var slide = $(link).parents('.slick-slide')[0];
                var link_tabindex = $(link).attr('tabindex');
                if(link_tabindex !== '0'){
                    $('.slider').slick('slickGoTo', $(slide).data('slickIndex'));
                    return false;
                }
            }
        });
    });
    
    //Выбор первого бренда
    $('.brands a')[0].click();
    
    //Выбор девайса
    $('.mode li').on('click', function () {
        $('.big_btn').removeClass('selected');
        $(this).find('button.big_btn').addClass('selected');
        return false;
    });
    
});