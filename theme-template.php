<?php 
/**
 *Template Name: Teheme-template
 * @package teatr
 */
$description_theme_template = get_field('description_theme_template');
$title = get_field('title', 'options');
$html = get_field('html', 'options');
$tour = get_field('tour');
$kontakt = get_field('kontakt');

get_header(); ?>
 
<main id="primary" class="site-main">

  <?php echo do_shortcode('[search_nav]'); 
  echo breadcrumb_block(get_the_title(),$description_theme_template);	?>
  <div class="theme">
    <div class="container">
      <?php if(get_the_post_thumbnail()) { ?>
        <div class="image">
          <?php the_post_thumbnail(); ?>
        </div>
      <?php } ?>  
      <div class="single-artist">
        <?php if($kontakt) {
          echo "<div class='single-artist__kontakt'>
           {$kontakt}
          </div>";
         } else {?>
          <div class="single-artist__fields">
            
          </div>
        <?php } ?>
        <div class="single-artist__content">
          <?php the_content(); ?>
        </div>
      </div>
      <?php if($tour ==true && $title && $html) { ?>
        <div class="tour">
          <?php echo '<h3>' . $title . '</h3>' .'<div class="tour__frame"> ' . $html . '</div>' ;?>
        </div>
      <?php } ?>
    </div>
  </div>

</main><!-- #main -->

<?php get_footer();