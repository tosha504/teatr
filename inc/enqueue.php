<?php

/**
 * Theme enqueue scripts and styles.
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
if (!function_exists('teatr_scripts')) {
	function teatr_scripts()
	{


		$theme_uri = get_template_directory_uri();
		//Slick	slider 
		wp_enqueue_script('slick_theme_functions', $theme_uri . '/libery/slick.min.js', [], false, true);
		// Custom JS
		if (has_block('acf/banner',  get_queried_object_id())) {
			wp_enqueue_script('banner', get_template_directory_uri() . "/blocks/banner/banner.js", array('slick_theme_functions'), '1.0.0', true);
		}
		wp_enqueue_script('teatr_functions', $theme_uri . '/src/index.js', ['jquery'], time(), true);

		wp_localize_script('teatr_functions', 'localizedObject', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('ajax_nonce'),
		]);

		// Custom css
		wp_enqueue_style('teatr_style', $theme_uri . '/src/index.css', [], time());

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'teatr_scripts',);
