<?php
class WP_Init{
	static $classes = array('wp-init-ajax');
	
	/*
	* Back end
	*/
	function admin_enqueue(){
		wp_enqueue_style('wp-init-css', wpinit_url('/css/wp-init-admin.css'));	
		
		$screen = get_current_screen();
		if($screen->base == 'tools_page_wp_initialization'){
			wp_enqueue_style('wp-init-tools-css', wpinit_url('/css/wp-init-tools.css'));
			wp_enqueue_script('wp-init-tools-js', wpinit_url('/js/wp-init-tools.js'));
		}	
	}
	# Admin menu item
	function admin_menu(){
		add_management_page( 'WP Initialize', 'WP Initialize', 'manage_options', 'wp_initialization', array('WP_Init','initialization_page'));
	}
	# Main Init page
	function initialization_page(){
	?>
		<div class='wrap'>
			<h2><span class='bbd-red'>Big Boom Design</span> WP Initialize</h2>
			<?php
				# Content
				## pages
				WP_Init_Ajax::action_button(array(
					'label' => 'Generate pages',
					'id' => 'wpinit_create_pages'
				));
				## categories
				WP_Init_Ajax::action_button(array(
					'label' => 'Create categories',
					'id' => 'wpinit_create_categories'
				));
				
				# Options
				WP_Init_Ajax::action_button(array(
					'label' => 'Set options',
					'id' => 'wpinit_set_options'
				));
				# Menu
				WP_Init_Ajax::action_button(array(
					'label' => 'Create menu',
					'id' => 'wpinit_create_menu'
				));
			?>
		</div>
	<?php
	}	
	
	/*
	* Helper Functions
	*/
	
	# require a file, checking first if it exists
	function req_file($path){ if(file_exists($path)) require_once $path; }
	# return a permalink-friendly version of a string
	function clean_str_for_url( $sIn ){
		if( $sIn == "" ) return "";
		$sOut = trim( strtolower( $sIn ) );
		$sOut = preg_replace( "/\s\s+/" , " " , $sOut );					
		$sOut = preg_replace( "/[^a-zA-Z0-9 -]/" , "",$sOut );	
		$sOut = preg_replace( "/--+/" , "-",$sOut );
		$sOut = preg_replace( "/ +- +/" , "-",$sOut );
		$sOut = preg_replace( "/\s\s+/" , " " , $sOut );	
		$sOut = preg_replace( "/\s/" , "-" , $sOut );
		$sOut = preg_replace( "/--+/" , "-" , $sOut );
		$nWord_length = strlen( $sOut );
		if( $sOut[ $nWord_length - 1 ] == "-" ) { $sOut = substr( $sOut , 0 , $nWord_length - 1 ); } 
		return $sOut;
	}	
}
# require files for plugin
foreach(WP_Init::$classes as $class){ WP_Init::req_file(wpinit_dir("/lib/class-{$class}.php")); }