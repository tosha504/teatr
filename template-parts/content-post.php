<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php echo do_shortcode('[search_nav]'); 
		echo breadcrumb_block(get_the_title());	?>
		<div class="container">
			<div class="single-artist">
				<div class="single-artist__fields">
				</div>
				<div class="single-artist__content">
					<?php 
						the_post_thumbnail();
						the_content(); 
					?>
				</div>
			</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->