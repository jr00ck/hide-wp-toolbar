jQuery(function($){

	// set initial state of toolbar 
	hide_wp_toolbar_hide(HWPTB.hide_wp_toolbar);

	$('#wp-admin-bar-hide').click(function(){
		var hide_toolbar = "false";
		var toolbar_class = 'show-wp-toolbar';

		$('#wpadminbar, html').addClass('transition');

		if(!$('#wpadminbar').hasClass('hide-wp-toolbar')){
			hide_toolbar = "true";
			toolbar_class = 'hide-wp-toolbar';
		}

		hide_wp_toolbar_hide(hide_toolbar);
		
		// fire ajax to update toolbar status, sending css class
		$.post(
			HWPTB.ajaxurl,
			{
				// trigger HWPTB_state on backend
				action : 'HWPTB_state',
		 
				// other parameters can be added along with "action"
				toolbar_class : toolbar_class,

				// nonce value
				ajax_nonce : HWPTB.HWPTBnonce
			}
		);
	});

	function hide_wp_toolbar_hide(hide){

		if(hide === "true"){
			$('#wpadminbar, html').addClass('hide-wp-toolbar').removeClass('show-wp-toolbar');
		} else {
			$('#wpadminbar, html').addClass('show-wp-toolbar').removeClass('hide-wp-toolbar');
		}
	}

});