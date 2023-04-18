<?php

/**
 * Breadcrumbs Block Template.
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
$bg_color = get_field('bg_color') ?: '#f4f2ef';
$description = get_field('description') ?: 'Youe description...'; ?>

<section class="breadcrumbs">
  <div class="container">
    <div class="breadcrumbs__content" <?php echo 'style="background:' . $bg_color . '"' ?>>
      <?php if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<nav class="breadcrumbs-nav">
        <p id="breadcrumbs">', '</p>
      </nav>');
      }
      echo '<div class="breadcrumbs__content_wrap"><h1>' .
        get_the_title() . '</h1><p>' . $description . ' </p>' .
        '</div>';
      ?>
    </div>
  </div>
</section>