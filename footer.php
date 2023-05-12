<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package teatr
 */

// PREFOOTER
$pre_footer = get_field( 'pre_footer', 'options' );
$pre_footer_left = $pre_footer['left'];
$pre_footer_right = $pre_footer['right'];

// FOOTER 
$footer = get_field( 'footer', 'options' );
$menu_links = $footer['menu_links'];
$menu_sub_links = $footer['menu_sub_links'];
$footer_contact = $footer['footer_contact'];
$content = $footer['content'];
$logos = $footer["logos"];
$logos_right = $footer['logos_right'];
$content_right = $footer['content_right'];
$image_after = $pre_footer['image_after'];
?>

	<footer id="colophon" class="footer">
		<!-- Newsletter start -->
		<section class="newsletter">
      <div class="container">
        <form class="items">
        <h5>Newsletter</h5>
          <div>
            <p class="title">Zapisz się do newslettera, a nic Cię nie ominie</p>
            <input type="email" placeholder="Twój email*"/>
          </div>
          <div>
          <label>
            <input
              type="checkbox"
              value="option1"
            />
            <span className={styles.checkmark}></span>
           <p>
           wyrażam zgodę na otrzymywanie korespondencji elektronicznej od administratorów strony www.teatr-muzyczny.lodz.pl
           </p>
          </label>
          <label>
            <input
              type="checkbox"
              value="option2"
            />
            <p>
            wyrażam zgodę na otrzymywanie informacji komercyjnych od partnerów Teatru Muzycznego w Łodzi
            </p>
          </label>
          <label>
            <input
              type="checkbox"
              value="option3"
            />
           <p> Zapoznałem/-am się i akceptuję klauzulę, dotyczącą przetwarzania danych osobowych przez Teatr Muzyczny w Łodzi</p>
          </label>
            <input type="submit" value="Zapisz się" />
          </div>
        </form>
      </div>
      <?php if($image_after) echo '<div class="blockImage">' .
        wp_get_attachment_image( $image_after , 'full' )
      .'</div>';?>
    </section>
		<!-- Newsletter end -->

		<!-- Partners start -->
		<section class ="partners">
			<div class="partners__items container">
				<div class="partners__items_item">
					<?php if($pre_footer_left['title']) echo '<h6>' . $pre_footer_left['title'] . '</h6>'; 
					if($pre_footer_left['partners']) {
						echo '<div>';
						foreach ($pre_footer_left['partners'] as $partner) {
							echo '<a href="' . esc_url($partner['link']['url']) . '" target="' . $partner['link']['target'] . '">' . wp_get_attachment_image( $partner['partner'] , 'full' ) .' </a>';
						}
						echo '</div>';
					} ?>
				</div>
				<div class="partners__items_item">
					<?php if($pre_footer_right['title_right']) echo '<h6>' . $pre_footer_right['title_right'] . '</h6>';  
					if($pre_footer_left['partners']) {
						echo '<div>';
						foreach ($pre_footer_right['partners'] as $partner) {
							echo '<a href="' . esc_url($partner['link']['url']) . '" target="' . $partner['link']['target'] . '">' . wp_get_attachment_image( $partner['partner'] , 'full' ) .' </a>';
						}
						echo '</div>';
					} ?>
				</div>        
			</div>
		</section>
		<!-- Partners end -->
		<div class="container">
			<div class="footer__items">
				<div class="footer__items_item">
					<div class="footer__items_itemTop">
					<?php if($menu_links) {?>
						<ul>
						<?php foreach ($menu_links as $link) { ?>
								<li>
									<a href=<?php echo $link['link']['url'] ?>><?php echo $link['link']['title'] ?></a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>		
				
					<?php if($menu_sub_links['menu_sub_links_items']) { ?>
						<ul>
							<?php if($menu_sub_links['title']) ?><h6><?php echo $menu_sub_links['title']; ?></h6>
							<?php foreach ($menu_sub_links['menu_sub_links_items'] as $link) {?>
								<li>
									<a href=<?php echo esc_url($link['link']['url']); ?>><?php echo $link['link']['title']; ?></a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
					</div>
					
					<div class="footer__items_itemBottom">
							<?php  
							if ($logos) foreach ($logos as $logo) {
								echo wp_get_attachment_image( $logo['logo'] , 'full' );
							}
							
							if($content) echo $content; 
							?>
					</div>
				</div>
				
				<div class="footer__items_item">
					<div class="footer__items_itemTop">
					<?php if($footer_contact['title']) ?><h6><?php echo $footer_contact['title']; ?></h6>
						<?php if($footer_contact['shortcode_form']) echo do_shortcode($footer_contact['shortcode_form'])?>
					</div>

					<div class="footer__items_itemBottom">
						<?php  
							if ($logos_right) foreach ($logos_right as $logo) {
								echo wp_get_attachment_image( $logo['logo'] , 'full' );
							}
							if($content_right) echo $content_right; 
						?>
					</div>
				</div>
			</div>
			<p class="copyright"><?php echo $footer['copyright']; ?><a href="https://thenewlook.pl/" target="_blank" rel="noopener noreferrer">THENEWLOOK</a></p>
		</div>
	</footer><!-- #colophon -->

	<div class="cookies">
			<!-- <div class="container"> -->
			<div class="cookies__flex">
				<p>Serwis używa informacji zapisanych za pomocą plików cookie oraz innych rozwiązań informatycznych, pozwalających na dostosowanie treści do potrzeb użytkownika oraz w celach statystycznych.. Jeżeli nie wyrażają Państwo zgody na ich zapisywanie, należy opuścić stronę lub zmienić w przeglądarce ustawienia dotyczące cookies. Szczegółowe informacje można znaleźć w naszej <a href="http://" target="_blank" rel="noopener noreferrer"> polityce cookies</a> .</p>	
				<a href="javascript:;"  class="cookies__btn btn submit">Akceptuję</a>
				<!-- </div> -->
		</div><!-- cookies -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
