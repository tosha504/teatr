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
		if (has_block('acf/choose-form')) {
			wp_enqueue_script('choose-ajax-script', get_template_directory_uri() . '/blocks/choose-form/choose-form.js', array('jquery', 'teatr_functions'), '1.0', true);
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
add_action('wp_enqueue_scripts', 'teatr_scripts');


add_action('wp_ajax_get_category_person', 'get_category_person');
add_action('wp_ajax_nopriv_get_category_person', 'get_category_person');

function ajax_choose_form()
{
	if (isset($_POST['sel_form']) && !empty($_POST['sel_form']) && isset($_POST['pageContactId']) && !empty($_POST['pageContactId'])) {
		$sel_form = $_POST['sel_form'];
		$id = intval($_POST['pageContactId']);
		if (has_block('acf/choose-form', $id)) {
			$post_obj = get_post($id);
			$post_data = parse_blocks($post_obj->post_content);
			$block_name = 'acf/choose-form';
			foreach ($post_data as $block) {
				if ($block['blockName'] === $block_name) {
					$key = array_search($sel_form, $block["attrs"]["data"]);
					$output = preg_replace('/[^0-9]/', '', $key);
					foreach ($block["attrs"]["data"] as $key => $value) {
						if ($key === "choose_form_{$output}_short_code") {
							echo do_shortcode($value);
						}
					}
				}
			}
		}
	}

	die();
}
add_action('wp_ajax_ajax_choose_form', 'ajax_choose_form');
add_action('wp_ajax_nopriv_ajax_choose_form', 'ajax_choose_form');
