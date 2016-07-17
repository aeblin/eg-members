<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		//Making Memberpress play nice with Timber is pretty difficult.
		// if (MeprUtils::is_user_logged_in()) {
		// 	$context['mpLoggedIn'] = true;
		// 	$context['mpCurrentUser'] = MeprUtils::get_currentuserinfo();
		// }
		// //Does this work?
		// $context['mpUtils'] = new MeprUtils();
		if(is_user_logged_in()) {
			$context['userLoggedIn'] = true;
			$context['currentUser'] = wp_get_current_user();
			//Add Memberful Items for easy access
			$context['mfAccountUrl'] = memberful_account_url();
			$context['mfAvatar'] = get_avatar(wp_get_current_user()->user_email, 48);
			$context['mfUserName'] = wp_get_current_user()->display_name;
		}
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();

//Keep non-admins from viewing admin panel
add_action( 'init', 'blockusers_init' );
function blockusers_init(){
	if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX) ) {
		wp_redirect(home_url());
		exit;
	}
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

//Remove Memberful Styling?
// function eg_members_remove_stylesheet( $current ) {
//   return false;
// }

add_filter( 'memberful_wp_profile_widget_add_stylesheet', 'eg_members_remove_stylesheet' );
