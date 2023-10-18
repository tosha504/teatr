<?php

/**
 * Banner Block Template.
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
$slides = get_field('slides') ?: 'slides..'; ?>

<section class="banner">
  <div class="container">
    <div class="banner__slider">
      <?php
      foreach ($slides as $key => $slide) {
        $image = $slide['banner_img'] ? wp_get_attachment_image($slide['banner_img'], 'full') : '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-muzyczny-zdjecie.webp' . '  alt="teatr-muzyczny">';
        $title_banner = $slide['titile_banner'] ?: 'Your titile here...';
        $title =  $key ? '<h2 class="slide__content_title">' . $title_banner . '</h2>' : '<h1 class="slide__content_title">' . $title_banner . '</h1>';
        $banner_descr = $slide['descr_banner'] ? $slide['descr_banner'] : 'Description banner..';
        echo '<div class="banner__slider_slide slide">
        <div class="slide__img">' .
          $image .
          '</div>
        <div class="slide__content">
          <p class="slide__content_pre-title">' . $slide['pre_title'] . '</p>' .
          $title . '<p class="slide__content_descr">' . $banner_descr . '</p>
        </div>
      </div>';
      }
      ?>
    </div>
  </div>
</section>