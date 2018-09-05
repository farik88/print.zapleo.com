$(document).ready(function () {
    // $('div[data-product-id]').css({'transform': 'matrix(0.363, 0, 0, 0.363, 0, 90);'});
    /**
     *
     * @param href
     * @param handler
     * @param time
     */
    function launchInstaLogin(href, handler, time) {
        time = time || 500;
        var newWin = window.open( href,
            "Instagram",
            "width=420,height=230,resizable=yes,scrollbars=yes,status=yes"
        );
        var timer = setInterval(checkChild, time);
        function checkChild() {
            if (newWin.closed) {
                handler(newWin);
                clearInterval(timer);
            }
        }
        newWin.focus();
    }

    /**
     *
     * @param profile
     */
    function fillInstaProfile(profile) {
        var $myProfile = $('.my_pr');
        console.log(profile);
        if(!profile.profile_picture || !profile.full_name) {
            return;
        }
        $myProfile.find('img').attr('src',profile.profile_picture);
        $myProfile.find('a>span').html(profile.full_name);
        $myProfile.click();
    }

    function handleImageAdditing() {
        imgToSmile($(this).attr('src'));
    }



    function fillLoadedImages(images) {
        function generLi(link) {
            return '<li><img class="upl-image" src="' + link + '" alt=""><button type="button"></button></li>';
        }
        var $container = $("#upl-image-container");
        for(var i = 0, size = images.length; i < size; i++ ) {
            var link = images[i];
            console.log(i);
            $container.append(generLi(link));
        }
        $container.find('.upl-image').on('click',handleImageAdditing);
        $container.find('li button').on('click',function() {
            $(this).parents('li').remove();
        });
    }

    function fillInstaImages(images) {
        function generLi(link) {
            return '<li><img class="insta-image" src="' + link + '"  alt=""></li>';
        }
        var $container = $("#insta-image-container");
        if($container.get(0).firstChild !== null) {
            return;
        }

        for(var i = 0, size = images.length; i < size; i++ ) {
            var link = images[i].images.standard_resolution.url;
            $container.append(generLi(link));
        }
        $container.find('.insta-image').on('click',handleImageAdditing);
    }

    function getInstaPhotos(type) {

        type = type || 'self';
        $.ajax({
            method: 'GET',
            url: '/instagram/get-photos',
            data: { 'type': type }, //IF WINDOW THEN FUN BROKEN
            success: function(response,data){
                console.log(response);
                if(response && response.data){
                    fillInstaImages(response.data.data);
                }

            },
            error: function () {
                alert('error');
            }
        });
    }

    if(instaProfile) {
        fillInstaProfile(instaProfile);
    }

    //Делаем фон для canvas
    var canvas = new fabric.Canvas('canvas');
    $('#canvas').css({'background':'url('+buploads+'/'+product['file']['name']+'.'+product['file']['ext']+')'});
    $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px	'});
    var objectArray = [];
    var smiles = [];
    var texts = [];



    $('button.my_pr').on('click', function(e){
        e.preventDefault();
        getInstaPhotos('self');
    });


    $('.instaLoad').on('click', function(){
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });


    $('.magn').click(function(e) {
        var val = $(this).parents('.search-insta').find('.user-tag').val();
        getInstaPhotos(val);
    });

    $('.instaLogin').click(function(){
        $(this).find('a').click();
    });
    $('.instaLogin a').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var self = this;
        launchInstaLogin($(this).attr('href'), function(w){
            if(w.instaErrors || !w.instaProfile) {//form views/instagram/child-window
                alert(phrases.site1);
                console.log(w.instaErrors);
                return;
            }
            fillInstaProfile(JSON.parse(w.instaProfile));
            $('.instaLogin').fadeOut();
            //hide preloader
            $(self).parents('.instagram').find('.hide').removeClass('hide');
        });

        //todo set some preloader

    });


    $("#upload").change(function(){
        var fd = new FormData();
        var files = this.files;
        for (var i = 0, size = files.length; i < size; i++) {
            fd.append("image[]", files[i]);
        }
        console.log(files.length);
        console.log(files);

        $.ajax({
            'url' : '/file/upload-tmp-file',
            'type': 'POST',
            'data' : fd,
            'success' : function(response) {
                if (typeof response.data.links !== "undefined" ) {
                    fillLoadedImages(response.data.links);
                }
                else {
                    alert(phrases.site2);
                }
                console.log(response);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    //"instagram" and "manual" blocks
	$('button.upload').on('click', function () {
		//Active sign
		$(this).addClass('active').siblings('button').removeClass('active');
		//Show appropriate content
		if ($(this).hasClass('any')) {
			$(this).parent().siblings('.manual').show().siblings('.instagram').hide();
		}
		if ($(this).hasClass('inst')) {
			$(this).parent().siblings('.instagram').show().siblings('.manual').hide();
		}
	});

    var fadeSpeed = 300;
    // маштаб value=0
    $('.bg_categories li, .emoji_categories li').on('click',function () {
       $('input[type="range"]').val(0);
    });

    $('.color_file:first').addClass('on');
    var filId = $('.color_file.on').data('color-file-id');
    $.each(colors,function (index,value) {
        // console.log(value);
        if (value['file_id'] == filId){
            $.each(value['file'],function (index,value) {
                if (index == 'name'){
                    window.namefile = value;
                }else if(index == 'ext'){
                    window.extfile = value;
                }
            });
        }
    });
 	//отмечаем по умолчанию первый чехол
	$('.case_type ul li[data-cover-id]:first').addClass('active');
 	//Добавим on class к цвету по умолчанию
	$('li[data-color-file-id]').addClass('on');
	//Переход с выбора чехла на конструктор
	$('.case_type li').on('click', function () {
		$('.case_type').css('display','none').next().css({'display': '-webkit-box','display': '-webkit-flex', 'display': '-ms-flexbox', 'display': 'flex'});
	});
	//Кнопка "Назад"
	$('.sidebar .back').on('click', function () {
		if ( $('.case_type').is(':visible') ) {
			window.location.href = "/"+lang_url + "/site/index";
		} else if ( $('.constructor').is(':visible') ) {
		    console.log(1);
			$('.constructor').css('display','none').prev().css('display','block');
            $('p.line span').css({'width':'50%'});
            $('.stage3').removeClass('completed');
            $('.sidebar .next').remove();

		}
	});
	// Показать кнопку "Готово"
    $('input[name="maintabs"]').on('change', function () {
        if ( this.value == '3' ) {
            $('.sidebar .back, .sidebar .next').css('display','none');
            $('.done').css('display','initial');
        }  else {
            $('.sidebar .back, .sidebar .next').css('display','initial');
            $('.done').css('display','none');
        }
    });

	// Zoom
    $('.range input').on('change', function () {
        var $rangeVal = $(this).val(),
			$images = $('.bg_container li');
	$images.animate({'width': 99 / (4 + (-1) * parseInt($rangeVal)) + "%"}, fadeSpeed);
    });

    $('.range .dec, .range .inc').on('click', function() {
        var val = ( !! $(this).hasClass('inc') )
            ? 1
            : -1;
        var $range = $(this).parents('.range').find('input[type="range"]');
        $range.val(parseInt($range.val()) + val).change();
    });

	// Выбор категории фона
		$('.bg_categories li').on('click', function () {
			$(this).parent().css('display','none').next().css('display','block');
		});

	//Color select block
	$('.colorset input').on('click', function (e) {
	    e.stopPropagation();
	});
	var $colorList = $('.colorset ul');
	//Accordion

	$('.colorset').on('click', function () {
		var $ul_length = $colorList.children('li').length;
		($colorList.height() < 31) ? $colorList.height($ul_length * 36) : $colorList.height(0);
		$(this).toggleClass('upend');
	});
	//Move selected color to top
	$('.colorset input').on('change', function () {
		// --------- Preloader ---------
		// $('.preloader').fadeIn(120).delay(fadeSpeed*2.5).fadeOut(fadeSpeed);
		$(this).filter(':checked').parent().insertBefore($colorList.find('li:first'));
	});

	//Выбо цвета для телефона
	$('.color_file').on('click',function () {
        $('.preloader').fadeIn(10).addClass('active');


        // alert('dasdasdas');
        function changePhoneMask(fullName, width, height) {
            $('.phone-mask').attr('src', buploads+'/covers/' + fullName);
            $('.phone-mask').css({'display':'block','width': width+'px','height': height +'px'});
        }

        $('.color_file').removeClass('on');
		var file_id = $(this).data('color-file-id');
		$(this).addClass('on');
		// console.log(file_id);
		// console.log(colors);
		$.each(colors,function (index,value) {
            // console.log(value);
            if (value['file_id'] == file_id){
                $.each(value['file'],function (index,value) {
                    if (index == 'name'){
                        window.namefile = value;
					}else if(index == 'ext'){
                    	window.extfile = value;
					}
                });
			}
        });
        $('#canvas').css({'background':'url('+buploads+'/colors/'+namefile+'.'+extfile+')'});
        $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px'});
        // console.log(namefile);
        // console.log(extfile);
        var coverTitle = $('li[data-cover-id].active').data('cover-title');
        var coverId = $('li[data-cover-id].active').data('cover-id');
        var coverName = $('li[data-cover-id].active').find('p').text();
        var productId = $('.container').data('product-id');
        var colorId = $('.color_file.on').data('color-id');
        // console.log(colorId);
        // console.log(coverId);
        // console.log(productId);
        if($('.preloader').hasClass('active')){
            $.ajax({
                method: 'POST',
                url: '/site/take-file',
                data: { cover_id: coverId, product_id: productId, color_id: colorId },
                success: function(response,data){
                    if(response && response["status"] == "success"){
                        var fullName = response['data']['file']['name'] + '.' + response['data']['file']['ext'];
                        (coverTitle == "3d")
                            ? changePhoneMask(fullName, product['wspace_width3d'], product['wspace_height3d'])
                            : changePhoneMask(fullName,  product['wspace_width'], product['wspace_height']);

                        return;

                    }
                    console.log(response);
                },
                error: function () {
                    alert('error');
                }
            });

            if(coverTitle == "3d" || coverTitle == "white_silikon" || coverTitle == "black_silikon") {
                $('#canvas').css({'background':'white'});
            }else{
                // $('.preloader').fadeIn(120).delay(fadeSpeed*2.5).fadeOut(fadeSpeed);
                $('#canvas').css({'background':'url('+buploads+'/colors/'+namefile+'.'+extfile+')'});
                $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px'});
            }
            $('.tabs input[value=2]').removeAttr('disabled','disabled');
            if(coverTitle == "silikon"){
                $('.tabs input[value=2]').attr('disabled','disabled');
            }


            if(coverTitle == "3d"){
                canvas.setWidth(product['wspace_width3d'] );
                canvas.setHeight(product['wspace_height3d']);
                canvas.calcOffset();
                $('#canvas').css({'background-size':''+product['wspace_width3d']+'px '+product['wspace_height3d']+'px'});
                $('#canvas, .container, .helper-mask').css({'width': product['wspace_width3d']+'px','height':product['wspace_height3d']+'px'});
            }else {
                canvas.setWidth(product['wspace_width'] );
                canvas.setHeight(product['wspace_height']);
                canvas.calcOffset();
                $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px'});
                $('#canvas, .container, .helper-mask').css({'width': product['wspace_width']+'px','height':product['wspace_height']+'px'});
            }

            setTimeout(function() {
                $('.preloader').fadeOut(fadeSpeed);
            }, 1000);
        }
    });
    // forCanvas
    function imgToSmile(src) {
        var img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function() {
            imgFabric = new fabric.Image(img);
            imgFabric.set({
                left: 80,
                top: 200,
                // width: 100,
                // height: 100
                // scaleX: 2,
                // scaleY: 2,
                borderColor: '#00baff',
                cornerColor: '#00baff',
                rotatingPointOffset: 100,
                cornerSize: 45,
                transparentCorners: false
            });
            canvas.add(imgFabric);
            objectArray.push(imgFabric);
            canvas.setActiveObject(imgFabric);
            smiles.push(imgFabric);
            canvas.renderAll();
            imgFabric.id = smiles.length - 1;

        };
        img.src = src;

        // fabric.util.loadImage(src, function(img) {
        //     imgFabric = new fabric.Image(img);
        //     imgFabric.set({
        //         left: 80,
        //         top: 200,
        //         // width: 100,
        //         // height: 100
        //         // scaleX: 2,
        //         // scaleY: 2,
        //         borderColor: 'black',
        //         cornerColor: 'black',
        //         cornerSize: 25,
        //         transparentCorners: false
        //     });
        //     canvas.add(imgFabric);
        //     objectArray.push(imgFabric);
        //     canvas.setActiveObject(imgFabric);
        //     smiles.push(imgFabric);
        //     canvas.renderAll();
        //     imgFabric.id = smiles.length - 1;
        // });
    }


    //Выбор чехла progres bar
    $('.case_type ul li').on('click',function () {
        $('.preloader').fadeIn(10).addClass('active');
        // alert(1);
        //чистим тип чихла
        if($('.preloader').hasClass('active')){

        $('.container').removeClass('case3d');
        $('.name_cover').text($(this).find('p').text());
        $('.helper-mask').attr('src','').css({'width': product['wspace_width']+'px','height':product['wspace_height']+'px'});
        $('.case_type ul li[data-cover-id]').removeClass('active');
        $(this).addClass('active');
        $('p.line span').css({'width':'100%'});
        $('.stage3').addClass('completed');
        $(this).addClass('active');

        var coverTitle = $(this).data('cover-title');
        var coverId = $(this).data('cover-id');
        var coverName = $(this).find('p').text();
		var productId = $('.container').data('product-id');
		var colorId = $('.color_file.on').data('color-id');

            $.ajax({
                method: 'POST',
                url: '/site/take-file',
                data: { cover_id: coverId, product_id: productId, color_id: colorId },
                success: function(response,data){
                    if(response && response.data){
                        console.log(response);
                        response = response.data; // for legacy code
                        // console.log(product);
                        if(coverTitle == "3d"){
                            console.log(1);
                            // $('.container').addClass('case3d');
                            $('.phone-mask').attr('src', buploads+'/covers/'+response['file']['name']+'.'+response['file']['ext']);
                            $('.phone-mask').css({'display':'block','width': product['wspace_width3d']+'px','height':product['wspace_height3d']+'px'});
                            // $('.container').css({'display':'block','width': product['wspace_width3d']+'px','height':product['wspace_height3d']+'px'});
                        }else{
                            $('.phone-mask').attr('src', buploads+'/covers/'+response['file']['name']+'.'+response['file']['ext']);
                            $('.phone-mask').css({'display':'block','width': product['wspace_width']+'px','height':product['wspace_height']+'px'});
                            // $('.container').css({'display':'block','width': product['wspace_width']+'px','height':product['wspace_height']+'px'});
                        }
                    }
                },
                error: function () {
                    alert('error');
                }
            });
            if(coverTitle == "3d" || coverTitle == "white_silikon" || coverTitle == "black_silikon") {
                $('#canvas').css({'background':'white'});
            }else{
                $('#canvas').css({'background':'url('+buploads+'/colors/'+namefile+'.'+extfile+')'});
                $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px'});
            }
            $('.tabs input[value=2]').removeAttr('disabled','disabled');
            if(coverTitle == "silikon"){
                $('.tabs input[value=2]').attr('disabled','disabled');
            }

            if(coverTitle == "3d"){
                canvas.setWidth(product['wspace_width3d'] );
                canvas.setHeight(product['wspace_height3d']);
                canvas.calcOffset();
                $('#canvas').css({'background-size':''+product['wspace_width3d']+'px '+product['wspace_height3d']+'px'});
                $('#canvas, .container, .helper-mask').css({'width': product['wspace_width3d']+'px','height':product['wspace_height3d']+'px'});
            }else {
                canvas.setWidth(product['wspace_width'] );
                canvas.setHeight(product['wspace_height']);
                canvas.calcOffset();
                $('#canvas').css({'background-size':''+product['wspace_width']+'px '+product['wspace_height']+'px'});
                $('#canvas, .container, .helper-mask').css({'width': product['wspace_width']+'px','height':product['wspace_height']+'px'});
            }


            if($('.add_button_this .next').length == 0){
                $('.add_button_this').append('<button type="button" class="next">Далее</button>');
            }
            //helper
            $('footer .next').on('click',function () {
                // $('.case_type li, .grid .marking, .design label, ' +
                //     '.bg_categories .fon_click, .emoji_categories .emoji_click, .tabs label:not(.upload)').addClass('help');
                //
                // setTimeout(function () {
                //     $('.case_type li, .grid .marking, .design label, ' +
                //         '.bg_categories .fon_click, .emoji_categories .emoji_click, .tabs label:not(.upload)').removeClass('help');
                // }, 1000)
                $('.case_type li').addClass('help');

                setTimeout(function () {
                    $('.case_type li').removeClass('help');
                }, 1000);

                if($('.tabs [value=1]').attr('checked') && $('.tabs [value=2]').attr('disabled') !== "disabled"){
                    $('.tabs [value=2]').attr('checked','checked');
                    $('.tabs [value=1]').removeAttr('checked');
                }else if($('.tabs [value=2]').attr('checked') ){
                    $('.tabs [value=2]').removeAttr('checked');
                    $('.tabs [value=3]').attr('checked','checked');
                    $('input[name="maintabs"]').change();
                }

                if($('.tabs [value=1]').attr('checked') && $('.tabs [value=2]').attr('disabled') == "disabled"){
                    $('.tabs [value=3]').attr('checked','checked');
                    $('.tabs [value=1]').removeAttr('checked');
                    $('input[name="maintabs"]').change();
                }
            });
            setTimeout(function() {
                $('.preloader').fadeOut(fadeSpeed);
            }, 1000);

        }

    });
    //Оброботка клика на разметку
    $('.grid .marking').on('click',function () {
        $('.grid .marking').removeClass('active');
        var mask_src = $(this).find('image').attr('xlink:href');
        $('.helper-mask').attr('src', mask_src);
        $(this).addClass('active');
        var coverTitle = $('li[data-cover-id].active').data('cover-title');

        if(coverTitle == "3d"){
            $('.helper-mask').css({'width': product['wspace_width3d']+'px','height':product['wspace_height3d']+'px'});
        }
        if($('.tabs [value=2]').attr('disabled') == "disabled"){
            console.log(1);
            $('.tabs [value=3]').attr('checked','checked');
        }else{
            console.log(2);
            $('.tabs [value=2]').attr('checked','checked');
        }
    });

    //Кнопка незад
    $('.return_background').on('click',function () {
        $('.bg_categories').attr('style','');
        $('.emoji_categories').css({'display':'block'});
        if($('.design label[for="tab4"]').attr('class') == 'activeti'){
            $('.design .emoji_categories').css({'display':'none'});
        }
        $('.backgrounds').css({'display':'none'});
    });

    //----------------------------------------
    //  Фоны раздел
    //----------------------------------------
    $('.fon_click').on('click',function () {
        //чистим контейнер
        $('.bg_container li').remove();
        var folderId = $(this).data('folder-id');
        // console.log(folderId);
        $.ajax({
            method: 'POST',
            url: '/site/take-backg/'+folderId,
            success: function(response,data){
                console.log(response);
               if(response){
                   response = response.data;
                   $.each(response,function (index,value) {
                       $('.zoom_bar title').val(value['folder']['name']);
                       $('.bg_container').append('<li>' +
                           '<img class="smile" src="'+buploads+'/resources/background/'+value['folder']['name']+'/'+value['name']+'.'+value['ext']+'" alt="">');
                   });

               }else {
                   alert('Array isset');
               }
            },
            error: function () {
                alert('error');
            }
        });
    });

    //----------------------------------------
    //  Emoji раздел
    //----------------------------------------
    $('.emoji_click').on('click',function () {
        //чистим контейнер
        $('.bg_container li').remove();
        $('.backgrounds').css({'display':'block'});
        //прячим папки в emoji
        $('.emoji_categories').css({'display':'none'});
        var folderId = $(this).data('folder-id');
        // console.log(folderId);
        $.ajax({
            method: 'POST',
            url: '/site/take-backg/'+folderId,
            success: function(response,data){
                console.log(response);
                if(response){
                    response = response.data;
                    $.each(response,function (index,value) {
                        $('.zoom_bar title').val(value['folder']['name']);
                        $('.bg_container').append('<li>' +
                            '<img class="smile" src="'+buploads+'/resources/emoji/'+value['folder']['name']+'/'+value['name']+'.'+value['ext']+'" alt="">');
                    });

                }else {
                    alert('Array isset');
                }
            },
            error: function () {
                alert('error');
            }
        });
    });


    $('.design label').on('click',function () {
        $('.design label').removeClass('activeti');
        $(this).addClass('activeti');
        $('.bg_categories').attr('style','');
        $('.backgrounds').css({'display':'none'});
        $('.emoji_categories').css({'display':'none     '});
    });
    $('.design label[data-type-id=2]').on('click',function () {
        $('.emoji_categories').css({'display':'none'});
    });
    $('.design label[data-type-id=0]').on('click',function () {
        $('.emoji_categories').css({'display':'block'});
    });

    // Добавление элемента на канвас
    $('.sidebar').on('click','.smile',handleImageAdditing);


    //-----------------------------------
    //          Текст раздел
    //-----------------------------------
    //добавление текста
    $('.addtext').on('click',function () {
        var valtext = $('#text').val();
        var fontsiz = ($('#fontsize').length ? $('#fontsize').val() : 24);

        fontsiz = (fontsiz*2.5);

        if (valtext != ''){
            var iText7 = new fabric.Text(valtext, {
                left: 90,
                top: 200,
                padding: 7,
                fontSize: fontsiz,
                borderColor: '#00baff',
                cornerColor: '#00baff',
                rotatingPointOffset: 100,
                cornerSize: 45,
                transparentCorners: false
            });
            texts.push(iText7);
            iText7.id = texts.length - 1;
            canvas.add(iText7).setActiveObject(iText7);
        }else {
            var iText7 = new fabric.IText(phrases.site3, {
                left: 90,
                top: 200,
                padding: 7,
                fontSize: fontsiz,
                borderColor: '#00baff',
                cornerColor: '#00baff',
                rotatingPointOffset: 100,
                cornerSize: 45,
                transparentCorners: false
            });
            texts.push(iText7);
            iText7.id = texts.length - 1;
            canvas.add(iText7).setActiveObject(iText7);
            iText7.enterEditing();
        }
    });

    //Изминение цвета
    $('.colors li').on('click',function () {
        var color = $(this).find('input').attr('id');
        var tObj = canvas.getActiveObject();
        if(tObj){
            tObj.set({fill : "#"+color});
            canvas.renderAll();
        }else {
            alert(phrases.site4);
        }
    });

    //Изминения шрита
    $('.fontsfamily').on('click',function(){
        var mFont = $(this).data('font-type');
        var tObj = canvas.getActiveObject();
        if(tObj){
            tObj.set({fontFamily : mFont});
            canvas.renderAll();
        }else {
            alert(phrases.site4);
        }
    });

    //Изминение zindex
    $('.zindex').on('click',function () {
        var activeObject=canvas.getActiveObject(),
            activeGroup=canvas.getActiveGroup();
        if (activeObject) {
            activeObject.bringForward();
            canvas.renderAll();
        }
        else if (activeGroup) {
            canvas.getActiveGroup().forEachObject(function(o){canvas.bringForward(o); });
            //activeGroup.bringForward();
            canvas.renderAll();
        }
    });

    //удаление обьекта
    $(".remove").click(function(){
        canvas.isDrawingMode = false;
        deleteObjects();
    });
    function deleteObjects(){
        var activeObject = canvas.getActiveObject(),
            activeGroup = canvas.getActiveGroup();
        if (activeObject) {
            if (confirm(phrases.site5)) {
                canvas.remove(activeObject);
            }
        }
        else if (activeGroup) {
            if (confirm(phrases.site6)) {
                var objectsInGroup = activeGroup.getObjects();
                canvas.discardActiveGroup();
                objectsInGroup.forEach(function(object) {
                    canvas.remove(object);
                });
            }
        }else if (!activeObject || !activeGroup){
            alert(phrases.site7);
        }
    }

    //сброс
    $('.reset').on('click',function () {
        if (confirm(phrases.site8)) {
            canvas.clear();
        }
    });
    //добавление элементов на канвас
    $('.shuffle').on('click',function () {
        console.log(smile_path);
        canvas.clear();
        var FontFamily = [];
        var FontColor = [];
        var em_int = randomInteger(1, smile_path['emoji'].length) - 1;
        var bg_int = randomInteger(1, smile_path['background'].length) -1;
        var ff_int = randomInteger(1, FontFamily.length) -1;
        var fc_int =  randomInteger(1, FontColor.length) -1;

        $('.fonts li').each(function (index,value) {
            FontFamily.push($(this).data('font-type'));
        });

        $('.colors li').each(function (index,value) {
            FontColor.push($(this).find('input').attr('id'));
        });

        var iText7 = new fabric.IText(phrases.site9, {
            left: 90,
            top: 200,
            padding: 7,
            fontSize: 60,
            // textColor: '#f55',
            borderColor: '#00baff',
            cornerColor: '#00baff',
            rotatingPointOffset: 100,
            cornerSize: 45,
            transparentCorners: false
        });
        iText7.setColor('#'+FontColor[fc_int]);
        iText7.set({fontFamily : FontFamily[ff_int]});
       //  texts.push(iText7);
       //  iText7.id = texts.length - 1;
        canvas.add(iText7).setActiveObject(iText7);
        iText7.enterEditing();

        imgToSmile(smile_path['emoji'][em_int]);
        imgToSmile(smile_path['background'][bg_int]);

        $('.case_type ul li.active').trigger('click');
    });
    function randomInteger(min, max) {
        var rand = min - 0.5 + Math.random() * (max - min + 1);
        rand = Math.round(rand);
        return rand;
    }
    // "Вы успешно добавили в корзину"
    $('.done').on('click', function () {
        $('.success').fadeIn(fadeSpeed);
        $('.success figcaption p').text($('.case_type li.active').find('p').text());
        canvas.deactivateAll();

        $('.success .case').attr('src',canvas.toDataURL('png'));
        if($('li[data-cover-id].active').data('cover-title') == 'silikon'){
            $('.phone_preview').attr('src',buploads+'/colors/'+namefile+'.'+extfile);
        }
        if($('li[data-cover-id].active').data('cover-title') == '3d'){
            $('.success .custom_design').addClass('case3d');
        }else{
            $('.success .custom_design').removeClass('case3d');
        }

        $('.mask_preview').attr('src',$('.phone-mask').attr('src'));
        // console.log(canvas.toDataURL('png'));
    });
    $('.close').on('click', function () {
        $(this).closest('.success').fadeOut(fadeSpeed);
    });
    $('.notice').on('click', function (e) {
        e.stopPropagation();
    });
    $('.success').on('click', function (e) {
        $('.success').fadeOut(fadeSpeed);
    });
    $('.success .back').on('click',function (e) {
        e.preventDefault();
        $(this).closest('.success').fadeOut(fadeSpeed);
    });

    // //отправка данных в корзину
    $('.add_cart').on('click',function (e) {
        e.preventDefault();
        var $self = $(this);
        var printData = canvas.toDataURL('png');
        $.post(
            {
                'data' : { 'file': printData },
                'url': '/file/save-png',
                'success': function(resp) {
                    if(resp.status != "success" || ! resp.data.id ) {
                        //todo make pretty error message
                        alert('error');
                        console.log(resp);
                        return;
                    }
                    var product_id = $('.container[data-product-id]').data('product-id'),
                        image_id =  resp.data.id,total = product['price'],count = 1,cover_id = $('li[data-cover-id].active').data('cover-id'),
                        color_id = $('.color_file.on').data('color-id');
                    $.ajax({
                        method: 'POST',
                        url: '/cart/add',
                        data: {
                            product_id :product_id,
                            image_id :image_id,
                            total :total,
                            count :count,
                            cover_id :cover_id,
                            color_id: color_id
                        },
                        success: function(response){
                            if (response == 200){
                                location.href = '/'+lang_url + '/cart';
                                // $.ajax({
                                //     method: 'POST',
                                //     url: '/cart/index'
                                // });
                            }else{
                                alert(phrases.site10);
                            }
                            console.log(response);
                        },
                        error: function () {
                            alert('error123');
                        }
                    });
                }
            }
        );
        $('.add_cart').off('click');
    });

    //Mobile controls
    $('.mob_constr').on('click', function (e) {
        e.stopPropagation();
        $('.sidebar').toggleClass('expanded');
    });
    //Hide mobile sidebar if click outside
    $('body').on('click', function () {
        if ($('.mob_constr').is(':visible') && $('.sidebar').is(':visible')) {
            $('.sidebar').removeClass('expanded');
        }
    });
    //StopPropagation on sidebar
    $('.sidebar').on('click', function (e) { e.stopPropagation() });

	//Color select block position
	function colorsetPosition () {
		if ($(window).width() > 680) {
			var rightOffset = $('.sidebar').width();
			$('.colorset').css('right', rightOffset + 33);
		} else {
			$('.colorset').css('right', '33px');
		}
	}
	colorsetPosition();

	//On resize fix
	$(window).resize(function () {
		colorsetPosition();
	});

	$('.case_part').on('click',function () {
        $('.constructor').css({'display':'none'});
        $('.case_type').css({'display':'block'});
        $('p.line span').css({'width':'50%'});
    });

    // $('.case_design').on('click',function () {
    //     $('.constructor').css({'display':'flex'});
    //     $('.case_type').css({'display':'none'});
    //     $('p.line span').css({'width':'100%'});
    // });
});
