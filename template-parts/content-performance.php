<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teatr
 */
$id = get_field('show')->ID;
$info = get_field('info', $id) ? '<p class="position-job">' . get_field('info', $id) .'</p>' : '';
$time = get_field('time', $id) ? '<p>' . get_field('time', $id) .'</p>' : '';
$video = get_field('video', $id) ; 
$slides = get_field('slides', $id) ; 
$excerpt = get_the_excerpt($id) ? '<p>' . get_the_excerpt($id) .'</p>' : ''; 
$title = get_the_title() ? '<h1>' . get_the_title() . '</h1>' : ''; 
$realists = get_field('realists') ; 
$contractors = get_field('contractors') ; 
$content = trim(get_the_content(get_the_ID()));
$content = empty($content) ? get_field('show')->post_content : '';
$content = apply_filters( 'the_content', $content );
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
							$line_content .= $preson_name . '</p></li>';
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
							$line_content_actors .= $actor_name . '</p></li>';
						}	
					}
					$line_content_actors .= '</ul>';
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
			 echo $content;?>
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
					$slide_image = wp_get_attachment_image($slide['slide'], 'medium-large') ;
					echo '
					<div class="show__slider_slide slide">
						<div class="slide__img">' . $slide_image . '</div>
					</div>';
				}
				?>
			</div>
		<?php } ?>
</article><!-- #post-<?php the_ID(); ?> -->