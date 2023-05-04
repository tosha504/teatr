<?php 
/**
 *Template Name: performances
 * @package teatr
 */

get_header();

$parmas_array = [];
$type = get_field('type');
if(!empty($type)) {
  $parmas_array['type'] = $type;
}
$current_date_time = date_i18n('Y-m-d H:i:s');

$month = '';
if (isset($_GET['month']) && !empty($_GET['month'])) {
  $month = sanitize_text_field($_GET['month']);
}
else {
  $month = date_i18n('Y-m');
}

$month_date = new DateTime($month);
$first_day_of_this_month = clone $month_date;
$first_day_of_this_month->modify('first day of this month');
$formated_first_day_of_this_month = $first_day_of_this_month->format('Y-m-d');
$parmas_array['datefrom'] = $formated_first_day_of_this_month;

$last_day_of_this_month = clone $month_date;
$last_day_of_this_month->modify('last day of this month');
$formated_last_day_of_this_month = $last_day_of_this_month->format('Y-m-d');
$parmas_array['dateto'] = $formated_last_day_of_this_month;

$params_str = http_build_query($parmas_array); ?>
 
<main id="primary" class="site-main">

  <?php the_content(); ?>
  <section class="shows-page">
    <div class="container">
      <?php 
      $performances = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/performances?' . $params_str);
      $performances = json_decode($performances);
        $uniq_categories = [];
        foreach ($performances as $date => $datePerfomaces) {
          foreach ($datePerfomaces as $perfomance) {
            $uniq_categories[$perfomance->category] = ''; 
          }
        }
        $uniq_categories = array_keys($uniq_categories);

        $category = '';
        if (isset($_GET['category']) && !empty($_GET['category'])) {
          $category = sanitize_text_field($_GET['category']);
          $parmas_array['category'] = $category;
        }
        
        if(isset($parmas_array['category']) || (isset($parmas_array['datefrom']) && isset($parmas_array['dateto']))) {
          
          $params_str = http_build_query($parmas_array);
          $performances = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/performances?' . $params_str);
          $performances = json_decode($performances);
        }
    
          $list_html .= '<div class="performances">';
          foreach ($performances as $date => $datePerfomaces) {
            foreach ($datePerfomaces as $perfomance) {
              $cat_slug = sanitize_title($perfomance->category);
              $date = date('d/m/y',strtotime($perfomance->date_time));
              $time= date('H:i',strtotime($perfomance->date_time));
       
              $buy_button = $current_date_time < $perfomance->date_time ? '<a href="' . $perfomance->buy . '" class="btn">Kup bilet</a>' : '';
              $image = !empty($perfomance->show_image) ?
              '<img src=' . $perfomance->show_image . ' width="213" height="300" alt="alternative_name">' : 
              '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' width="213" height="300" alt="alternative_name">';
              $list_html .='
              <div class="performance">
                <div class="performance__header">
                  <h6 class="performance__header_title title">Repertuar</h6>
                    <a href="' . $perfomance->url .'#cast" class="cast">Obsada</a>
                  <p class="performance__header_category '.$cat_slug.'">' . $perfomance->category . '</p>
                </div>
                <div class="performance__body">
                  <div class="performance__body_date">
                    <p><span>' . $date . '</span><br>' . $time . '</p>
                  </div>
                  <div class="performance__body_image">
                    <a href="' . $perfomance->url . '">' . $image . '</a>
                  </div>
                  <div class="performance__body_content">
                    <a href="' . $perfomance->url . '"><h6>' . $perfomance->show_title . '</h6> </a>
                    <div class="btns">
                      <a class="btns__btn" href="' . $perfomance->url . '">Wiecej</a>' .
                      $buy_button . 
                    '</div>
                  </div>
                </div>
            </div>';
            }
          }
          // var_dump($parmas_array['category'] );
          // var_dump($parmas_array['category'] == $category);
          $list_html .= '</div>';
      ?>

     <?php echo pageSwitcher($type); ?>

     <form id="filter_form">
      <input type="text" id="filter_month" name="month" style="display: none" value="<?php echo $month?>" />
      <input type="text" id="filter_category" name="category" style="display: none" value="<?php echo $category; ?>" />
      <?php if(count($uniq_categories) > 1) { ?>
        <div class="shows-list">
          <ul class="shows-list__categories">
            <li <?php echo $parmas_array['category'] == null ? 'class="active"' : ''; ?>><button name="filter_category" value="">wszystkie</button></li>
            <?php
              foreach ($uniq_categories as $category) {
                $active_class = $parmas_array['category'] == $category ? 'class="active"' : '';
                echo '<li ' . $active_class. '><button name="filter_category" value="' . $category . '">' . $category . '</button></li>';
              }
              ?>
            </ul>
            </div>
            <?php } ?>  
            <div class="shows-list">
              <ul class="shows-list__categories">  
              <?php 
                $prev_momth = clone $month_date;
                $prev_momth->modify('first day of last month');
                $formated_prev_momth = $prev_momth->format('Y-m');

                $next_momth = clone $month_date;
                $next_momth->modify('first day of next month');
                $formated_next_momth = $next_momth->format('Y-m');
                $formated_current_month = $month_date->format('F');

                $this_month_int = intval(date_i18n('Ym'));
                $prev_month_int = intval( $prev_momth->format('Ym'));
                $next_month_int = intval($next_momth->format('Ym'));
                $prev_month_btn = '';
                $next_month_btn = '';
                if($this_month_int - $prev_month_int < 1){
                  $prev_month_btn = "<li><button value=\"$formated_prev_momth\" name=\"filter_month\"><</button></li>";
                }
                if($next_month_int - $this_month_int < 4){
                  $next_month_btn = "<li><button value=\"$formated_next_momth\" name=\"filter_month\">></button></li>";
                }
              ?>
              <?php echo $prev_month_btn; ?>
              <li><p><?php _e($formated_current_month) ?></p></li>
              <?php echo $next_month_btn; ?>
            </ul>
          </div>
        </form>
      <?php echo $list_html; ?>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();