function Ownsidebar(){
	var sidebar = $(".primarySidebar");
	var sidebar_top = sidebar.offset().top;
	var sidebar_height = sidebar.height();
	var footer = $('.mainFooter')
	var subsribe_height = $(".primarySidebar__subscribeWidget").height();
	$(window).scroll(function(event) {

        var scrollTop = $(window).scrollTop();
        var sticky_block = $(".primarySidebar__subscribeWidget");
        var footer_top = footer.offset().top;
        var footer_height = footer.height();
        var extra_offset = 300;
        var top = 50
        if(scrollTop > sidebar_height + sidebar_top + extra_offset){
        	if (scrollTop + subsribe_height + top > footer_top - footer_height) {
    	      var topPosition = footer_top - footer_height - scrollTop - subsribe_height - 10;
    	      sticky_block.css({
    	    		'position': 'fixed',
    	    		'top' : topPosition + 'px',
    	    		'margin-top': 0,
    	    	});
         	} else {
         		sticky_block.css({
        			'position': 'fixed',
        			'top' : top + 'px',
        			'margin-top': 0,
        		});
         	}
        	
        } else {
        	sticky_block.css({
        		'position': '',
        		'top' : '',
        		'margin-top': '',
        	});
        }

	});
}