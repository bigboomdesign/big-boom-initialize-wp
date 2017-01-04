=== Big Boom Initialize WP ===
Contributors:  bigboomdesign, michaelhull
Requires at least: 3.5
Tested up to: 4.7
Stable tag: 1.1.1

Initialize content and options for your WordPress site. 

== Description ==

Within seconds, you can turn a fresh WordPress install into a site with a basic content structure and sensible initial settings. From here, any settings and content can be changed as usual.

This plugin is not suggested for sites with existing content and structure in place, as it is meant to initialize an empty installation.

* From [Big Boom Design](http://www.bigboomdesign.com)

= Features =

* Initialize default pages instantly, with _lorem ipsum_ text in place on each page
	* Home
	* About Us
	* Services
	* Blog
	* Contact
	
* Initialize Categories
	* Catch-all is changed to `Postings` if currently set to `Uncategorized`
	* New categories are created
		* Testimonials
		* FAQ's
		* Helpful Hints

* Initialize Menu and Menu Items
	* A menu called `Main Menu` is created. If it already exists, the menu initialization process is terminated.
	* Menu items are created for `Main Menu` based on the auto-generated pages and categories above.
	* Note that you'll need to set a Menu Location under `Appearance > Menus` since this depends on your theme.

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

== Installation ==
* Go To Plugins >> Add New
* Either search for \"Big Boom Initialize WP\" or Upload the .zip file downloaded here.
* Once installed, go to Tools >> Big Boom Initialize WP
* The steps for initializing content and options are presented in order.  Click the buttons one at a time, waiting for each to finish before starting the next.
* Using the power of AJAX, you can complete the steps in seconds without leaving the page.  Enjoy!