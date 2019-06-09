<?php
/**
 * Kuhn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kuhnian
 */
 
 locate_template( array( 'inc/kuhnian_setup.php' ), true, true ) ;
// locate_template( array( 'inc/kuhnian_error_processing.php' ), true, true ) ;
 locate_template( array( 'inc/kuhnian_register_fonts.php' ), true, true ) ;
// locate_template( array( 'inc/kuhnian_create_theme_options_page.php' ), true, true ) ;
// locate_template( array( 'inc/kuhnian_create_theme_options_page_Arshad.php' ), true, true ) ;
// locate_template( array( 'inc/arshad_verbatim_code.php' ), true, true ) ;
// locate_template( array( 'inc/theme_page_aj_clarke.php' ), true, true ) ;
// locate_template( array( 'inc/Anna_Johansson_verbatim_code.php' ), true, true ) ;
// locate_template( array( 'inc/Matthew_Ray_options_page.php' ), true, true ) ;

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
require get_template_directory() . '/inc/customizer.php';

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

/*	Add custom CSS to admin area 
	See https://css-tricks.com/snippets/wordpress/apply-custom-css-to-admin-area/
	See https://davidwalsh.name/add-custom-css-wordpress-admin
*/
// add_action('admin_head', 'kuhnian_custom_CSS_for_admin_area');
// 
// function kuhnian_custom_CSS_for_admin_area() {
//   echo '<style>
// 	p.zzyzx-settings-section-pre-input-text {
// 		color: red ;
//     } 
//   </style>';
// }
