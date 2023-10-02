<?php

/**
 * The template for displaying home(archive)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
get_header(); ?>
<main id="primary" class="site-main">
  <?php
  $q = get_queried_object();
  echo search_nav();
  echo breadcrumb_block($q->label, $description); ?>
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="news">
        <?php
        /* Start the Loop */
        while (have_posts()) :
          the_post();
          $trim_words = 20;
          $excerpt = wp_trim_words(get_the_content(), $trim_words);
          /*
            * Include the Post-Type-specific template for the content.
            * If you want to override this in a child theme, then include a file
            * called content-___.php (where ___ is the Post Type name) and that will be used instead.
            */
        ?>
          <?php
          echo '<article><a href="' . esc_url(get_permalink()) . '">';
          echo '<h4>' . get_the_title() . '</h4>';
          echo '<p>' . $excerpt . '</p>';
          echo '</a></article>';
          ?>
      <?php
        endwhile;

        the_posts_navigation();

      else :

        get_template_part('template-parts/content', 'none');

      endif;
      ?>
      </div>

  </div>
</main><!-- #main -->

<?php
get_footer();
