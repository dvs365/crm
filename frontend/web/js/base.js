$(document).ready(function(){
	
	
	/*** проверки при загрузке ***/
	
	/* устанавливаем фокус */
	$('[set~=focus]').each(function(){
		if ( !$(this).is(':focus') ) {
			$(this).focus();
		}
	});
	
	/*** /// проверки при загрузке ***/
	
	
	/*** "жизнь" элементов ***/
	
	/* ввод в форму */
	var objsendtype = [];
	$('input[type=text], input[type=password]').keyup(function(e){
		$('[end-life~=input-type]').each(function(){
			objsendtype.push(this);
		});
		$(objsendtype).fadeOut(200, function(){
			$(objsendtype).remove();
		});
	});
	
	/* 5 секунд */
	var objs5sec = [];
	$('[end-life~=5-sec]').each(function(){
		objs5sec.push(this);
	});
	setTimeout(function(){
		$(objs5sec).fadeOut(200, function(){
			$(objs5sec).remove();
		});
	}, 5000);
	
	/*** /// "жизнь" элементов ***/
	
	
	
	/*** выбор даты - карточка клиента ***/
	
	/* устанавливаем фокус */
	$( function() {
		$( "#datepicker" ).datepicker();
	} );
	
	if ( $('[datepicker]').length ) {
		$('[datepicker]').datepicker({
			numberOfMonths: 1,
			changeMonth: true,
			changeYear: true,
			inline: true
		});
		$('[datepicker]').datepicker($.datepicker.regional['ru']);
	}
	
	/*** выбор даты - дела ***/
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["ru"]);
	jQuery("#date").datepicker({
		numberOfMonths: 2,
		showButtonPanel: true,
		changeMonth: true,
		//changeYear: true
	});
	
	jQuery( "#datestart" ).datepicker({
		defaultDate: "+1w",
		numberOfMonths: 2,
		showButtonPanel: true,
		changeMonth: true,
		onSelect: function( selectedDate ) {
			jQuery( "#dateend" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	jQuery( "#dateend" ).datepicker({
		defaultDate: "+1w",
		numberOfMonths: 2,
		showButtonPanel: true,
		changeMonth: true,
		onSelect: function( selectedDate ) {
			jQuery( "#datestart" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	/*** /// выбор даты ***/
	
	/*** включаем-выключаем якорь ***/
		
	$('.add-main').on('click', function(){
    $(this).toggleClass('added-main');
	});

	/*** складываем-раскладываем яндекс-карту ***/
	
		if ( $('.expand-link').length ) {
		$('.expand-link').next('.expand-block').hide();
	}
	$(document.body).on('click','.expand-link',function(){
		if ( !$(this).next('.expand-block').is(':visible') ) {
			$(this).next('.expand-block').slideDown();
		}
		else {
			$(this).next('.expand-block').slideUp();
		}
	});
	
	
	/*** складываем-раскладываем общую инфу в карточке клиента ***/
	
	$('.expand-link-com-inf').click(function(){
		if ( !$(this).next('.expand-block-com-inf').is(':visible') ) {
			$(this).next('.expand-block-com-inf').slideDown();
		}
		else {
			$(this).next('.expand-block-com-inf').slideUp();
		}
	});
	
	if ( $('[expand-link-movetorefused]').length ) {
		$('[expand-link-movetorefused]').next('[expand-block-movetorefused]').hide();
	}
	$('[expand-link-movetorefused]').click(function(){
		if ( !$(this).next('[expand-block-movetorefused]').is(':visible') ) {
			$(this).next('[expand-block-movetorefused]').slideDown();
		}
		else {
			$(this).next('[expand-block-movetorefused]').slideUp();
		}
	});
	
	/*** поворачиваем стрелку вверх-вниз там же ***/
		
	$('.expand-link-com-inf').on('click', function(){
    $(this).toggleClass('hidden');
	});
	
	/*** добавляем элементы ***/
	
	$('[add-jur],[add-phone],[add-mail],[add-adress]').on('click', function(){
		$(this).prev().clone().insertBefore(this).find('input').val('');
	});
	
	$('[add-contact]').on('click', function(){
		var i = $(this).prev().clone().insertBefore(this);
		$(i).find('[phoneremove]').slice(1).remove();
		$(i).find('[mailremove]').slice(1).remove();
		$(i).find('input').val('');
	});
	
	$(document.body).on('click', '[add-phone1]', function(){
		$(this).prev().clone().insertBefore(this).find('input').val('');
	});
	
	$(document.body).on('click', '[add-mail1]', function(){
		$(this).prev().clone().insertBefore(this).find('input').val('');
	});
	
	/*** выводим напоминалку о сохранении ***/
	
	$('a').on('click', function(){
		var	ifchange	=	false,
			fields		=	[];
		$('.to-save').each(function(){
			if ( $(this).val() != '' ) {
				fields.push( $(this).attr('placeholder') );
				ifchange = true;
			}
		});
		if ( ifchange ) {
			if ( confirm('Данные поля были изменены: «' + fields.join('», «') + '»\r\nСохранить изменения?') ){
				return false; // здесь будет функция сохранения
			}
		}
	});
	
	/*** удаляем елемент по клику на крестик ***/
	
	$(document.body).on('click', '[remove]', function(){
		$(this).parents('li').remove();
		$(this).parents('tr').remove();
	});
	
	/*** вычеркиваем елемент по клику на крестик ***/
	
	$('[to-del]').on('click', function(){
		$(this).parents('tr').addClass('deleted');
	});
	
	/*** проверяем чекбокс, удаляем крестик ***/
	
	$('[invoice] .checkbox').on('click', function(){
		if ( $(this).prop('checked') ) {
			$(this).parents('td').next('td').children('span').hide();
		}
		else {
			$(this).parents('td').next('td').children('span').show();
		}
	});
	
	/*** собираем новый заказ ***/
	
	$('[add-item]').dblclick(function(){
		var g = $('ul#sortable1 li:nth-child(2)');
		$(g).clone().insertAfter(g);
		var s = $(this).clone();
		$('ul#sortable1 li:nth-child(3) div[wid2]').prepend(s);
		var j = $(this).parents('td').prev('td').clone();
		$('ul#sortable1 li:nth-child(3) div[wid1]').prepend(j);
	});
	
	/*** проверяем селекты в договоре ***/
	
	if ( $('#contract-type :selected option[value="1"]') ){   
		$('[pay-first], [pay-after]').hide();
	}
	$('#contract-type').change(function(){
		if ( $('#contract-type [value="2"]').prop('selected') ){
			$('[pay-first]').show();
			$('[pay-after]').hide();
		}
		else {
			if ( $('#contract-type [value="1"]').prop('selected') ){
				$('[pay-first], [pay-after]').hide();
			}
			else {
				$('[pay-first]').hide();
				$('[pay-after]').show();
			}
		}
	});
	
	if ( $('#own-jur :selected option[value="1"]') ){   
		$('[sansfera-opt]').hide();
	}
	$('#own-jur').change(function(){
		if ( $('#own-jur [value="2"]').prop('selected') ){
			$('[sansfera-opt]').show();
			$('[sansfera]').hide();
		}
		else {
			$('[sansfera-opt]').hide();
			$('[sansfera]').show();
		}
	});
	
		/*
		alert("Поздравляем! Вы починили код!");
		*/
});


/* < функция > */

/* </ функция > */





