<?php
/*
Plugin Name: Hide WP Toolbar
Plugin URI: http://blog.webguysaz.com/hide-wp-toolbar-wordpress-plugin/
Description: The plugin adds a clickable button to the right side of the WordPress Toolbar that will show or hide the bar with nice transitions.
Version: 2.1
Author: Web Guys
Author URI: http://webguysaz.com
Author Email: jeremy@webguysaz.com
*/

/********************************************
	Add button to Toolbar
*********************************************/

// only show button for frontend
if (!is_admin()) {
	add_action('admin_bar_menu', 'hide_wp_toolbar_add_button',  1);
}

function hide_wp_toolbar_add_button($toolbar){

	// Properties for the button
    $args = array(
            'id'    => 'hide',
            'title' => '<div><<</div>',
            'parent' => 'top-secondary'
            );
 
    // Add button to admin bar
    $toolbar->add_node( $args );

}

/*********************************************
	Add Stylesheet
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_wp_toolbar_add_stylesheet' );

function hide_wp_toolbar_add_stylesheet() {
	
	// Register the style for plugin:
	wp_register_style( 'hide-wp-toolbar-style', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'hide-wp-toolbar-style' );
}


/*********************************************
	Add Javascript
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_wp_toolbar_add_script' );

function hide_wp_toolbar_add_script() {

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

/*********************************************
	Get/Set Toolbar Status
**********************************************/

// set status
function hide_wp_toolbar_set($toolbar_css_class){

	$toolbar_status = 'shown';

	if($toolbar_css_class == 'hide-wp-toolbar'){
		$toolbar_status = 'hidden';
	}

	HWPTB()->session->set('hide_wp_toolbar_status', $toolbar_status);
}

function hide_wp_toolbar_get(){

	$toolbar_css_class = 'show-wp-toolbar';

	$toolbar_status = HWPTB()->session->get('hide_wp_toolbar_status');

	if($toolbar_status == 'hidden'){
		$toolbar_css_class = 'hide-wp-toolbar';
	}

	return $toolbar_css_class;
}

/*********************************************
	Load Session Manager
**********************************************/
// TODO: CLEAN UP THIS CODE. SEE CODE AT BOTTOM COMMENT (http://wordpress.org/support/topic/on-busy-sites-the-plugin-becomes-very-inefficient)
final class HideWPToolbar {

	private static $instance;
	public $session;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof HideWPToolbar ) ) {
			if ( ! defined( 'HideWPToolbar_PLUGIN_DIR' ) )
				define( 'HideWPToolbar_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
			require_once HideWPToolbar_PLUGIN_DIR . 'class-hidewptoolbar-session.php';
			self::$instance->session = new HideWPToolbar_Session(); 
		}

		return self::$instance;
	}
}

function HWPTB() {
	return HideWPToolbar::instance();
}

// Get HWPTB Running
HWPTB();


/*********************************************
	Ajax Handler
**********************************************/

add_action( 'wp_ajax_HWPTB_state', 'HWPTB_ajax_submit' );
 
function HWPTB_ajax_submit() {

	$nonce = $_POST['ajax_nonce'];
 
	// check to see if the submitted nonce matches with the generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'HWPTB-status-ajax-nonce' ) ) {
		die ( 'Invalid nonce value!');
	}

	// ignore the request if the current user isn't logged in
	if ( is_user_logged_in() ) {

		// get the submitted parameters
		$toolbar_class = $_POST['toolbar_class'];

		hide_wp_toolbar_set($toolbar_class);

		// generate the response (WITH NEW NONCE VALUE?)
		// $response = json_encode( array( 'toolbar_class' => $toolbar_class ) );

		// response output
		// header( "Content-Type: application/json" );
		// echo $response;

	}
	// IMPORTANT: don't forget to "exit"
	exit;
}


?>