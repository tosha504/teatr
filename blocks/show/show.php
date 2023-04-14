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
    <?php foreach ($shows as $key => $show) {
      // var_dump($show);
      $image = get_the_post_thumbnail($show->ID, 'full') ?: '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-muzyczny-zdjecie.webp' . ' alt="alternative_name">';
      echo '<div class="shows__item">' . '<a href=" ' . get_permalink($show->ID) . '">' .
        $image . '</a>' .
        '<p class="categories">Categories</p>' .
        '<a href=" ' . get_permalink($show->ID) . '"><h4>' . $show->post_title . '</h4></a>
      <div class="buy"><a href="#">Kup bilet</a></div>
      </div>';
    } ?>
  </div>
</section>