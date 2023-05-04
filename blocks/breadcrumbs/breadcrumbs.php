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
$description = get_field('description') ?: 'Youe description...'; 
$bg_color = get_field('bg_color') ?: '#f4f2ef';

echo breadcrumb_block(get_the_title(), $description, $bg_color);