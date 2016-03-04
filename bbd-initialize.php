<?php
/*
Plugin Name: Big Boom Initialize WP
Description: Initialize options and sample content for your WordPress site
Author: Big Boom Design
Author URI: http://www.bigboomdesign.com
Version: 1.1.1
*/

/* 
* Main Routine
*/
require_once bbdi_dir('/lib/class-bbd-init.php');

/* 
* Back end
*/
if(is_admin()){
	# Scripts
	add_action('admin_enqueue_scripts', array('BBD_Init','admin_enqueue'));

	# Menu Page under 'Tools'
	add_action('admin_menu', array('BBD_Init','admin_menu'));

	# ajax
	BBD_Init_Ajax::add_actions();	
} # end if: is_admin()

/*
* Front end
*/
else{
	# Login Screen
	function bbdi_custom_login() { 
		wp_enqueue_style('bbd-initialize-login-css', bbdi_url('/custom-login/custom-login.css'));
	}
	add_action('login_head', 'bbdi_custom_login');

	## URL link for logo
	function bbdi_url_login(){
		return "http://bigboomdesign.com/"; 
	}
	add_filter('login_headerurl', 'bbdi_url_login');

	// changing the alt text on the logo to show your site name 
	function bbdi_login_title() { return "bigboomdesign.com"; }
	add_filter('login_headertitle', 'bbdi_login_title');

	function bbdi_failed_login() {
		return 'The login information you have entered is incorrect.';
	}
	add_filter('login_errors', 'bbdi_failed_login');
} # end if: !is_admin()

/* 
* Helper Functions
*/
function bbdi_url($s){ return plugins_url($s, __FILE__); }
function bbdi_dir($s){ return plugin_dir_path(__FILE__) . $s; }