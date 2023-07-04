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
$choose_form = get_field('choose_form'); ?>

<section class="choose-form">
  <div class="choose-form__forms">
    <select id="select-form" data-page-id="<?php echo get_the_ID(); ?>">
      <?php foreach ($choose_form as $key => $form) { ?>
        <option value="<?php echo $form['email']; ?>"><?php echo $form['email']; ?></option>
      <?php } ?>
    </select>
    <div class="box"></div>
    <div id="form_append"></div>
  </div>
</section>