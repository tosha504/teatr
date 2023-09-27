<?php

/**
 * Template part for displaying people-posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	$curent_person_ID =  get_the_ID();
	$performances = array(
		'post_type' => 'performance',
		'posts_per_page'   => -1,
	);
	$performances_query = new WP_Query($performances);

	$people_field = get_field('people_field', get_the_ID());
	$position = get_field('post', get_the_ID());
	$brief_info = get_field('brief_info', get_the_ID());
	$position_show = $position ? '<p class="position">' . $position . '</p>' : '';
	$bierf_info_show = $brief_info ? $brief_info . '</br></br>' : '';
	echo do_shortcode('[search_nav]'); ?>
	<section class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs__content" <?php echo 'style="background: #f4f2ef"' ?>>
				<?php if (function_exists('yoast_breadcrumb')) {
					yoast_breadcrumb('<nav class="breadcrumbs-nav">
					<p id="breadcrumbs">', '</p>
				</nav>');
				}
				$excerpt =  has_excerpt() ? get_the_excerpt() : '';
				echo '<div class="breadcrumbs__content_wrap">
					<div>
						<h1>' .	get_the_title() . '</h1>' . $position_show .
					'</div>
					<div>
						<p>' . $bierf_info_show . $excerpt . ' </p>
					</div>
				</div>';
				?>
			</div>
		</div>
	</section>

	<div class="container">
		<div class="single-artist">
			<div class="single-artist__fields">
				<?php
				if ($people_field) {
					foreach ($people_field as $key => $field) {
						echo '<p>' . $field['title'] . '</p><br>';
						foreach ($field['advantages'] as $key => $advantage) {
							echo '<p><span>' . $advantage['advantages_title'] . '</span>' . $advantage['advantages_description'] . '</p>';
						}
					}
				}
				?>
			</div>
			<div class="single-artist__content">
				<?php
				the_post_thumbnail();
				the_content();

				if ($performances_query->have_posts()) { ?>
					<div class="currently-playing">
						<span class="currently-playing__title">Aktualnie gra w</span>
						<ul>
							<?php while ($performances_query->have_posts()) {
								$performances_query->the_post(); ?>
								<?php
								$realists = get_field('realists',  get_the_ID());
								foreach ($realists as $key => $realist) {
									foreach ($realist['people'] as $key => $people) {
										if ($curent_person_ID === $people['person']->ID) { ?>
											<li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
								<?php }
									}
								}
								?>
						<?php }
						} ?>
						</ul>
					</div>
					<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->