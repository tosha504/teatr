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
add_action('wp_enqueue_scripts', 'teatr_scripts',);

add_action('wp_ajax_get_category_person', 'get_category_person');
add_action('wp_ajax_nopriv_get_category_person', 'get_category_person');

function get_category_person()
{
	if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
		$taxonomy = 'categories';
		$args = array(
			'post_type' => 'people',
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $_POST['category_id']
				)
			)
		);
		$query = new WP_Query($args);

		$terms = get_terms($taxonomy, [
			'parent'    => $_POST['category_id'],
			'hide_empty' => true,
		]);

		if ($_POST['category_id'] == 4 || $_POST['category_id'] == 5) {
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					$avatar = get_the_post_thumbnail() ?
						get_the_post_thumbnail() :
						'<img src="' . get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp" alt="avtar-image">';
					echo '<div class="people__items_item">
						<a href="' .  get_permalink() . '">' .
						$avatar . '
							<p>' . get_the_title() . '</p>
						</a>
					</div>';
				}
			}
		} else if ($terms) {
			foreach ($terms as $term) {
				if ($term->count != 0) {
					echo '<div class="category__wrap">';
					echo '<div class="category__wrap-name">' . $term->name . '</div>';
					$args = array(
						'post_type' => 'people',
						'tax_query' => array(
							array(
								'taxonomy' => $taxonomy,
								'field'    => 'id',
								'terms'    => $term->term_id
							)
						)
					);
					echo '<div class="category__wrap-items">';
					$n_query = new WP_Query($args);
					if ($n_query->have_posts()) {
						while ($n_query->have_posts()) {
							$n_query->the_post();
							$link = get_the_content() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : '<p>' . get_the_title() . '</p>';
							echo $link;
						}
						echo '</div>';
					}
					echo '</div>';
					wp_reset_postdata();
				}
			}
		} else {
			echo 'Tu nic nie ma!';
		}
		wp_reset_postdata();
	}
	die();
}

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
