<?php
/**
 * Kuhn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kuhnian
 */
 
 locate_template( array( 'inc/kuhnian_setup.php' ), true, true ) ;
 locate_template( array( 'inc/kuhnian_register_fonts.php' ), true, true ) ;

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
// Temporarily disable the customizer.php from Kuhn and replace it
//require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer_kuhnian.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load SVG icon functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Load custom widgets
 */
require get_template_directory() . "/widgets/recent-comments.php";
require get_template_directory() . "/widgets/recent-posts.php";