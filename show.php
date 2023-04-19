<?php 
/**
 *Template Name: Shows
 * @package ogrud_botamiczny
 */

 get_header(); ?>
 
<main id="primary" class="site-main">

  <?php the_content(); ?>
  <section class="shows-page">
    <div class="container">
      <?php 
      $perfomances = file_get_contents('http://teater/wp-json/teatr_muzyczny/v1/perfomances');
      $perfomances = json_decode($perfomances);
        echo '<pre>';
        // var_dump($perfomances);
        echo '</pre>';
        $uniq_categories = [];
        $list_html = '';
        $list_html .= '<div class="performances">';
        foreach ($perfomances as $date => $datePerfomaces) {
          foreach ($datePerfomaces as $perfomance) {
            // var_dump($perf);
            $date = date('d/m/y',strtotime($perfomance->date_time));
            $time= date('H:i',strtotime($perfomance->date_time));
            
            $image = get_the_post_thumbnail($perfomance->show, 'medium');
            $title = get_the_title($perfomance->show);
            $uniq_categories[$perfomance->category] = '';
            $list_html .= <<<HTML
            <div class="performance">
              <div class="performance__header">
                <h6 class="performance__header_title title">Repertuar</h6>
                <a href="#" class="performance__header_cast">Obsada</a>
                <p class="performance__header_category">$perfomance->category</p>
              </div>
              <div class="performance__body">
                <div class="performance__body_date">
                  <p>
                    <span>$date</span><br>
                    $time
                  </p>
                  <a href="#" class="btn">Kup bilet</a>
                </div>
                <div class="performance__body_image">
                  $image
                </div>
                <div class="performance__body_content">
                  <h6>$title</h6>
                  <a href="#">Wiecej</a>
                </div>
              </div>
            </div>
            HTML;
          }
          
        }
        $list_html .= '</div>';
        $uniq_categories = array_keys($uniq_categories);
      ?>
      <ul class="pages">
        <li>
          <a href="#">Spektakle</a>
        </li>
        <li>
          <a href="#" <?php if(is_page( 'repertuar-teatru' )) echo 'class="active"'; ?>>Repertuar teatru</a>
        </li>
        <li>
          <a href="#">Repertuar imprez gościnnych</a>
        </li>
      </ul>

      <div class="shows-list">
        <ul class="shows-list__categories">
          <?php foreach ($uniq_categories as $categorie) {
            // var_dump($categorie);
            echo '<li><a href="#">' . $categorie . '</a></li>';
          }?>
        </ul>
      </div>

      <?php echo $list_html; ?>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();