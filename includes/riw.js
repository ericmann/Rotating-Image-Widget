jQuery(document).ready(function($) {
	$(function() {
    	setInterval( "slideSwitch()", 5000 );
	});
});

function slideSwitch() {
jQuery(document).ready(function($) {

    var $active = $('#riw_images DIV.active');

    if ( $active.length == 0 ) $active = $('#riw_images DIV:last');

    var $next =  $active.next().length ? $active.next()
        : $('#riw_images DIV:first');

    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
	$active.css({opacity: 1.0})
		.animate({opacity: 0.0}, 1000);
});		
}
