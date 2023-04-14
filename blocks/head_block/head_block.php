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
$title = get_field('title') ?: 'Your title..';
$link = get_field('link');
$link_items = $link ? '<a class="btn" href="' . esc_url($link['url']) . '" target="' . $link['target'] . '">' . $link['title']  . '</a>' : 'Your link..'; ?>

<div class="container">
  <div class="custom__header">
    <?php echo '<h3>' . $title . '</h3>'  . $link_items ?>
  </div>
</div>