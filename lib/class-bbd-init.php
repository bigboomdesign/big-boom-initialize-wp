<?php
class BBD_Init{
	static $classes = array('bbd-init-ajax');
	
	/*
	* Back end
	*/
	public static function admin_enqueue(){
		wp_enqueue_style('bbd-init-css', bbdi_url('/css/bbd-init-admin.css'));	
		
		$screen = get_current_screen();
		if($screen->base == 'tools_page_bbd_initialization'){
			wp_enqueue_style('bbd-init-tools-css', bbdi_url('/css/bbd-init-tools.css'));
			wp_enqueue_script('bbd-init-tools-js', bbdi_url('/js/bbd-init-tools.js'));
		}	
	}
	# Admin menu item
	public static function admin_menu(){
		add_management_page( 'Big Boom Initialize WP', 'Big Boom Initialize WP', 'manage_options', 'bbd_initialization', array('BBD_Init','initialization_page'));
	}
	# Main Init page
	public static function initialization_page(){
	?>
		<div class='wrap'>
			<h2><span class='bbd-red'>Big Boom Design</span> Initialize WP</h2>
			<?php
				# Content
				## pages
				BBD_Init_Ajax::action_button(array(
					'label' => 'Generate pages',
					'id' => 'bbdi_create_pages'
				));
				## categories
				BBD_Init_Ajax::action_button(array(
					'label' => 'Create categories',
					'id' => 'bbdi_create_categories'
				));
				
				# Options
				BBD_Init_Ajax::action_button(array(
					'label' => 'Set options',
					'id' => 'bbdi_set_options'
				));
				# Menu
				BBD_Init_Ajax::action_button(array(
					'label' => 'Create menu',
					'id' => 'bbdi_create_menu'
				));
			?>
		</div>
	<?php
	}	
	
	/*
	* Helper Functions
	*/
	
	# require a file, checking first if it exists
	public static function req_file($path){ if(file_exists($path)) require_once $path; }
	# return a permalink-friendly version of a string
	public static function clean_str_for_url( $sIn ){
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
foreach(BBD_Init::$classes as $class){ BBD_Init::req_file(bbdi_dir("/lib/class-{$class}.php")); }