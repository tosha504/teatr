<?php

/**
 * Head Block Template.
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
$shows = get_field('shows') ?: 'Your shows..';
?>
<section class="container">
  <div class="shows">
    <?php
    if (!empty($shows)) {


      foreach ($shows as $key => $show) {
        // var_dump($show);
        $current_show = get_field('show', $show->ID);
        $category = get_field('category', $show->ID);
        $link = get_permalink($show->ID);
        $image = get_the_post_thumbnail($current_show->ID, 'full') ?  get_the_post_thumbnail($current_show->ID, 'full') : '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' alt="teatr-nowy brak zdjecia">';
        echo '<div class="shows__item">' . '<a href=" ' . $link . '">' .
          $image . '</a>' .
          '<p class="categories">' . $category['value'] . '</p>' .
          '<a href=" ' . get_permalink($show->ID) . '"><h4>' . $show->post_title . '</h4></a>
      <div class="buy"><a href="' . $link . '">Wiecej</a></div>
      </div>';
      }
    } ?>
  </div>
</section>