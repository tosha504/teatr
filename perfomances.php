<?php 
/**
 *Template Name: Perfomances
 * @package teatr
 */

 get_header(); ?>
 
<main id="primary" class="site-main">

  <?php the_content(); ?>
  <section class="shows-page">
    <div class="container">
      <?php 
      $perfomances = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/perfomances');
      $perfomances = json_decode($perfomances);
        $uniq_categories = [];
        $list_html = '';
        $list_html .= '<div class="performances">';
        foreach ($perfomances as $date => $datePerfomaces) {
          foreach ($datePerfomaces as $perfomance) {
            // var_dump($perf);
            $cat_slug = sanitize_title($perfomance->category);
            $date = date('d/m/y',strtotime($perfomance->date_time));
            $time= date('H:i',strtotime($perfomance->date_time));
            $image = !empty(get_the_post_thumbnail($perfomance->show, 'medium')) ?
            get_the_post_thumbnail($perfomance->show, 'medium') : 
            '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' width="213" height="300" alt="alternative_name">';
            $uniq_categories[$perfomance->category] = '';
            $item_html = str_replace('{title}',$perfomance->title,singlePerfomanceCard());
            $item_html = str_replace('{category}',$perfomance->category,$item_html);
            $item_html = str_replace('{date}',$date,$item_html);
            $item_html = str_replace('{time}',$time,$item_html);
            $list_html .= $item_html;
          }
        }
        $list_html .= '</div>';
        $uniq_categories = array_keys($uniq_categories);
      ?>

     <?php echo pageSwitcher(); ?>

      <div class="shows-list">
        <ul class="shows-list__categories">
          <li><a href="#">wszystkie</a></li>
        <?php
           foreach ($uniq_categories as $category) {
            // var_dump($categorie);
            echo '<li><a href="#">' . $category . '</a></li>';
          }?>
        </ul>
      </div>
      <div class="box"><div class="loader"></div></div>
      <?php echo $list_html; ?>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();