<?php
/**
 * To be included by functions.php via locate_template().
 *
 * @package Kuhnian
 */
/**
 * Register custom fonts.
 */

/*	For reasons that remain inexplicable, I could not successfully add "Open Sans" or any
	additional Google fonts to the below function kuhnian_fonts_url(). (When I added the
	additional machinery, the new font failed to be loaded by the document.)
	
	Thus, at least for now, I add Noto Sans (my updated choice for menu font) as a
	standalone fetch.
*/
if ( ! function_exists ( 'kuhnian_additional_fonts_url' ) ) :
	function kuhnian_additional_fonts_url() {
		$fonts_url = 'https://fonts.googleapis.com/css?family=Noto+Sans:700' ;
		$escaped_fonts_url = esc_url_raw( $fonts_url );
		return $escaped_fonts_url ;
	}
endif;


if ( ! function_exists ( 'kuhnian_fonts_url' ) ) :
	function kuhnian_fonts_url() {
		$fonts_url = '';
	
/*	My maximal desires:
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i|PT+Mono|PT+Sans&display=swap&subset=latin-ext" rel="stylesheet">
*/

/**
* Translators: If there are characters in your language that are not
* supported by Rubik and Roboto Mono translate this to 'off'. Do not translate
* into your own language.
*/
/*		$rubik = _x( 'on', 'Rubik font: on or off', 'kuhnian' );
		$roboto_mono = _x( 'on', 'Roboto Mono font: on or off', 'kuhnian' );
		$slabo = _x( 'on', 'Slabo 27px font: on or off', 'kuhnian' );
*/

		$use_font_lora		= _x( 'on', 'Lora font: on or off' );
		$use_font_PT_mono	= _x( 'on', 'PT Mono font: on or off' );
		$use_font_PT_sans	= _x( 'on', 'PT Sans font: on or off' );

		$font_families = array();
//		Correcting nonfatal logic error in original Kuhn font:
//			The below tests check whether flag is NOT "off", but later check follows 
//			to load the fonts only if one of the switches is actually "on"
		$at_least_one_font_to_load = false ;

		if ( 'off' !== $use_font_lora ) {
			$font_families[] = 'Lora:400,400i,700,700i';
			$at_least_one_font_to_load = true ;
		}

		if ( 'off' !== $use_font_PT_mono ) {
			$font_families[] = 'PT+Mono';
			$at_least_one_font_to_load = true ;
		}

		if ( 'off' !== $use_font_PT_sans ) {
			$font_families[] = 'PT+Sans';
		}		
			$at_least_one_font_to_load = true ;
		

//		Corrects nonfatal logic error
		if ( $at_least_one_font_to_load ) {
//		if ( in_array( 'on', array( $use_font_lora, $use_font_PT_mono, $use_font_PT_sans ) ) ) {

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
 /*	See Kirsten Cassidy, "Understanding and Using Resource Hinting in WordPress 4.6,"
 	September 11, 2016, https://www.kirstencassidy.com/understanding-using-resource-hinting/
 */
function kuhnian_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'kuhnian-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'kuhnian_resource_hints', 10, 2 );