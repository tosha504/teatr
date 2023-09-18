<?php

/**
 *Template Name: Shows
 * @package teatr
 */

$parmas_array = [];
$description =  get_field('performaces_in', 'options');
$month = '';
if (isset($_GET['month']) && !empty($_GET['month'])) {
  $month = sanitize_text_field($_GET['month']);
} else {
  $month = date_i18n('Y-m');
}
if (isset($_GET['type']) && $_GET['type'] === 'out') {
  $parmas_array['type'] = 'out';
  $description =  get_field('performaces_out', 'options');
}
get_header(); ?>

<main id="primary" class="site-main">
  <section class="shows-page">
    <?php
    echo search_nav();
    $page_title = $_GET['type'] !== null ? 'Repertuar imprez gościnnych' : 'Repertuar teatru';
    echo breadcrumb_block($page_title, $description); ?>
    <div class="container">
      <?php echo performance_render_template($month); ?>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();
