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
			wp_enqueue_media();
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
				'id' => 'bbdi_create_pages',
				'description' => 'Generates an About Us page, Blog page, Contact page, Home page, and Services page.',
			));
			## categories
			BBD_Init_Ajax::action_button(array(
				'label' => 'Create categories',
				'id' => 'bbdi_create_categories',
				'description' => "Sets the default category to Postings and creates Testimonials, FAQ's, and Helpful Hints categories."
			));
			# Options
			BBD_Init_Ajax::action_button(array(
				'label' => 'Set options',
				'id' => 'bbdi_set_options',
				'description' => 'Sets options in the WordPress Settings, making changes to your General, Reading, Discussion, and Permalink settings.'
			));
			# Menu
			BBD_Init_Ajax::action_button(array(
				'label' => 'Create menu',
				'id' => 'bbdi_create_menu',
				'description' => 'Creates a menu called Main Menu and sets the Primary Menu to Main Menu.'
			));

			?>
			<h3>Upload Logo</h3>
			<form action='options.php' method='post'>
				<?php
				# Custom Login Logo
				settings_fields( 'bbd_init_options' );

				do_settings_sections( 'bbd_initialization' );
				submit_button();
				?>
			</form>

		</div>
	<?php
	}
	
	/**
	 * Register the settings amd add both the settings sections and field
	 *
	 * @since 1.2.0
	 */
	public static function admin_init() {
		register_setting( 'bbd_init_options', 'bbd_init_options', array( 'BBD_Init', 'validate_options' ) );

		add_settings_section( 'bbd_init_default', '', '__return_empty_string', 'bbd_initialization' );

		add_settings_field( 'logo_field', 'Upload your logo',
			array( 'BBD_Init', 'settings_field_html' ), 'bbd_initialization', 'bbd_init_default',
			array(
				'description'	=> 'Choose or upload your logo that will be displayed on the WordPress login screen.',
				'type'			=> 'text',
				'name'			=> 'logo_field'
			)
		);
	}

	/**
	 * Return saved setting
	 * 
	 * @param 	array 	$input 		The options posted by the user
	 * @since 	1.2.0
	 */
	public static function validate_options( $input ) {
		if ( ! empty( $input['logo_field'] ) ) {
			$input['logo_field'] = esc_url_raw( $input['logo_field'] );
		}

		return $input;
	}

	/**
	 * Create the settings fields
	 *
	 * @param 	$setting
	 * @since 1.2.0
	 */
	public static function settings_field_html( $setting ) {
		if ( 'text' == $setting['type'] ) {
			$bbd_init_options = get_option( 'bbd_init_options' );

			?>
			
			<input type='text' id='bbd_init_logo_slug' name='bbd_init_options[logo_field]' value='<?php if( isset( $bbd_init_options['logo_field'] ) ) echo $bbd_init_options['logo_field']; ?>' />
			<button id='bbd_init_logo_upload' class='button button-secondary'>Upload Your Logo</button>
			<p id='description'><?php echo $setting['description']; ?></p>

			<?php
		}
	}

	public static function bbdi_login_logo() {
		$set_logo = get_option( 'bbd_init_options' );

	    if( isset( $set_logo['logo_field'] ) ) {
	        ?>

			<style type="text/css">
		        #login h1 a, .login h1 a {
		            background-image: url(<?php echo $set_logo['logo_field']; ?>);
		            padding-bottom: 30px;
		        }
	    	</style>

			<?php
	    }
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