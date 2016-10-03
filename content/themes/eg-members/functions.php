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
		$context['menu'] = new TimberMenu('primary');
    $context['footermenu'] = new TimberMenu('footer');
		$context['site'] = $this;
		if(is_user_logged_in()) {
			$context['userLoggedIn'] = true;
			$context['currentUser'] = wp_get_current_user();
			$context['currentUserId'] = get_current_user_id();
			$currentUserId = get_current_user_id();
			//Add Memberful Items for easy access
			$context['mfAccountUrl'] = memberful_account_url();
			$context['mfAvatar'] = get_avatar(wp_get_current_user()->user_email, 48);
			$context['mfUserName'] = wp_get_current_user()->display_name;
			$context['mfFirstName'] = wp_get_current_user()->first_name;
			$context['mfUserSubs'] = memberful_wp_user_plans_subscribed_to($currentUserId);
			$mfUserSubs = memberful_wp_user_plans_subscribed_to($currentUserId);
			$context['allMfSubs'] = get_option('memberful_subscriptions');
			$allMfSubs = get_option('memberful_subscriptions');
			$context['mfUserSubArray'] = get_current_user_mf_subs($mfUserSubs);
			$mfUserSubArray = get_current_user_mf_subs($mfUserSubs);
			$context['mfMatches'] = user_active_subscriptions($allMfSubs, $mfUserSubArray);
      $context['mfMatchNames'] = user_active_subscription_names($allMfSubs, $mfUserSubArray);
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

//Custom Post Types
function custom_post_type_blog() {
  $labels = array(
    'name'               => _x( 'Posts', 'post type general name' ),
    'singular_name'      => _x( 'Post', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'post' ),
    'add_new_item'       => __( 'Add New Post' ),
    'edit_item'          => __( 'Edit Post' ),
    'new_item'           => __( 'New Post' ),
    'all_items'          => __( 'All Posts' ),
    'view_item'          => __( 'View Post' ),
    'search_items'       => __( 'Search Posts' ),
    'not_found'          => __( 'No posts found' ),
    'not_found_in_trash' => __( 'No posts found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Posts'
  );
  $args = array(
    'labels'        => $labels,
    'taxonomies'    => array('category', 'post_tag'),
    'menu_icon'     => 'dashicons-admin-post',
    'description'   => 'Holds all blog posts and post data.',
    'public'        => true,
    'menu_position' => 4,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'post-formats' ),
    'has_archive'   => true,
  );
  register_post_type( 'blog', $args );
}

function custom_post_type_news() {
  $labels = array(
      'name' => _x('News', 'post type general name'),
      'singular_name' => _x('News Item', 'post type singular name'),
      'add_new' => _x('Add New', 'news'),
      'add_new_item' => __('Add New News Item'),
      'edit_item' => __('Edit News Item'),
      'new_item' => __('New News Item'),
      'view_item' => __('View News Item'),
      'search_items' => __('Search News'),
      'not_found' =>  __('Nothing found'),
      'not_found_in_trash' => __('Nothing found in Trash'),
      'parent_item_colon' => ''
  );

  $args = array(
      'labels' => $labels,
      'menu_icon'     => 'dashicons-microphone',
      'description'   => 'List all Life GPS Licensee News here.',
      'public'        => true,
      'menu_position' => 11,
      'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'post-formats' ),
      'has-archive'   => true,
    );

  register_post_type( 'news' , $args );
}

add_action( 'init', 'custom_post_type_blog' );
add_action( 'init', 'custom_post_type_news' );


//Admin Dash and Access Modifications //----

// Remove dashboard items if user is not administrator
function remove_dashboard_menuitems_editor(){
  if(current_user_can('editor')){
    remove_menu_page('edit-comments.php');
    remove_menu_page('tools.php');
    remove_menu_page('customize.php');
    remove_menu_page('edit.php?post_type=acf-field-group');
  }
}

// Remove these even if user is an administrator
function remove_dashboard_menuitems(){
  remove_menu_page('edit-comments.php');
  remove_menu_page('edit.php');
}

add_action('admin_menu', 'remove_dashboard_menuitems');

//Keep non-admins from viewing admin panel
add_action( 'init', 'blockusers_init' );
function blockusers_init(){
	if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX) ) {
		wp_redirect(home_url());
		exit;
	}
}

//Remove Admin Bar from screen unless user is admin
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

//Memberful-Related Functions //----

//Remove Memberful Styling for Profile Widget?
function eg_members_remove_stylesheet( $current ) {
  return false;
}
add_filter( 'memberful_wp_profile_widget_add_stylesheet', 'eg_members_remove_stylesheet' );

//Functions to help expose Memberful values to Timber
if(is_user_logged_in()) {
  $allMfSubs = get_option('memberful_subscriptions'); //Array of all subs
  $currentUserId = get_current_user_id(); //Current User ID
  $currentUserSubArray = memberful_wp_user_plans_subscribed_to($currentUserId); //Array of IDs of Active Subs
  $userIdArray = get_current_user_mf_subs($currentUserSubArray);
}

function get_current_user_mf_subs($currentUserSubArray) {
  if(is_user_logged_in()){
    $idArray = array();
    if (is_array($currentUserSubArray)) {
      foreach($currentUserSubArray as $row) {
        $idArray[] = $row['id'];
      }
    }
    return $idArray;
  }
}

function user_active_subscriptions($allMfSubs, $userIdArray) {
  if(is_user_logged_in()){
    // i create an empty array. if the user has no active subscriptions, the
    // function will return an empty array/no subscriptions
    $activeSubscriptions = array();
    // i loop through the subscription ids
    foreach($userIdArray as $subscriptionId) {
      // if the subscriptionId isn't found in $allMfSubs, the
      // $subscription variable will have the value of null
      $subscription = $allMfSubs[$subscriptionId];
      // an if statement will treat null and false the same way.
      // if the $subscription is true/not null, add it to the array of
      // active subscriptions
      if($subscription) {
        $activeSubscriptions[] = $subscription;
      }
    }
    // return whatever you've found
    return $activeSubscriptions;
  }
}

function user_active_subscription_names($allMfSubs, $userIdArray) {
  if(is_user_logged_in()){
    $activeSubscriptionNames = array();
    foreach($userIdArray as $subscriptionId) {
      $subscription = $allMfSubs[$subscriptionId];
      if($subscription) {
        $activeSubscriptionNames[] = $subscription["name"];
      }
    }
    return $activeSubscriptionNames;
  }
}

// Add ACF options panel to dash
if( function_exists('acf_add_options_page') ){
  acf_add_options_page();
}

// Shortcodes and such // ----

    // Add SoundCloud oEmbed
  function add_oembed_soundcloud(){
    wp_oembed_add_provider( 'http://soundcloud.com/*', 'http://soundcloud.com/oembed' );
  }
  add_action('init','add_oembed_soundcloud');

  // Video Embed Shortcode
  // [video url="embed-url" description="Description Here"]
  function video_embed( $atts ) {
    $a = shortcode_atts( array(
        'url' => '//www.youtube.com/embed/iHEMrcvWnJ4?controls=2&autohide=1',
        'description' => 'Video description here.'
    ), $atts );

    $shortcode_content = '<div class="video--container">
                            <div class="row">
                              <div class="col-md-3">
                                <div class="video--description">' . $a['description'] . '</div>
                              </div>
                              <div class="col-md-9">
                                <div class="video--wrapper">
                                  <iframe src="' . $a['url'] . '?frameborder="0" allowfullscreen></iframe>
                                </div>
                              </div>
                            </div>
                          </div>';
    return $shortcode_content;
  }

  add_shortcode( 'video', 'video_embed' );