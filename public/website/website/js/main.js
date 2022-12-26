$(function(){
	'use strict';
	$(window).scroll(function(){
		var navbar=$('.navbar');
		if ($(window).scrollTop()>=navbar.height()) {

			navbar.addClass('scrolled');
		}else{

			navbar.removeClass('scrolled');
		}
	});
		$('.tab-switch li').click(function(){
			$(this).addClass('selected').siblings().removeClass('selected');
			$('.tabs .tab-content > div').hide();
			$('.' + $(this).data('class')).show();


		});
});
jQuery(document).ready(($) => {
    $('.quantity').on('click', '.plus', function(e) {
        let $input = $(this).prev('input.qty');
        let val = parseInt($input.val());
        $input.val( val+1 ).change();
    });

    $('.quantity').on('click', '.minus',
        function(e) {
            let $input = $(this).next('input.qty');
            var val = parseInt($input.val());
            if (val > 0) {
                $input.val( val-1 ).change();
            }
        });
});
