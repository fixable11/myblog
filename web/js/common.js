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
});