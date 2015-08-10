<?php
class BBD_Init_Ajax{
	static $actions = array('bbdi_create_pages', 'bbdi_create_categories', 'bbdi_set_options', 'bbdi_create_menu');
	
	# register actions with wp_ajax_
	public static function add_actions(){
		foreach(self::$actions as $action){
			add_action('wp_ajax_'.$action, array('BBD_Init_Ajax', $action));			
		}
	}
	# display an action button section
	public static function action_button($args){
		$args = shortcode_atts(
			array(
				'id' => '',
				'label' => '',
				'button_text' => 'Go',
				'class' => '',
				'description' => '',
				'instructions' => '',
			), $args, 'bbdi_action_button'
		);
		extract($args);

		# make sure we have an ID
		if(!$id) return;
	?>
	<div class='action-button-container'>
		<?php if($label){ ?>
			<h3><?php echo $label; ?></h3>
		<?php } ?>
		<?php if($description){
			?><p id='description'><?php echo $description; ?></p><?php
		}
		?>
		<button 
			id="<?php echo $id; ?>"
			class="button button-primary<?php if($class) echo ' '. $class; ?>"
		><?php echo $button_text; ?></button>
		<?php if($instructions){
			?><p class='description'><?php echo $instructions; ?></p><?php
		}
		?>
		<p class='message'></p>
	</div>
	<?php
	} # end: action_button()
	/*
	* Ajax actions
	*/
	public static function bbdi_create_pages(){
		# Home
		$home = array(
			'post_type' => 'page',
			'post_title' => 'Home',
			'post_content' => 'Nam semper, magna eget varius consectetur, nunc libero molestie leo, ac eleifend quam purus in est. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean cursus tempus nisl, sit amet faucibus enim vestibulum sit amet. Fusce commodo purus varius sem interdum varius. In sit amet tortor eget sapien aliquam semper. Praesent id elit ipsum. Aliquam vestibulum, est id scelerisque posuere, diam enim volutpat lorem, sit amet scelerisque erat ligula vehicula odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer vestibulum euismod suscipit.',
			'post_status' => 'publish'
		);
		self::insert_post($home);
		
		# About
		$about = array(
			'post_type' => 'page',
			'post_title' => 'About Us',
			'post_content' => 'Sed iaculis mauris in felis condimentum vehicula. Integer aliquet tincidunt augue, at hendrerit tellus lacinia eget. Nunc suscipit, eros ac luctus ultrices, enim dui gravida nulla, sit amet aliquam odio enim sodales quam. Donec pellentesque fermentum dignissim. Sed quis libero felis. Phasellus iaculis orci eu erat porta egestas. Vestibulum luctus condimentum elit, in sodales mauris bibendum non.',
			'post_status' => 'publish'
		);
		self::insert_post($about);		
		
		# Services
		$services = array(
			'post_type' => 'page',
			'post_title' => 'Services',
			'post_content' => 'Vestibulum ac risus nec lorem porttitor feugiat. Cras venenatis semper elit, ut facilisis lacus bibendum at. Suspendisse justo massa, viverra pulvinar facilisis ut, tempus et diam. Morbi elementum, libero semper hendrerit elementum, velit felis tempor sapien, ut tincidunt nunc ipsum ut risus. In ornare, lectus ut pharetra pulvinar, orci orci aliquam nisl, sit amet sodales nunc lorem at augue. Sed at erat lectus. Vestibulum pulvinar elit id quam sollicitudin vehicula. Suspendisse et massa eget massa consequat iaculis a vitae felis. Cras scelerisque malesuada congue. Morbi et tempus augue. Sed dignissim dictum turpis, et imperdiet purus rutrum quis. Ut faucibus dapibus quam ut volutpat. Aenean lorem sapien, viverra sit amet viverra nec, malesuada eget eros.',
			'post_status' => 'publish'
		);
		self::insert_post($services);
		
		# Blog
		$blog = array(
			'post_type' => 'page',		
			'post_title' => 'Blog',
			'post_content' => 'Duis nulla ipsum, bibendum non elementum in, mollis id erat. Vivamus rhoncus, est pretium adipiscing tristique, purus nunc feugiat diam, non adipiscing leo odio vel ligula. Praesent viverra porttitor lectus in aliquam. Praesent urna lectus, malesuada sed tincidunt ac, porta eu neque. Maecenas semper metus at tellus aliquam tempor sed eu felis. Nulla facilisi. Duis ut nunc orci. Pellentesque in neque vel justo rutrum eleifend. Nulla commodo mi vitae ipsum interdum at sagittis augue scelerisque. Ut cursus posuere dolor, id ullamcorper dui pretium eu.',
			'post_status' => 'publish'
		);
		self::insert_post($blog);
		
		# Contact
		$contact = array(
			'post_type' => 'page',		
			'post_title' => 'Contact',
			'post_content' => 'Maecenas consectetur adipiscing eleifend. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec interdum, tellus sit amet laoreet mattis, enim augue rutrum enim, quis suscipit risus dui pretium massa. Nulla a tortor nec urna fringilla molestie sit amet ac mi. Maecenas viverra massa dignissim est vehicula sodales. Praesent viverra malesuada sem nec pulvinar. Integer in libero odio. Ut ac accumsan est.',
			'post_status' => 'publish'
		);
		self::insert_post($contact);
		die();
	} # end: bbdi_create_pages()
	
	public static function bbdi_create_categories(){
		# default category
		$default_cat = get_term_by('id', get_option('default_category'), 'category');
		## change name to `Postings` if set to `Uncategorized`
		if($default_cat->name == 'Uncategorized'){
			# edit the category name and slug
			$update_cat = wp_update_term( $default_cat->term_id, 'category',
				array(
					'name' => 'Postings',
					'slug' => 'postings'
				)
			);
			if(is_object($update_cat)) echo '<span class="fail">Problem updating default category.</span><br />';
			else echo 'Updated default category from <code>Uncategorized</code> to <code>Postings</code>.<br />';
		} # end if: default is Uncategorized
		# If default is not `Uncategorized` then display a message
		else{
			echo 'Default category is already set.<br />';
		}
		
		# create new categories
		$new_cats = array(
			array('cat_name' => 'Testimonials'),
			array('cat_name' => 'FAQ\'s', 'category_nicename' => 'faq'),
			array('cat_name' => 'Helpful Hints'),
		);
		foreach($new_cats as $cat){
			self::insert_category($cat);
		} # end foreach: new categories
		die();
	} # end: bbdi_create_categories()
	public static function bbdi_set_options(){
		# permalink structure
		if(self::update_option(array(
			'option' => 'permalink_structure',
			'value' => '/%category%/%postname%',
			'label' => 'Permalink structure'
		))){
			# we need to update/flush the rewrite rules if option was changed
			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure( '/%category%/%postname%' );
			$wp_rewrite->flush_rules();		
		}
		
		# year/month folders for media uploads
		self::update_option(array(
			'option' => 'uploads_use_yearmonth_folders',
			'value' => '0',
			'label' => 'Media folder option'
		));
		
		# default comment status
		self::update_option(array(
			'option' => 'default_comment_status',
			'value' => 'closed',
			'label' => 'Default comment status'
		));
		
		# default ping status
		self::update_option(array(
			'option' => 'default_ping_status',
			'value' => 'closed',
			'label' => 'Default ping status'
		));
		# comment moderation
		self::update_option(array(
			'option' => 'comment_moderation',
			'value' => '1',
			'label' => 'Comment Moderation'
		));
		# close_comments_for_old_posts
		self::update_option(array(
			'option' => 'close_comments_for_old_posts',
			'value' => '1',
			'label' => 'Close comments for old posts'
		));
		# close_comments_days_old
		self::update_option(array(
			'option' => 'close_comments_days_old',
			'value' => '0',
			'label' => 'Days to close comments'
		));
		# set home page
		if($home_page = get_page_by_title('Home', '', 'page')){
			# show_on_front
			self::update_option(array(
				'option' => 'show_on_front',
				'value' => 'page',
				'label' => 'Show on front'
			));
			# page_on_front
			self::update_option(array(
				'option' => 'page_on_front',
				'value' => strval($home_page->ID),
				'label' => 'Page on front'
			));
			# page_for_posts
			if($blog_page = get_page_by_title('Blog')){
				self::update_option(array(
					'option' => 'page_for_posts',
					'value' => strval($blog_page->ID),
					'label' => 'Page for posts'
				));
			}
			else echo '<span class="fail">We couldn\'t find the Blog page.</span><br />';
		}
		else echo '<span class="fail">We couldn\'t locate the Home page.</span><br />';
		die();
	} # end: bbdi_set_options()

	# Create menu and menu items
	public static function bbdi_create_menu(){
		# make sure menu 'Main Menu' doesn't already exist
		if(wp_get_nav_menu_object('Main Menu')){
			echo 'There\'s already a menu called <code>Main Menu</code>';
			die();
		}
		# create the menu
	    $menu_id = wp_create_nav_menu('Main Menu');
	    
	    ## pages
	    $pages = array('Home', 'About Us', 'Services', 'Blog', 'Contact');
	    foreach($pages as $page){
	    	# make sure we have the page to add as a menu item
	    	if(!($page_obj = get_page_by_title($page))){
	    		echo '<span class="fail"><code>'. $page .'</code> page not found.</span><br />';
	    		continue;
	    	}
	    	# add the page as a menu item
	    	
	    	$new_menu_item_id = self::create_menu_item( array(
	    		# for the WP function wp_update_nav_menu_item()
	    		'menu-item-title' => $page_obj->post_title,
	    		'menu-item-object-id' => $page_obj->ID,
	    		'menu-item-object' => 'page',
	    		'menu-item-type' => 'post_type',
	    		'menu-item-status' => 'publish',
	    		
	    		# for our custom function
	    		'menu_id' => $menu_id,
	    	));

	    	# we're done now except for blog item
	    	# for the blog item, we need to add submenu items
	    	if($page != 'Blog') continue;
	    	
	    	$cats = array('faq', 'helpful-hints', 'testimonials');
	    	foreach($cats as $cat){
	    		# make sure the category exists
	    		if(!($cat_obj = get_category_by_slug($cat))){
	    			echo '<span class="fail">Category <code>'. $cat .'</code> doesn\'t exist.</span><br />';
	    			continue;
	    		}
	    		self::create_menu_item(array(
					# for the WP function wp_update_nav_menu_item()
					'menu-item-title' => $cat_obj->name,
					'menu-item-object-id' => $cat_obj->term_id,
					'menu-item-parent-id' => $new_menu_item_id,
					'menu-item-object' => 'category',
					'menu-item-type' => 'taxonomy',
					'menu-item-status' => 'publish',
				
					# for our custom function
					'menu_id' => $menu_id,
	    		));
	    	}
	    }
		die();
	}
	
	/*
	* Helper Functions
	*/
	
	# Insert a page/post, checking if it exists first and echoing a message
	#
	# minimum input:
	# array(
	#	'post_title' => '',
	# )
	
	public static function insert_post($args){
		if(!array_key_exists('post_title', $args)) return;
		# add slug if none is given
		if(!array_key_exists('name', $args)) $args['name'] = BBD_Init::clean_str_for_url($args['post_title']);
		if(!get_page_by_path($args['name'])){
			$new_id = wp_insert_post($args);
			# if we got an object back, that's an error
			if(is_object($new_id)) echo 'Error with page <code>' . $args['post_title'].'</code>';
			else echo '<span class="success">Inserted <code>' . $args['post_title'] . '</code> page.</span><br />';
		}
		else echo 'Page <code>' . $args['post_title'] . '</code> already exists.<br />';		
	}
	
	# Insert a category, checking if it exists first and echoing a message
	#
	# minimum input:
	# array(
	#	'cat_name' => '',
	#	'category_nicename' => ''
	# )
	
	public static function insert_category($cat){
		# make sure we have the necessary arguments in our array
		if(!isset($cat['cat_name'])) return;
		if(!isset($cat['category_nicename'])) $cat['category_nicename'] = BBD_Init::clean_str_for_url($cat['cat_name']);
		
		# check if category already exists
		if(get_term_by('slug', $cat['category_nicename'], 'category')){
			echo 'Category <code>'. $cat['cat_name'] .'</code> already exists.<br />';
			return;
		}
		# insert the term
		if(!is_object(wp_insert_category($cat))){
			echo '<span class="success">Category <code>'. $cat['cat_name'] .'</code> created.</span><br />';
			return;
		}
		echo '<span class="fail">Problem creating category <code>'. $cat['cat_name'] . '</code>.</span><br />';	
	}
	
	# Update an option, checking the current value first and echoing a message
	#
	# input:
	# array(
	#	'option' => '',
	# 	'label' => '',
	#	'value' => '',
	# )
	#
	# return 1 if option was changed
	
	public static function update_option($args){
		# make sure we have the right keys
		if(!isset($args['option']) || !isset($args['label']) || !isset($args['value'])) return;
		
		# the value that's currently set
		$old_value = get_option($args['option']);
		
		if($args['value'] !== $old_value){
			if(update_option($args['option'], $args['value'])){
				echo '<span class="success">'.$args['label'] . ' has been set set to <code>'. $args['value'] .'</code>.</span><br />';
				return 1;
			}
			else echo '<span class="fail">Problem updating '. $args['label'] .'.</span><br />';
		}
		else echo $args['label'] . ' is already set to <code>'. $args['value'] .'</code>.<br />';
		return 0;
	} # end: update_option()
	
	# Add a menu item
	#
	# minimum input:
	# array(
	#	'menu_id' => 0,
	#	'menu-item-title' => '',
	# )
	
	public static function create_menu_item($args){
		# make sure we have a menu_id
		if(!$args['menu_id']) return;
		# insert the menu item and make sure we don't have an error
		$menu_item_id = wp_update_nav_menu_item($args['menu_id'], 0, $args);
		if(is_wp_error($menu_item_id)){
			echo '<span class="fail">There was a problem with the <code>'. $args['menu-item-title'] .'</code> menu item.</span><br />';
			return;
		}
		echo '<span class="success">Menu item <code>'. $args['menu-item-title'] .'</code> successfully added.</span><br />';
		return $menu_item_id;
	} # end: create_menu_item()
	
} # end class: BBD_Init_Ajax