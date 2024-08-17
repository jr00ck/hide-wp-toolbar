<?php
/*
Plugin Name: Hide WP Toolbar
Plugin URI: https://github.com/jr00ck/hide-wp-toolbar/
Description: The plugin adds a clickable button to the right side of the WordPress Toolbar that will show or hide the bar with nice transitions.
Version: 2.7
Author: Web Guys
Author URI: https://radiatewp.com
Author Email: jeremy@radiatewp.com
Text Domain: hide-wp-toolbar
*/

/********************************************
	Load Text Domain for Translations
*********************************************/
add_action('plugins_loaded', 'hide_wp_toolbar_load_textdomain');

function hide_wp_toolbar_load_textdomain() {
	load_plugin_textdomain( 'hide-wp-toolbar' );

	// only show button for frontend and logged in users
	if (!is_admin() && is_user_logged_in()) {
		add_action('admin_bar_menu', 'hide_wp_toolbar_add_button',  1);
	}

}

/********************************************
	Add button to Toolbar
*********************************************/

function hide_wp_toolbar_add_button($toolbar){

	// Properties for the button
	$args = array(
	        'id'		=> 'hide',
	        'title'		=> '<a href="javascript://"></a>',
	        'parent'	=> 'top-secondary'
	        );

	// Add button to admin bar
	$toolbar->add_node( $args );

}

/*********************************************
	Add Stylesheet
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_wp_toolbar_add_stylesheet' );

function hide_wp_toolbar_add_stylesheet() {

	if(!is_admin() && is_user_logged_in()){
		// Register the style for plugin
		wp_enqueue_style( 'hide-wp-toolbar-style', plugins_url( 'style.css', __FILE__ ), array('dashicons'), '2.7'  );
	}
}


/*********************************************
	Add Javascript
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_wp_toolbar_add_script' );

function hide_wp_toolbar_add_script() {

	if(!is_admin() && is_user_logged_in()){

		$toolbar_css = hide_wp_toolbar_get();

		$hide_toolbar = $toolbar_css == 'hide-wp-toolbar' ? "true" : "false";

		wp_enqueue_script( 'hide-wp-toolbar-script', plugin_dir_url( __FILE__ ) . 'script.js', array( 'jquery' ) );
		wp_localize_script( 'hide-wp-toolbar-script', 'HWPTB', array(
			// URL to wp-admin/admin-ajax.php to process the request
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),

			// generate a nonce with a unique ID "myajax-post-comment-nonce"
			// so that you can check it later when an AJAX request is sent
			'HWPTBnonce' => wp_create_nonce( 'HWPTB-status-ajax-nonce' ),

			// toolbar initial state
			'hide_wp_toolbar' => $hide_toolbar,
			)
		);
	}
}

/*********************************************
	Get/Set Toolbar Status
**********************************************/

// set status
function hide_wp_toolbar_set($toolbar_css_class){

	// set toolbar status in transient
	$toolbar_status = 'shown';
	$transient_name	= 'hide_wp_toolbar_status';
	$transient_exp	= 60 * 60 * 24 * 7; // 7 days

	if($toolbar_css_class == 'hide-wp-toolbar'){
		$toolbar_status = 'hidden';
	}

	set_transient( $transient_name, $toolbar_status, $transient_exp );

}

function hide_wp_toolbar_get(){

	$toolbar_css_class = 'show-wp-toolbar';

	$toolbar_status = get_transient('hide_wp_toolbar_status');

	if($toolbar_status == 'hidden'){
		$toolbar_css_class = 'hide-wp-toolbar';
	}

	return $toolbar_css_class;
}


/*********************************************
	Ajax Handler
**********************************************/

add_action( 'wp_ajax_HWPTB_state', 'HWPTB_ajax_submit' );

function HWPTB_ajax_submit() {

	if(is_user_logged_in()){
		header( "Content-Type: application/json" );

		$nonce = $_POST['ajax_nonce'];

		// check to see if the submitted nonce matches with the generated nonce we created earlier
		if ( ! wp_verify_nonce( $nonce, 'HWPTB-status-ajax-nonce' ) ) {
			die ( __('Invalid nonce value!', 'hide-wp-toolbar') );
		}

		// get the submitted parameters
		$toolbar_class = $_POST['toolbar_class'];

		hide_wp_toolbar_set($toolbar_class);

		// generate the response (WITH NEW NONCE VALUE?)
		// $response = json_encode( array( 'toolbar_class' => $toolbar_class ) );

		// response output
		// header( "Content-Type: application/json" );
		// echo $response;

		// IMPORTANT: don't forget to "exit"
		exit;
	}
}


?>
