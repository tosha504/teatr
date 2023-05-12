<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */

$info = get_field('info') ? '<p class="position-job">' . get_field('info') .'</p>' : '';
$time = get_field('time') ? '<p>' . get_field('time') .'</p>' : '';
$video = get_field('video') ; 
$slides = get_field('slides') ; 
$excerpt = get_the_excerpt() ? '<p>' . get_the_excerpt() .'</p>' : ''; 
$title = get_the_title() ? '<h1>' . get_the_title() . '</h1>' : ''; 
$realists = get_field('realists') ; 
$contractors = get_field('contractors') ; 
?>


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
				echo '<div class="top_info__right">' . $title . $info . $time . $excerpt .'</div>';
			?>
		</div>
		
		<div class="info-content" id="cast">
			<div class="info-content__people">
				<?php 
					if( $realists || $contractors ){
						echo '<h3>Realizatorzy:</h3>';
					$line_content = '<ul>';
					if ($realists) foreach ($realists as $key => $realist) {
						$people = $realist['people'];
						$line_content .= '<li><p><span>' . $realist["title"] . '/</span>';
						foreach ($people as $key => $individual) {
							$person = $individual["person"];
							$preson_name = $individual["person"] !== false ? $person->post_title : $individual["person_text"];
							$person_link = get_permalink($person->ID);
							$link = $person->ID ?  "<a href='{$person_link}'>" . $preson_name . "</a> &#10230": $preson_name ;
							$line_content .= $link . '</p></li>';
						}					
					}
					$line_content .= '</ul>';
					echo 	$line_content;
					echo '<h3>Wykonawcy:</h3>';
					$line_content_actors = '<ul>';
					if($contractors) foreach ($contractors as $key => $contractor) {
						$role = $contractor['title'];
						$line_content_actors .= '<li><p><span>' . $role . '/</span>';
						$preson_con = $contractor["people"];
						foreach ($preson_con as $key => $person) {
							$actor = $person["person"];
							$actor_name = $actor !== false ? $actor->post_title : $person["person_text"];
							$actor_link = get_permalink($actor->ID);
							$link = $actor->ID ?  "<a href='{$actor_link}'>" . $actor_name . "</a> &#10230": $actor_name ;
							$line_content_actors .= $link .'</br>';
						}	
					}
					$line_content_actors .= '</ul>';
					echo 	$line_content_actors;
					}
				?>
			</div>
			<div class="info-content__content">
			<?php
			$image = get_the_post_thumbnail()  ?
			get_the_post_thumbnail() : 
			'<img src=' .  get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp' . ' alt="alternative_name">';
 			echo '<div class="info-content__content_img">' . $image . '</div>';
			the_content()?>
			</div>
		</div>
		
		<?php if($video) { ?>
			<div class="video">
				<a class="video__link" href="https://youtu.be/<?php echo $video ?>">
						<picture>
							<source srcset="https://i.ytimg.com/vi_webp/<?php echo $video ?>/maxresdefault.webp" type="image/webp">
							<img class="video__media" src="https://i.ytimg.com/vi/<?php echo $video ?>/maxresdefault.jpg" alt="1. Пилот, разборы, ответы и лайвы">
						</picture>
				</a>
				<button class="video__button" aria-label="Play video">
					<svg width="68" height="48" viewBox="0 0 68 48"><path class="video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path><path class="video__button-icon" d="M 45,24 27,14 27,34"></path></svg>
				</button>
			</div>
		<?php } ?>
		
		<?php if($slides) { ?>
			<div class="show__slider">
				<?php
				foreach ($slides as $key => $slide) {
					$image = wp_get_attachment_image($slide['slide'], 'medium-large') ;
					echo '
					<div class="show__slider_slide slide">
						<div class="slide__img">' . $image . '</div>
					</div>';
				}
				?>
			</div>
		<?php } ?>
</article><!-- #post-<?php the_ID(); ?> -->