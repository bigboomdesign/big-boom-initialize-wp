<?php
/*
Plugin Name: WP Initialize
Description: Initialize options and sample content for your WordPress site
Author: Big Boom Design
Author URI: http://www.bigboomdesign.com
Version: 0.3.0
*/

/* 
* Main Routine
*/
require_once wpinit_dir('/lib/class-wp-init.php');

/* 
* Back end
*/
if(is_admin()){
	# Scripts
	add_action('admin_enqueue_scripts', array('WP_Init','admin_enqueue'));

	# Menu Page under 'Tools'
	add_action('admin_menu', array('WP_Init','admin_menu'));

	# ajax
	WP_Init_Ajax::add_actions();	
} # end if: is_admin()

/*
* Front end
*/
else{
	# Login Screen
	function wpinit_custom_login() { 
		wp_enqueue_style('wp-initialize-login-css', wpinit_url('/custom-login/custom-login.css'));
	}
	add_action('login_head', 'wpinit_custom_login');

	## URL link for logo
	function wpinit_url_login(){
		return "http://bigboomdesign.com/"; 
	}
	add_filter('login_headerurl', 'wpinit_url_login');

	// changing the alt text on the logo to show your site name 
	function wpinit_login_title() { return "bigboomdesign.com"; }
	add_filter('login_headertitle', 'wpinit_login_title');

	function wpinit_failed_login() {
		return 'The login information you have entered is incorrect.';
	}
	add_filter('login_errors', 'wpinit_failed_login');
} # end if: !is_admin()

/* 
* Helper Functions
*/
function wpinit_url($s){ return plugins_url($s, __FILE__); }
function wpinit_dir($s){ return plugin_dir_path(__FILE__) . $s; }