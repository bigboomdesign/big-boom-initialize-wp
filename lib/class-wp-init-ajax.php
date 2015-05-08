<?php
class WP_Init_Ajax{
	static $actions = array('wpinit_create_pages', 'wpinit_create_categories');
	
	# register actions with wp_ajax_
	function add_actions(){
		foreach(self::$actions as $action){
			add_action('wp_ajax_'.$action, array('WP_Init_Ajax', $action));			
		}
	}
	# display an action button section
	function action_button($args){
		$args = shortcode_atts(
			array(
				'id' => '',
				'label' => 'Action Button',
				'button_text' => 'Go',
				'class' => '',
				'description' => '',
				'instructions' => '',
			), $args, 'wpinit_action_button'
		);
		extract($args);

		# make sure we have an ID
		if(!$id) return;
	?>
	<div class='action-button-container'>
		<h3><?php echo $label; ?></h3>
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
	function wpinit_create_pages(){
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
		echo '<br /><b>DONE</b>';
		die();
	} # end: wpinit_create_pages()
	
	function wpinit_create_categories(){
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
			if(is_object($update_cat)) echo 'Problem updating default category.<br />';
			else echo 'Updated default category from `Uncategorized` to `Postings`<br />';
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
	} # end: wpinit_create_categories()
	
	/*
	* Helper Functions
	*/
	
	# Insert a page/post, checking if it exists first and echoing a message
	#
	# minimum input:
	# array(
	#	'post_title' => '',
	# )
	function insert_post($args){
		if(!array_key_exists('post_title', $args)) return;
		# add slug if none is given
		if(!array_key_exists('name', $args)) $args['name'] = WP_Init::clean_str_for_url($args['post_title']);
		if(!get_page_by_path($args['name'])){
			$new_id = wp_insert_post($args);
			# if we got an object back, that's an error
			if(is_object($new_id)) echo 'Error with page ' . $args['post_title'];
			else echo 'Inserted ' . $args['post_title'] . ' page: ID ' . $new_id . '<br />';
		}
		else echo 'Page "' . $args['post_title'] . '" already exists.<br />';		
	}
	
	# Insert a category, checking if it exists first and echoing a message
	#
	# minimum input:
	# array(
	#	'cat_name' => '',
	#	'category_nicename' => ''
	# )
	function insert_category($cat){
		# make sure we have the necessary arguments in our array
		if(!isset($cat['cat_name'])) return;
		if(!isset($cat['category_nicename'])) $cat['category_nicename'] = WP_Init::clean_str_for_url($cat['cat_name']);
		
		# check if category already exists
		if(get_term_by('slug', $cat['category_nicename'], 'category')){
			echo 'Category "'. $cat['cat_name'] .'" already exists<br />';
			return;
		}
		# insert the term
		if(!is_object(wp_insert_category($cat))){
			echo 'Category "'. $cat['cat_name'] .'" created<br />';
			return;
		}
		echo 'Problem creating category "'. $cat['cat_name'] . '"<br />';	
	}	
	
} # end class: WP_Init_Ajax