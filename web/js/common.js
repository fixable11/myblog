$(document).ready(function() {
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

	newDate('.post__date');
	
	
});