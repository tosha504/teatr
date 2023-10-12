<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
$id = get_field('show')->ID;
$info = get_field('info', $id) ? '<p class="position-job">' . get_field('info', $id) . '</p>' : '';
$time = get_field('time', $id) ? '<p class="time">' . get_field('time', $id) . '</p>' : '';
$info_time_block = "<div class='info-time'>{$info}{$time}</div>";


$video = get_field('video', $id);
$slides = get_field('slides', $id);
$excerpt = get_the_excerpt($id) ? '<p>' . get_the_excerpt($id) . '</p>' : '';
$title = get_the_title() ? '<h1>' . get_the_title() . '</h1>' : '';
$realists = get_field('realists');
$contractors = get_field('contractors');
$content = trim(get_the_content(get_the_ID()));
$content = empty($content) ? get_field('show')->post_content : '';
$current_day = date_i18n('Y-m-d');
$content = apply_filters('the_content', $content);

$parmas_array = [];
$parmas_array['show_id'] = $id;
$parmas_array['datefrom'] = $current_day;
$params_str = http_build_query($parmas_array);
$performances = file_get_contents(get_site_url() . '/wp-json/teatr_muzyczny/v1/performances?' . $params_str);
$performances = json_decode($performances);
$upcom = '';
if (!empty($performances)) {
	$upcom = '<section class="upcoming">
							<div class="container">
								<h3>Najbliższe spektakle</h3>
								<div class="upcoming__items">';


	foreach ($performances as $key => $performance) {
		foreach ($performance as $key => $perf) {
			$date = date('d.m.Y', strtotime($perf->date_time));
			$day = __(date('l', strtotime($perf->date_time)));
			$performance_time = date('H:i', strtotime($perf->date_time));
			$tiket = !empty($perf->buy) ? "<a class='btn' href='{$perf->buy}' target='_blank' rel='noopener noreferrer'>Kup bilet</a>" : '';
			$upcom .= "<div class='upcoming__items_item'>
										<div class='upcoming__items_item-wrap'>
											<div class='upcoming__items_item-date'>{$date}</div>
											<div class='upcoming__items_item-day'>{$day}</div>
											<div class='upcoming__items_item-time'>{$performance_time}</div>
											<div class='upcoming__items_item-title'>{$perf->show_title}</div>
											</div>
											<div class='upcoming__items_item-wrap_buy'>
												{$tiket}
										</div>
									</div>";
		}
	}
	$upcom .= '		</div>
							</div>
						</section>';
} ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php echo do_shortcode('[search_nav]'); ?>
	<div class="container">
		<div class="top_info">
			<?php
			if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<nav class="breadcrumbs-nav top_info__left">
					<p id="breadcrumbs">', '</p>
				</nav>');
			}
			echo '<div class="top_info__right">' . $title . $info_time_block . $excerpt . '</div>';
			?>
		</div>

		<div class="info-content" id="cast">
			<div class="info-content__people">
				<?php
				if ($realists || $contractors) {
					echo '<h3>Realizatorzy:</h3>';
					$line_content = '<ul>';
					if ($realists) foreach ($realists as $key => $realist) {
						$people = $realist['people'];
						$line_content .= '<li><p><span>' . $realist["title"] . '</span>';
						foreach ($people as $key => $individual) {
							$person = $individual["person"];
							$preson_name = $individual["person"] !== false ? $person->post_title : $individual["person_text"];
							$person_link = get_permalink($person->ID);
							$link = $person->ID ?  "<a href='{$person_link}'>" . $preson_name . "</a>" : $preson_name;
							$line_content .= $link . '<br>';
						}
						$line_content .= '</p></li>';
					}
					$line_content .= '</ul>';
					echo 	$line_content;
					echo '<h3>Wykonawcy:</h3>';
					$line_content_actors = '<ul>';
					if ($contractors) foreach ($contractors as $key => $contractor) {
						$role = $contractor['title'];
						$line_content_actors .= '<li><p><span>' . $role . '/</span>';
						$preson_con = $contractor["people"];
						foreach ($preson_con as $key => $person) {
							$actor = $person["person"];
							$actor_name = $actor !== false ? $actor->post_title : $person["person_text"];
							$actor_link = get_permalink($actor->ID);
							$link = $actor->ID ?  "<a href='{$actor_link}'>" . $actor_name . "</a>" : $actor_name;
							$line_content_actors .= $link . '</br>';
						}
					}
					$line_content_actors .= '</p></li></ul>';
					echo 	$line_content_actors;
				}
				?>
			</div>
			<div class="info-content__content">
				<?php
				$image = get_the_post_thumbnail($id)  ?
					get_the_post_thumbnail($id) :
					'<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' alt="alternative_name">';
				echo '<div class="info-content__content_img">' . $image . '</div>';
				echo $content; ?>
			</div>
		</div>
		<?php echo  $upcom; ?>
		<?php if ($video) { ?>
			<div class="video">
				<a class="video__link" href="https://youtu.be/<?php echo $video ?>">
					<picture>
						<source srcset="https://i.ytimg.com/vi_webp/<?php echo $video ?>/maxresdefault.webp" type="image/webp">
						<img class="video__media" src="https://i.ytimg.com/vi/<?php echo $video ?>/maxresdefault.jpg" alt="1. Пилот, разборы, ответы и лайвы">
					</picture>
				</a>
				<button class="video__button" aria-label="Play video">
					<svg width="68" height="48" viewBox="0 0 68 48">
						<path class="video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
						<path class="video__button-icon" d="M 45,24 27,14 27,34"></path>
					</svg>
				</button>
			</div>
		<?php } ?>

		<?php if ($slides) { ?>
			<div class="show__slider">
				<?php
				foreach ($slides as $key => $slide) {
					$slide_image = wp_get_attachment_image($slide['slide'], 'medium-large');
					echo '
					<div class="show__slider_slide slide">
						<div class="slide__img">' . $slide_image . '</div>
					</div>';
				}
				?>
			</div>

		<?php } ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
<?php show_price_perfomance(); ?>