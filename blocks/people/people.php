<?php

/**
 * People Block Template.
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
$bg_color = get_field('bg_color') ?: '#ccc';
$description = get_field('description') ?: 'Youe description...'; ?>

<section class="people">
  <div class="container">
    <ul class="people__categories">
      <li>
        <a class="active" href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
      <li>
        <a href="#">Dyrekcja</a>
      </li>
      <li>
        <a href="#">Kierownictwo</a>
      </li>
    </ul>
    <div class="people__items">
      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>

      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>

      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>

      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>

      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>

      <div class="people__items_item">
        <a href="#">
          <img src="<?php echo get_template_directory_uri() . '/blocks/people/jakub-szydlowski-opis-teatr-muzyczny.webp' ?>" alt="">
          <p>Jakub Szydlowski</p>
        </a>
      </div>
    </div>
  </div>
</section>