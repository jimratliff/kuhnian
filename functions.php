<?php
/**
 * Kuhn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kuhnian
 */

if ( ! function_exists( 'kuhnian_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kuhnian_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Kuhn, use a find and replace
	 * to change 'kuhnian' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kuhnian', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'kuhnian-index', 966, 555, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'kuhnian' ),
		'social' => esc_html__( 'Social Media Menu', 'hume' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo
	add_theme_support( 'custom-logo', array(
		'width' => 250,
		'height' => 250,
		'flex-width' => false,
	));

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'kuhnian_setup' );

/***************	BEGIN JDR Additions ***************/
/*	Kluge to delete, ONCE, the option array in the database in order to store new defaults.
	Uncomment this only once; then re-comment it */
//	delete_option( 'kuhnian_theme_options' ) ;
//	kuhnian_update_one_option ( 'error_message_for_admin' , '' );
//	kuhnian_update_one_option ( 'has_previously_overflowed' , 'no' );  
//	kuhnian_initialize_options();

/*	Implements options as an array */
/*	Uses add_option() to add option array as a single row to database.
	Note: add_option() has no effect if the option already exists, so this function has no effect once the options are created.
*/
function kuhnian_initialize_options(){
	$kuhnian_default_options = array(
		'display_featured_image_on_posts'			=>	'hide'						, 
		'character_between_categories'				=>	' '							,
		'error_message_for_admin'					=>	''							,
		'max_length_error_message_for_admin'		=>	250							,
		'error_message_to_admin_already_overflowed'	=>	'no'						,
		'overflow_message'							=>	'ERROR MESSAGE OVERFLOW…'	,
	);
	update_option('kuhnian_theme_options' , $kuhnian_default_options ); 
/*	kuhnian_report_options() ; */
}

function kuhnian_report_options() {
	echo "Inside kuhnian_report_options(). <br/>" ;
	$theme_options = get_option( 'kuhnian_theme_options' ) ;
	if ( !$theme_options ) {
		echo "I couldn't find the options. <br/>" ;
	}	else {
		var_dump( $theme_options ) ;
	}
}

function kuhnian_get_theme_options() {
/*	Returns kuhnian theme options as array.
	If the options have not previously been created in the database, they will be created now via call to kuhnian_initilize_options().
	Usage:		$somearray = kuhnian_get_theme_options() ;
				$display_featured_image = $somearray['display_featured_image_on_posts'] ;
				$character betweens cats = $somearray['character_between_categories'] ;
				$error_message = $somearray['error_message_for_admin'] ;
*/
	$kuhnian_options = get_option('kuhnian_theme_options') ;
/*	If get_option was not successful (presumably because the database didn't contain the option array), create the option array in the database with kuhnian_initialize_options()
*/
	if ( !$kuhnian_options ) {
		kuhnian_initialize_options() ;
	}
	return $kuhnian_options ;
}

function kuhnian_update_theme_options( $themeoptions ) {
/*	Replaces theme options with contents of array $themeoptions */
/*	NOTE: You must replace ALL components of the option array */
	update_option( 'kuhnian_theme_options' , $themeoptions ) ;
}

function kuhnian_update_one_option ( $optionName , $optionValue ) {
	$kuhnian_options = get_option('kuhnian_theme_options') ;
	$kuhnian_options[ $optionName] = $optionValue ;
	update_option( 'kuhnian_theme_options' , $kuhnian_options ) ;
}

function kuhnian_boolean_display_featured_image_on_posts() {
/*	Converts option 'display_featured_image_on_posts' to a Boolean, i.e., 
	equals TRUE (1) iff 'display_featured_image_on_posts' == 'display'
*/
	kuhnian_update_one_option ( 'error_message_for_admin' , '' );
	kuhnian_issue_test_errors() ; 
	$theme_options = kuhnian_get_theme_options() ;
	var_dump($theme_options);
	if ( $theme_options['display_featured_image_on_posts'] == 'display' ) {
		return 1 ;
	} else {
		return 0 ;
	}
	return 0 ;
}

function kuhnian_issue_test_errors() {
/*	This function exists solely to test the error-reporting functions.
	It is always called, so comment out any messages you don't want to be sent.
*/
	kuhnian_append_to_error_message( 'Here is a first error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a second error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a third error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a fourth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a fifth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a sixth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a seventh error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a eighth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a ninth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a tenth error to append.' ) ;
	kuhnian_append_to_error_message( 'Here is a eleventh error to append.' ) ;
}

function kuhnian_append_to_error_message( $messageToAppend ) {
/*	Append argument to cumulative error message that's stored as an element of the option array.
	A <br/> is automatically appended after each message is appended.
	If the existing contents of the error message are longer than a threshold maximum, the new entry is not added to the error message.
	The first time, and only the first time, this function is called when the existing error message is too long, an overflow-warning message is added to the error message.
*/
/*	Get current error message, maximum allowed length for that error message, and whether it previously overflowed.  */
	$theme_options				= kuhnian_get_theme_options() ;
	$currentErrorMessage		= $theme_options['error_message_for_admin'] ;
	$maxLength					= $theme_options['max_length_error_message_for_admin'] ;
	$has_previously_overflowed 	= $theme_options['error_message_to_admin_already_overflowed'] ;
	$overflowMessage			= $theme_options['overflow_message'] ;
	
	$lengthCurrentErrorMessage	= strlen( $currentErrorMessage ) ;

	echo "++++++++++++++++++++++++++++++++ <br/>";
	echo "Entering function kuhnian_append_to_error_message(): <br/>" ;
	echo "Argument: $messageToAppend <br/>" ;
	echo "Cumulative: $currentErrorMessage <br/>" ;

	echo "Length: $lengthCurrentErrorMessage <br/>";
	echo "Has previously overflowed: $has_previously_overflowed <br/>" ;
	echo " *  *  *  *  *  *  *  *  * <br/>";
	if ( $has_previously_overflowed == 'no' ) {
		if ( $lengthCurrentErrorMessage <= $maxLength) {
			echo "length < threshold: $lengthCurrentErrorMessage, $maxLength <br/>" ;
/*			If current error message's length doesn't already exceed the maximum, append new message */
/*			(Thus the "maximum" may be exceeded, but by at most one new message.) */
			$newErrorMessage = $currentErrorMessage . $messageToAppend . '<br/>'   ;
		}
		else {
/*			Current error message exceeds length limit: Append overflow message. */	
			$newErrorMessage = $currentErrorMessage . $overflowMessage . '<br/>'   ;
//			Acknowledge overflow of error message
			$theme_options['has_previously_overflowed'] = 'nope'  ;
			echo "OVERFLOW!! length > threshold: $lengthCurrentErrorMessage, $maxLength <br/>" ;
			echo "OVERFLOW!! Overflow message: $overflowMessage <br/>" ;
			echo "OVERFLOW!! newErrorMessage: $newErrorMessage <br/>" ;
		}
/*		Update error message in database. */
		$theme_options['error_message_for_admin'] = $newErrorMessage ;
		$length_of_new_error_message=strlen($newErrorMessage);
		echo "length of newErrorMessage: $length_of_new_error_message ";
		echo "newErrorMessage: $newErrorMessage";
		kuhnian_update_theme_options( $theme_options ) ;
	}
	else {
/*			If error message has previously overflowed, exit without doing anything */
		echo "Doing nutin' because I've already overflowed. <br/>" ;
	}
	echo "Leaving function kuhnian_append_to_error_message(). <br/> --------------------------------------- <br/>" ;
}

function kuhnian_clear_error_message() {
/*	Empties cumulative error message */
	$theme_options = kuhnian_get_theme_options() ;
	$theme_options['error_message_for_admin'] = '' ;
	$theme_options['error_message_to_admin_already_overflowed'] = 'no' ;
	kuhnian_update_theme_options( $themeoptions ) ;
}

function kuhnian_get_error_message() {
/*	Retrieve cumulative error message
	Usage:		$currentErrorMessage = kuhnian_get_error_message() ;
*/
	$theme_options = kuhnian_get_theme_options() ;
	$currentErrorMessage = $theme_options['error_message_for_admin'] ;
	return $currentErrorMessage ;
}

function kuhnian_echo_error_message() {
/*	Echos cumulative error message */
	$currentErrorMessage = kuhnian_get_error_message() ;
	echo "$currentErrorMessage <br/>" ;
}

add_action( 'admin_head' , 'kuhnian_report_errors_to_admin');
function kuhnian_report_errors_to_admin() {
/*	Reports the accumulated error message via an Admin Notice in the admin panel.
		See Jeff Starr, "Complete Guide to WordPress Admin Notices," Digging Into WordPress, Feb. 3, 2017,
		https://digwp.com/2016/05/wordpress-admin-notices/
		See also https://www.wpbeginner.com/wp-tutorials/how-to-add-admin-notices-in-wordpress/
	This function assumes that it is hooked to the 'admin_head' action, which is executed 
	in the HTML <head> section of the admin panel. see
		https://adambrown.info/p/wp_hooks/hook/admin_head
*/
/*	$reportOnlyIfError is a preference:
		If true (1), issue no notice if there's nothing to report.
		If false (0), if there's nothing to report, say so.
*/
	$reportOnlyIfError = 0 ;

/*	Get current error message */
	$theme_options = get_option('kuhnian_theme_options') ;
	$currentErrorMessage = $theme_options['error_message_for_admin'] ;
	var_dump( $theme_options ) ;
	
/*	$currentErrorMessage = kuhnian_get_error_message() ; */
	

	if ( $currentErrorMessage == '' ) {
/*		If cumulative error message is empty, check boolean $reportOnlyIfError  */
		if ( !$reportOnlyIfError ) {
/*			If not $reportOnlyIfError, then issue info dialog box saying there are no errors. */
			$alert_content = 'No errors to report!' ;
			kuhnian_generic_alert( 'notice-info', $alert_content ) ;		
		} else {
/*			Do nothing */			
		}
	} else {
/*		If cumulative error message is nonempty, issue warning dialog box with the error message */
		$alert_content = 'One or more errors to report: <br/>' . $currentErrorMessage ;
		kuhnian_generic_alert( 'notice-warning', $alert_content ) ;
	}

}

function kuhnian_generic_alert($additionalCSSclass,$content) {
/*	Issues admin alert with CSS classes .notice and .kuhnian-notice as well as the additional
	CSS class specified in argument $additionalCSSclass. (E.g., $additionalCSSclass='notice-warning')
	The content of the alert is contained in $content.
	This function will wrap $content (a) first, within _e()  and (b) second within <p> </p>
*/
	$theme_specific_css_class_admin_notices = 'kuhnian-notice';
/*	Construct string of CSS classes for alert */
	$css_classes_for_notice = "notice $additionalCSSclass $theme_specific_css_class_admin_notices";
	?>
		<div class="<?php echo $css_classes_for_notice ?>">
			<p><?php _e("$content"); ?></p>
		</div>
	<?php
}

/*	Add CSS directly into admin-panel head */
/*	See https://www.engagewp.com/edit-wordpress-admin-css/ */
/*	Provides formatting for admin alerts generated by this theme */
add_action( 'admin_head' , 'kuhnian_custom_css_for_admin_panel' ) ;
function kuhnian_custom_css_for_admin_panel() {
	?>
	<style>
		div.kuhnian-notice {
/*			max-width: 500px ;	*/
		}
		div.kuhnian-notice p {
			font-size: 1.25em ;
		}
		div.kuhnian-notice.notice-warning p {
			color: red ;
		}
		div.kuhnian-notice p:before {
			content: "Kuhnian Theme options notice" ;
			display: block ;
			font-size: 1.5em ;
			font-style: bold ;
			color: white ;
			background-color: #00a0d2;
			padding: 0.5em ;
		}
	</style>
<?php }

/***************	END JDR Additions ***************/

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kuhnian_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kuhnian_content_width', 640 );
}
add_action( 'after_setup_theme', 'kuhnian_content_width', 0 );


/**
 * Register custom fonts.
 */
function kuhnian_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Rubik and Roboto Mono translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$rubik = _x( 'on', 'Rubik font: on or off', 'kuhnian' );
	$roboto_mono = _x( 'on', 'Roboto Mono font: on or off', 'kuhnian' );
	$slabo = _x( 'on', 'Slabo 27px font: on or off', 'kuhnian' );

	$font_families = array();

	if ( 'off' !== $rubik ) {
		$font_families[] = 'Rubik:300,300i,400,400i';
	}

	if ( 'off' !== $roboto_mono ) {
		$font_families[] = 'Roboto Mono:400,400i,700,700i';
	}

	if ( in_array( 'on', array($rubik, $roboto_mono) ) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
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



/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function kuhnian_content_image_sizes_attr( $sizes, $size ) {
	if ( is_singular() ) {
		$width = $size[0];
		if ( 610 <= $width ) {
			$sizes = '(min-width: 990px) 720px, (min-width: 1300px) 610px, 95vw';
		}
		return $sizes;
	}
}
add_filter( 'wp_calculate_image_sizes', 'kuhnian_content_image_sizes_attr', 10, 2 );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function kuhnian_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_singular() ) {
		$attr['sizes'] = '(min-width: 990px) 720px, (min-width: 1300px) 820px, 95vw';
	} else {
		$attr['sizes'] = '(min-width: 990px) 955px, (min-width: 1300px) 966px, 95vw';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'kuhnian_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kuhnian_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kuhnian' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kuhnian' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kuhnian_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function kuhnian_scripts() {
	// Enqueue Google Fonts:
	wp_enqueue_style( 'kuhnian-fonts', kuhnian_fonts_url() );

	wp_enqueue_style( 'kuhnian-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kuhnian-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
	wp_localize_script( 'kuhnian-navigation', 'kuhnScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'kuhnian'),
		'collapse' => __( 'Collapse child menu', 'kuhnian'),
	));

	wp_enqueue_script( 'kuhnian-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20161201', true );

	wp_enqueue_script( 'kuhnian-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kuhnian_scripts' );

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
