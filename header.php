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
		