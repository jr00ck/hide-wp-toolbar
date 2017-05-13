jQuery(function($){

	// set initial state of toolbar 
	hide_wp_toolbar_hide(HWPTB.hide_wp_toolbar);

	// handle click event on the button
	$('#wp-admin-bar-hide').on('click', function(){

		// set default values
		var hide_toolbar = "false";
		var toolbar_class = 'show-wp-toolbar';

		// add CSS class for our transition
		$('#wpadminbar, html').addClass('transition');

		// if the CSS class 'hide-wp-toollbar' is not present, then we need to hide the toolbar
		if(!$('#wpadminbar').hasClass('hide-wp-toolbar')){
			hide_toolbar = "true";
			toolbar_class = 'hide-wp-toolbar';
		}

		// call our hide/show function w/ the values for the toolbar state we want
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

	// hide/show function that handles hiding/showing the toolbar by applying the proper CSS class
	function hide_wp_toolbar_hide(hide){
		
		if(hide === "true"){
			$('#wpadminbar, html').addClass('hide-wp-toolbar').removeClass('show-wp-toolbar');
		} else {
			$('#wpadminbar, html').addClass('show-wp-toolbar').removeClass('hide-wp-toolbar');
		}
	}

});