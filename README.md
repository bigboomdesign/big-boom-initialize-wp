# Big Boom Initialize WP

Initialize content and options for your WordPress site. 

Within seconds, you can turn a fresh WordPress install into a site with a basic content structure and sensible initial settings. From here, any settings and content can be changed as usual.

This plugin is not suggested for sites with existing content and structure in place, as it is meant to initialize an empty installation.

----
## Features

* Initialize default pages instantly, with _lorem ipsum_ text in place on each page
	* Home
	* About Us
	* Services
	* Blog
	* Contact
	
* Categories
	* Catch-all is changed to `Postings` if currently set to `Uncategorized`
	* New categories are created
		* Testimonials
		* FAQ's
		* Helpful Hints

* Menu and Menu Items
	* A menu called `Main Menu` is created. If it already exists, the menu initialization process is terminated.
	* Menu items are created for `Main Menu` based on the auto-generated pages and categories above.

* Initialize WP core settings
	* Permalink Structure: `%category%/%postname%`
	* Upload folders: `0`
	* Default Comment/Ping status: `closed`
	* Comment Moderation: `1`
	* Close comments for old posts: `1`
	* Close comments days old: `0`
	* Show on front: `page`
	* Page on front: (uses ID of `Home` page which can be auto-generated)
	* Page for posts: (uses ID of `Blog` page which can be auto-generated)
	
* Custom backend theme and login screen