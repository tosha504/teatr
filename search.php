<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package teatr
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>
			<?php echo do_shortcode('[search_nav]'); 
				$title = esc_html__( 'Wyniki wyszukiwania: ', 'start' ) .  '<span>' . get_search_query() . '</span>';
				echo breadcrumb_block($title);	
			?>
			<div class="container">
				<div class="news">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					the_posts_navigation();

					else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
