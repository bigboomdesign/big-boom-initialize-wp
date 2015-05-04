<?php
/*
Plugin Name: WP Initialize
Description: Initialize options and sample content for your WordPress site
Author: Big Boom Design
Author URI: http://www.bigboomdesign.com
Version: 0.1.0
*/

/* 
* Back end
*/
if(is_admin()){
	# Scripts
	add_action('admin_enqueue_scripts', 'wpini_admin_enqueue');
	function wpini_admin_enqueue(){
		wp_enqueue_style('wp-initialize-css', wpini_url('/css/wp-initialize.css'));	
		
		$screen = get_current_screen();
		if($screen->base == 'tools_page_wp_initialization'){
			# styles for WP Initialize page go here
		}
	}
	# Menu Page under 'Tools'
	add_action('admin_menu', 'wpini_admin_menu');
	function wpini_admin_menu(){
		add_management_page( 'WP Initialize', 'WP Initialize', 'manage_options', 'wp_initialization', 'wpini_initialization_page' );
	}
	function wpini_initialization_page(){
	?>
		<div class='wrap'>
			<h2><span class='bbd-red'>Big Boom Design</span> WP Initialize</h2>
		</div>
	<?php
	}
} # end if: is_admin()

/*
* Front end
*/
else{
	# Login Screen
	function wpini_custom_login() { 
		wp_enqueue_style('wp-initialize-login-css', wpini_url('/custom-login/custom-login.css'));
	}
	add_action('login_head', 'wpini_custom_login');

	## URL link for logo
	function wpini_url_login(){
		return "http://bigboomdesign.com/"; 
	}
	add_filter('login_headerurl', 'wpini_url_login');

	// changing the alt text on the logo to show your site name 
	function wpini_login_title() { return "bigboomdesign.com"; }
	add_filter('login_headertitle', 'wpini_login_title');

	function failed_login() {
		return 'The login information you have entered is incorrect.';
	}
	add_filter('login_errors', 'failed_login');
} # end if: !is_admin()

/* 
* Helper Functions
*/
function wpini_url($s){ return plugins_url($s, __FILE__); }
function wpini_folder($s){ return plugin_dir_path() . $s; }