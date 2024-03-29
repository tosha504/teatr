<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */

?>

<section class="no-results not-found">
	<div class="container">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e('Nic nie znaleziono', 'start'); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<?php
			if (is_home() && current_user_can('publish_posts')) :

				printf(
					'<p>' . wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'start'),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					) . '</p>',
					esc_url(admin_url('post-new.php'))
				);

			elseif (is_search()) :
			?>

				<p><?php esc_html_e('Przepraszamy, ale nic nie pasuje do wyszukiwanych haseł. Spróbuj ponownie z innymi słowami kluczowymi.', 'start'); ?></p>
			<?php
				echo search_nav();

			else :
			?>

				<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'start'); ?></p>
			<?php
				get_search_form();

			endif;
			?>
		</div><!-- .page-content -->
	</div>
</section><!-- .no-results -->