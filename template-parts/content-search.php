<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
$trim_words = 20;
$excerpt = !empty(get_the_excerpt()) ? wp_trim_words( get_the_excerpt() , $trim_words ) : wp_trim_words( get_field('show', get_the_ID())->post_excerpt , $trim_words );
?>

<article>
	<a href="<?php echo esc_url( get_permalink() ); ?>">
		<?php 
			echo '<h4>' . get_the_title(get_the_ID()) . '</h4>';
			echo '<p>' . $excerpt . '</p>'; 
		?>
	</a>
</article><!-- #post-<?php the_ID(); ?> -->
