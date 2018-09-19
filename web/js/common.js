$(document).ready(function() {
	
	if (window.location.hash == '#_=_'){
    history.replaceState 
        ? history.replaceState(null, null, window.location.href.split('#')[0])
        : window.location.hash = '';
	}	

	$('a[href^="#"]').on('click', function(e){     
		e.preventDefault();
		var href = $(this).attr('href');
		if(href.length > 1){
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 800, 
				function(){
				//window.location.hash = href;
			});
		};
	});

	//Translates UTC timestamp to local date
	function newDate($selector){
		var $UTCtimestamp = $($selector).data('timestamp');
		var $localData = new Date($UTCtimestamp * 1000);

		var $date = "0" + $localData.getDate();
		var $mount = "0" + ($localData.getMonth() + 1);
		var $year = $localData.getFullYear();
		
		var $hours = $localData.getHours();
		var $minutes = "0" + $localData.getMinutes();
		var $seconds = "0" + $localData.getSeconds();

		var $formattedDate = $date.substr(-2) + '.' + $mount.substr(-2) + '.' + $year;
		var $formattedTime = $hours + ':' + $minutes.substr(-2) + ':' + $seconds.substr(-2);
		$($selector).html($formattedDate + ' ' + $formattedTime);
	}

	//newDate('.post__date, .social__date');

	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
	    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	var $cookieName = 'timezoneoffset';
	if(!getCookie($cookieName)){
		var date = new Date;
		date.setDate(date.getDate() + 30);
		document.cookie = "timezoneoffset=3; path=/; expires=" + date.toUTCString();
	}
	
	//setTimezoneCookie();
	$('.comment__delete').on('click', function(event) {
		event.stopPropagation();
		event.preventDefault();
		var $bool = confirm('Вы уверены, что хотите удалить этот комментарий?');
		var $url = $(this).parent().attr('action');
		var $ths = $(this);
		if($bool){
			$.ajax({
	      url: $url,
	      type: 'POST',
	      dataType: 'json',
	      //data: $data,
	      success: function($res){
	        if($res['success']){
	        	$ths.closest('.col-lg-12').remove();
	        	$('.comments__counter').text($res['amount']);
	        	$('.comments__declension').text($res['declension']);
	        }
	      },
	      error: function(){
	 				$ths.find('.comment__danger').show(300, function(){
						setTimeout(function() { $('.comment__danger').hide(300); }, 2500);
					});
				}	
      });
  	}
	});

	$('.comment__edit').on('click', function(e) {
		//e.preventDefault();
		var $ths = $(this);
		var $textarea = $ths.siblings('.comment__editForm').find('.comment__editTextarea');
		var $form = $('.comment__editFormWrap');
		$form.show();
		$textarea.show();
		var $text = $ths.siblings('.comment__text').text();
		var $helpBlock = $ths.siblings('.comment__editForm').find('.help-block');
		$helpBlock.show();
		$textarea.val($text);
		$textarea.focus();
		var $p = $ths.siblings('.comment__text');
		$p.hide();
		$ths.hide();
		var $cancel = $ths.siblings('.comment__cancel');
		var $save = $ths.siblings('.comment__editForm').find('.comment__save');
		$cancel.show();
		$save.show();

		$cancel.on('click', function(e) {
			$save.hide();
			$cancel.hide();
			$textarea.text('').hide();
			$p.show();
			$ths.show();
			$helpBlock.hide();
		});

	});


	$(document).on('click', function (e) {
    if ($(".comments__one").has(e.target).length === 0){
        $('.comment__save').hide();
				$('.comment__cancel').hide();
				$('.comment__editTextarea').text('').hide();
				$('.comment__text').show();
				$('.comment__edit').show();
				$('.help-block').hide();
    }
  });

  $('.comment__editForm').on('beforeSubmit', function(event){
    event.stopPropagation();
    var $textarea = $(this).find('.comment__editTextarea');
    var $data = $textarea.serialize();
    var $url = $(this).attr('action');
    var $ths = this;
    $.ajax({
      url: $url,
      type: 'POST',
      dataType: 'json',
      data: $data,
      success: function($res){
      	if($res){
      		$ths = $($ths).parent();
        	$ths.find('.comment__save').hide();
					$ths.find('.comment__cancel').hide();
					$ths.find('.comment__editTextarea').text('').hide();
					$ths.find('.comment__text').text($res).show();
					$ths.find('.comment__edit').show();
					$ths.find('.help-block').hide();
					$ths.find('.comment__success').show(300, function(){
						setTimeout(function() { $('.comment__success').hide(300); }, 2500);
					});
      	} else {
      		$ths = $($ths).parent();
        	$ths.find('.comment__save').hide();
					$ths.find('.comment__cancel').hide();
					$ths.find('.comment__editTextarea').text('').hide();
					$ths.find('.comment__text').show();
					$ths.find('.comment__edit').show();
					$ths.find('.help-block').hide();
					$ths.find('.comment__danger').show(300, function(){
						setTimeout(function() { $('.comment__danger').hide(300); }, 2500);
					});	
      	}
        
      },
      error: function(){
        $ths = $($ths).parent();
      	$ths.find('.comment__save').hide();
				$ths.find('.comment__cancel').hide();
				$ths.find('.comment__editTextarea').text('').hide();
				$ths.find('.comment__text').show();
				$ths.find('.comment__edit').show();
				$ths.find('.help-block').hide();
				$ths.find('.comment__danger').show(300, function(){
					setTimeout(function() { $('.comment__danger').hide(300); }, 2500);
				});	
      }
  	});
  	return false;
	});

	$('.singleSocial__likeUpButton, .singleSocial__likeDownButton').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		var $url = $(this).data('href');
		var $ths = $(this); 
		$.ajax({
      url: $url,
      type: 'POST',
      dataType: 'json',
      //data: $data,
      success: function($res){
      	if($res['success']){
      		$('.singleSocial__likeUpButton, .singleSocial__likeDownButton').children().removeClass('active');
      		$ths.children().addClass('active');
      		$('.singleSocial__likeUpCount').text($res['likes_amount']);
      		$('.singleSocial__likeDownCount').text($res['dislikes_amount']);
      	}
      },
      error: function(){

			}
  	});
		
	});

	//=====WIDGET======//
	
	function sidebarHandler(x){
		// var sidebar = new Ownsidebar();
		// if(!x.mathes){
		// 	delete sidebar;
		// }
	}
	var x = window.matchMedia("(max-width: 992px)").addListener(sidebarHandler);


	//========MENU_TOGGLE======
	$('.mainHeaderNav__barsWrap').on('click',function(){
	  $('.mainHeaderNav__ulWrap').slideToggle(200, function(){
		    if($(this).css('display') === 'none') {
		      $(this).removeAttr('style');
		    }
	    });
	});

});


	