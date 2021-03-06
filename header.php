<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kuhnian
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'kuhnian' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">

			<?php the_custom_logo(); ?>
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
<!--	Comment out original <button> code and add kuhnian-hamburger class
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
-->
			<button class="menu-toggle kuhnian-hamburger" aria-controls="primary-menu" aria-expanded="false"><span></span></button>
				<!--<?php esc_html_e( 'Primary Menu', 'kuhnian' );?> -->
				<!--<svg class="icon icon-bars" role="img"><title><?phpesc_html_e( 'Primary Menu', 'kuhnian' );?></title> <use href="#icon-bars" xlink:href="#icon-bars"></use></svg>-->
<!-- Comment out static-hamburger code
				<div class="kuhnian-hamburger" title="<?php esc_html_e( 'Primary Menu' );?>">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</button>
-->
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

