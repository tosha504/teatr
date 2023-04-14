<?php

/**
 * start functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package teatr
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function garden_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on start, use a find and replace
		* to change 'garden' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('start', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header' => esc_html__('Header menu', 'start'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'garden_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'garden_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function garden_content_width()
{
	$GLOBALS['content_width'] = apply_filters('garden_content_width', 640);
}
add_action('after_setup_theme', 'garden_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function garden_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'garden'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'garden'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'garden_widgets_init');

/**
 * Disable Gutenberg
 */
// add_filter('use_block_editor_for_post', '__return_false');

// Theme includes directory.
$realestate_inc_dir = 'inc';

// Array of files to include.
$realestate_includes = array(
	'/functions-template.php',  // 	Theme custom functions
	'/enqueue.php',				//	Enqueue scripts and styles.
	'/custom-header.php',		//	Implement the Custom Header feature.
	'/customizer.php',			//	Customizer additions.
	'/template-tags.php',		// 	Custom template tags for this theme.	
	'/template-functions.php',	//	Functions which enhance the theme by hooking into WordPress.

);

// Load WooCommerce functions if WooCommerce is activated.
if (class_exists('WooCommerce')) {
	$realestate_includes[] = '/woocommerce.php';
}

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Include files.
foreach ($realestate_includes as $file) {
	require_once get_theme_file_path($realestate_inc_dir . $file);
}

/**
 * Make ACF Options
 */
if (function_exists('acf_add_options_page')) {
	$option_page = acf_add_options_page([
		'page_title' => 'General settings',
		'menu_title' => 'General settings',
		'menu_slug' => 'theme-general-settings',
		'post_id' => 'options',
		'capability' => 'edit_posts',
		'redirect' => false
	]);
}

//svg
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

define('ALLOW_UNFILTERED_UPLOADS', true);

function fix_svg_thumb_display()
{
	echo
	'<style>
		td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
			width: 100% !important; 
			height: auto !important; 
		}
	</style>';
}


function register_acf_blocks()
{

	// wp_register_script(
	// 	"banner",
	// 	get_template_directory_uri() . "/blocks/banner/banner.js"
	// );

	register_block_type(dirname(__FILE__) . '/blocks/banner/block.json');
	register_block_type(dirname(__FILE__) . '/blocks/news/block.json');
	register_block_type(dirname(__FILE__) . '/blocks/head_block/block.json');
	register_block_type(dirname(__FILE__) . '/blocks/show/block.json');
	register_block_type(dirname(__FILE__) . '/blocks/search/block.json');

	// if ( has_block( 'acf/banner' , 87) ) {
	// 	wp_enqueue_script( 'banner', get_template_directory_uri() . "/blocks/banner/banner.js" , array(), '1.0.0', true );
	// }
	// var_dump(get_template_directory_uri() . "/blocks/banner/banner.js");
}
add_action('init', 'register_acf_blocks');

function search_nav()
{
	$links = get_field('links', 'options');
	$my_link = '';
	$current_image = '';
	foreach ($links as $key => $link) {
		// var_dump($link['image']);
		$link_url = $link['link'] ? $link['link']['url'] : '#';
		$link_title = $link['link'] ? $link['link']['title'] : 'Your title';
		$my_link .= '<li><a href="' . esc_url($link_url) . '">' . wp_get_attachment_image($link['image'], 'thumbnail') . '<span>' . $link_title . '</span></a></li>';
	}
	return '<div class="searchNav">
 	 <div class="container">
			<form role="search" method="get" class="search-form" action="' .  esc_url(home_url('/')) . '">
				<label>
					<span class="screen-reader-text">' . __('Search for:') . '</span>
					<input type="search" class="search-field" placeholder="' . esc_attr_x('Szukaj', 'placeholder') . '" value="' . get_search_query() . '" name="s" />
				</label>
				<button type="submit" class="btn">' . esc_html_x('Search', 'submit button') . '</button>
				</form>
				<ul class="searchNav__links">' . $my_link . '</ul>
		</div>
	</div>';
}
add_shortcode('search_nav', 'search_nav');
