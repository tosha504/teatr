<?php
/**
 * The template for displaying home(archive)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
$id = get_the_ID();
get_header(); ?>
	<main id="primary" class="site-main">
    <?php 
    $q = get_queried_object();
    echo search_nav();
      echo breadcrumb_block($q->post_title, $description);?>
    <div class="container">
      <?php if ( have_posts() ) : ?>	
        <div class="news">
          <?php		
            /* Start the Loop */
            while ( have_posts() ) :
              $trim_words = 20;
              $excerpt = wp_trim_words( get_the_excerpt() , $trim_words );
            the_post();
            /*
            * Include the Post-Type-specific template for the content.
            * If you want to override this in a child theme, then include a file
            * called content-___.php (where ___ is the Post Type name) and that will be used instead.
            */
            ?>
                <?php 
                  echo '<article><a href="' . esc_url(get_permalink($id)) . '">';
                  echo '<div class="categories"><p>' .  get_the_category()[0]->name . '</p><p>News</p></div>';
                  echo '<h4>' . get_the_title($id) . '</h4>';
                  echo '<p>' . $excerpt . '</p>';
                  echo '</a></article>';
                ?>
            <?php 
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
get_footer();