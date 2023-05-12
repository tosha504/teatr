<?php 
/**
*Template Name: Shows
* @package teatr
*/
$description = get_field('description', 'options');
get_header(); ?>
 
<main id="primary" class="site-main">

  <section class="shows-page">
      <?php 
      echo search_nav();
      echo breadcrumb_block('Spektakle', $description);
      echo '<div class="container">';
      $shows = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/shows');
      $shows = json_decode($shows);
        $list_html = '';
        $list_html .= '<div class="performances">';
        foreach ($shows as $date => $show) {
          $trim_words = 20;
          $short_descr = wp_trim_words( $show->short , $trim_words );
          $descr = wp_trim_words( $show->descr , $trim_words );
          $description = !empty($show->short) ? '<p>' . $short_descr . '</p>' : '<p>' . $descr . '</p>';
          $date = $show->premiere_date ? date('d/m/y',strtotime($show->premiere_date)) : '';
          $image = !empty($show->image) ?
            '<img src=' . $show->image . ' width="213" height="300" alt="alternative_name">' : 
            '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' width="213" height="300" alt="alternative_name">';
          $list_html .= '
          <div class="performance">
            <div class="performance__header">
              <h6 class="performance__header_title title">Spektakl</h6>
              <div class="performance__header_buttons">
                <a href="#" class="dark">Rezerwuj</a>
                <a href="' . $show->url .'#cast">Obsada</a>
              </div>
              <p class="performance__header_category ' . $show->category_slug . '">' . $show->category . '</p>
            </div>
            <div class="performance__body">
              <div class="performance__body_date">
                <p><span>Premiera:</span><br>' . $date . '</p>
              </div>
              <div class="performance__body_image">
                <a href="' . $show->url .'">' . $image . '</a>
              </div>
              <div class="performance__body_content">
                <a href="' . $show->url .'"><h6>' . $show->title . '</h6> </a>
               '.$description .'
                <div class="btns">
                  <a class="btns__btn" href="' . $show->url .'">Wiecej</a>
                </div>
              </div>
            </div>
          </div>';
        }
        $list_html .= '</div>';
      ?>

     <?php echo pageSwitcher(); ?>

      <?php echo $list_html; ?>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();