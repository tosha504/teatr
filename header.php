<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package teatr
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="wrapper">
		<div class="topBar">
			<div class="container">
				<ul class="header__wcag">
					<li class="header__wcag_minus">
						<a href="#">
							-A
						</a>
					</li>
					<li class="header__wcag_plus">
						<a href="#">
							+A
						</a>
					</li>
					<li class="header__wcag_contrast">
						<a href="#">

						</a>
					</li>
				</ul>
			</div>
		</div>
		<header id="masthead" class="header">
			<div class="container">
				<div class="header__top">

				</div>

				<div class="header__bottom">
					<?php
					$header = get_field('header', 'options');
					$logo = $header['logo'];
					$logo_sticky = $header['logo_sticky'];
					if ($logo) { ?>
						<div class="header__logo">
							<a href="<?php echo esc_url(home_url('/')) ?>">
								<?php 
									echo wp_get_attachment_image($logo, 'thumbnail', false, array('class' => 'normal active')); 
									echo wp_get_attachment_image($logo_sticky, 'thumbnail', false, array('class' => 'sticky'));
								?>
							</a>
						</div>
					<?php } ?>

					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header',
								'container' 			=> false,
								'menu_class'      => 'header__nav',
								'menu_id'         => 'main-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->

					<ul class="socials">
						<?php
						$soicals = get_field('socials', 'options');
						foreach ($soicals as $social) { ?>
							<li>
								<a href="<?php echo $social['social']['url'] ?>" target="_blank"><?php echo wp_get_attachment_image($social["icon"], 'thumbnail') ?></a>
							</li>
						<?php } ?>
					</ul>

					<div class="burger"><span></span></div>
				</div>
			</div>
		</header><!-- #masthead -->

		<?php  
			if (is_front_page()) {
			if(isset($_GET['month']) && !empty($_GET['month'])) {
				$month = $_GET['month'];
			}else {
				$month = date_i18n('Y-m-d');
			}
			$current_month_date = new DateTime($month);
			$current_month_date_formated = $current_month_date->format('F');

			$prev_month = clone $current_month_date;
			$prev_month->modify('first day of last month');
			$prev_month_formated = $prev_month->format('Y-m');
			
			$next_month = clone $current_month_date;
			$next_month->modify('first day of next month');
			$next_month_formated = $next_month->format('Y-m');

			$this_month_int = intval(date_i18n('Ym'));
			$prev_month_int = intval( $prev_month->format('Ym'));
			$next_month_int = intval($next_month->format('Ym'));
			$prev_month_btn = '';
			$next_month_btn = '';
			if($this_month_int - $prev_month_int < 1){
				$prev_month_btn = "<li><button class='prev' value=\"$prev_month_formated\" name=\"filter_month\"></button></li>";
			}
			if($next_month_int - $this_month_int < 4){
				$next_month_btn = "<li><button class='next' value=\"$next_month_formated\" name=\"filter_month\"></button></li>";
			}

			$first_month_date = clone $current_month_date;
			$first_month_date->modify('first day of this month');
			$first_month_date_formated = $first_month_date->format('Y-m-d');

			$last_month_date = clone $current_month_date;
			$last_month_date->modify('last day of this month');
			$last_month_date_formated = $last_month_date->format('Y-m-d');

			$performances = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/performances?');
			$performances = json_decode($performances);
			
			$ul = '<div class="days"><ul>';
			while($first_month_date_formated <= $last_month_date_formated) {
				$display_shows = '<div class="shows-display"' . $right_class .'>';
				$right_class = $first_month_date->format('d') > 15 ? ' style="right:0"' : ' style="left:0"';
				
				$date = $performances->$first_month_date_formated ? date('j',strtotime($first_month_date_formated)) : '';
				$display_shows .= '<p>' . $date . '</p><div class="span-wrap">';
				if($performances->$first_month_date_formated) foreach ($performances->$first_month_date_formated as $key => $show) {
					$time= date('H:i',strtotime($show->date_time));
					$display_shows .= '<div><a href="' . $show->show_url . '">' . $show->title . '<br><span>godz. ' . $time . '</span></div></a>';
				}
				$display_shows .= '</div></div>';
				$display_shows = $performances->$first_month_date_formated ? $display_shows : '';
				$bold = !empty($display_shows) ? 'has-event' : 'none-event';
				$active_class  = intval(date_i18n('Ymd')) == intval($first_month_date->format('Ymd')) ? 'active ' : '' ;
				$ul .= '<li class="' . $active_class . $bold . '"><p>' . $first_month_date->format('j') . '</p>' . $display_shows . '</li>';
				$first_month_date ->modify('+1 day');
				$first_month_date_formated = $first_month_date->format('Y-m-d');
				
			}
			$ul .=  '</ul></div>';
		?>
		<section class="calendar">
			<div class="container">
				<div class="calendar__items">
					<form id="filter_form">
						<div class="shows-list">
							<input type="text" id="filter_month" name="month" style="display:none" value="<?php echo $month?>" />  
							<ul class="shows-list__categories">
								<?php echo $prev_month_btn; ?>
								<li><p><b>Repertuar</b> | <?php _e($current_month_date_formated) ?></p></li>
								<?php echo $next_month_btn; ?>
							</ul>
						</div>
					</form>
					<?php echo $ul; ?>
				</div>
			</div>
		</section>
	<?php } ?>
		
			