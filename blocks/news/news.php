<?php

/**
 * News Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Load values and assign defaults.
$newses = get_field('news') ?: 'news..'; ?>

<section class="newses">
  <div class="container">
    <div class="newses__items">
      <div class="newses__items_left">
        <?php
        $image =  get_the_post_thumbnail($newses[0]->ID) ?  get_the_post_thumbnail($newses[0]->ID, 'full') : '<img src="' .  get_template_directory_uri() . '/assets/image/teatr-muzyczny-zdjecie.webp">';
        $trim_words_excerpt = 25;
        $excerpt = wp_trim_words($newses[0]->post_excerpt, $trim_words_excerpt);
        $post_category =  get_the_category($newses[0]->ID);
        echo '<article><a href="' . esc_url(get_permalink($newses[0]->ID)) . '">';
        echo $image .
          '<div class="categories"><p>' . $post_category[0]->name  . '</p><p>News</p></div>';
        echo '<h4>' . $newses[0]->post_title . '</h4>';
        echo '<p>' . $excerpt . '</p>';
        echo '</a></article>';
        ?>
      </div>

      <div class="newses__items_right">
        <?php for ($i = 1; $i < 4; $i++) {
          echo '<article><a href="' . esc_url(get_permalink($newses[$i]->ID)) . '">';
          echo '<div class="categories"><p>' .  get_the_category($newses[$i]->ID)[0]->name . '</p><p>News</p></div>';
          echo '<h4>' . $newses[$i]->post_title . '</h4>';
          echo '</a></article>';
        } ?>
      </div>
    </div>
  </div>
</section>