<?php

/**
 * Custom functions
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

function pageSwitcher($type = null) {
  $show = is_post_type_archive( 'show' )  ? 'class="active"' : '';
  $perfomances =  $type !== 'out' && ! is_post_type_archive( 'show' ) ? 'class="active"' : '';
  $perfomances_out =  $type === 'out' ? 'class="active"' : '';

  $url = get_site_url();

  return <<<HTML
  <ul class="pages">
    <li>
      <a href="$url/show/" $show>Spektakle</a>
    </li>
    <li>
      <a href="$url/performance/" $perfomances>Repertuar teatru</a>
    </li>
    <li>
      <a href="$url/performance/?type=out" $perfomances_out>Repertuar imprez gościnnych</a>
    </li>
  </ul>
  HTML;
}

function perfomances_calendar() { ?>
  <section>
			<div class="container">
				<form>
					<?php 
						if(isset($_GET['month']) && !empty($_GET['month'])) {
							$active_date = $_GET['month'];
						}else {
							$active_date = date_i18n('Y-m-d');
						}
						$today_date = new DateTime($active_date);
						$first_date = clone $today_date;
						$today_month = $first_date->format('F');
						$first_date->modify('first day of this month');
						$formated_first_date = $first_date->format('Y-m-d');
						
						$prev_momth_first_date = clone $first_date;
						$prev_momth_first_date->modify('first day of last month');
						$formated_prev_momth_first_date = $prev_momth_first_date->format('Y-m');
						
						$next_momth_first_date = clone $first_date;
						$next_momth_first_date->modify('first day of next month');
						$formated_next_momth_first_date = $next_momth_first_date->format('Y-m');

						$last_date = clone $today_date;
						$last_date->modify('last day of this month');
						$formated_last_date = $last_date->format('Y-m-d');

						$active_perfomances_days = file_get_contents(get_site_url() . 
						"/wp-json/teatr_muzyczny/v1/perfomances?datefrom={$formated_first_date}&dateto={$formated_last_date}");
						$active_perfomances_days = json_decode($active_perfomances_days);
						
						$current_date = clone $first_date;
						$formated_current_date = $current_date->format('Y-m-d');
						while($formated_current_date <= $formated_last_date) { 
							$disabled = isset($active_perfomances_days->$formated_current_date) ? '' : ' disabled';
							echo "<button{$disabled}>{$current_date->format('d')}</button>";
							$current_date->modify('+1 day');
							$formated_current_date = $current_date->format('Y-m-d');

						}
					?>
					<button value="<?php echo $formated_prev_momth_first_date?>" name="month"><</button>
					<span><?php _e($today_month); ?></span>
					<button value="<?php echo $formated_next_momth_first_date?>" name="month">></button>
				</form>
			</div>
		</section>
<?php }

function breadcrumb_block($title,$description = null) {
 	$description = $description !==null ? '<p>' . $description . '</p>' : '';
	$bread = '';
	 if (function_exists('yoast_breadcrumb')) {
		$bread = yoast_breadcrumb('<nav class="breadcrumbs-nav"><p id="breadcrumbs">', '</p></nav>', false);
	}
	return <<<HTML
		<section class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs__content" style="background:#f4f2ef" >
			{$bread}
				<div class="breadcrumbs__content_wrap">
					<h1>{$title}</h1>
					{$description}
				</div>
			</div>
		</div>
	</section>
	HTML;
}

function performance_render_template($month) {

	$parmas_array['type'] = 'in';
	$type_out_input = '';
	if (isset($_GET['type']) && $_GET['type'] === 'out') {
		$parmas_array['type'] = 'out';
		$type_out_input = "<input type=\"text\" name=\"type\" style=\"display: none\" value=\"{$parmas_array['type']}\" />";
	}

	$current_date_time = date_i18n('Y-m-d H:i:s');

	$month_date = new DateTime($month);
	$first_day_of_this_month = clone $month_date;
	$first_day_of_this_month->modify('first day of this month');
	$formated_first_day_of_this_month = $first_day_of_this_month->format('Y-m-d');
	$parmas_array['datefrom'] = $formated_first_day_of_this_month;
	
	$last_day_of_this_month = clone $month_date;
	$last_day_of_this_month->modify('last day of this month');
	$formated_last_day_of_this_month = $last_day_of_this_month->format('Y-m-d');
	$parmas_array['dateto'] = $formated_last_day_of_this_month;
	
	$params_str = http_build_query($parmas_array);

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
		$list_html = '';
			$list_html .= '<div class="performances">';
			foreach ($performances as $date => $datePerfomaces) {
				foreach ($datePerfomaces as $perfomance) {
					$cat_slug = sanitize_title($perfomance->category);
					$date = date('d/m/y',strtotime($perfomance->date_time));
					$time= date('H:i',strtotime($perfomance->date_time));
	 
					$buy_button = $current_date_time < $perfomance->date_time && !empty($perfomance->buy) ? '<a href="' . esc_url($perfomance->buy) . '" class="btn">Kup bilet</a>' : '';
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
			$list_html .= '</div>';
			?>
			 <?php echo pageSwitcher($_GET['type']); ?>
     <form id="filter_form">
      <input type="text" id="filter_month" name="month" style="display: none" value="<?php echo $month?>" />
      <input type="text" id="filter_category" name="category" style="display: none" value="<?php echo $category; ?>" />
      <?php echo $type_out_input;

			if(count($uniq_categories) > 1) { ?>
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
<?php }