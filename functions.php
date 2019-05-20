<?php
/**
 * Kuhn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kuhn
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
	 * to change 'kuhn' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kuhn', get_template_directory() . '/languages' );

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
	add_image_size( 'kuhn-index', 966, 555, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'kuhn' ),
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
/*	Create theme option re whether to display featured image on single posts */
/*	Valid values: 'display' 'hide'  */
/*	add_option ('display_featured_image_on_single_posts', 'display', '', 'yes');*/
	update_option ('kuhnian_display_featured_image_on_single_posts', 'hide'); 
/*	update_option ('kuhnian_display_featured_image_on_single_posts', 'display'); */
/*	update_option ('kuhnian_display_featured_image_on_single_posts', 'elephantitis');*/

add_action( 'admin_head' , 'kuhnian_check_settings_validity');

function kuhnian_check_settings_validity() {
/*	Upon entering wp-admin page, check whether 'kuhnian_display_featured_image_on_single_posts'
	has legal value; viz., 'display' or 'hide'
	
	In all cases, put a message at the top of the admin page re validity of value:
		Warning if value is invalid; State the default

	This function assumes that it is hooked to the 'admin_head' action, which is executed 
	in the HTML <head> section of the admin panel. see
		https://adambrown.info/p/wp_hooks/hook/admin_head
*/
	$css_class_prefix = 'notice ' ;
	$css_class_suffix = ' kuhnian-notice' ;

/*	Get value of option 'kuhnian_display_featured_image_on_single_posts' */
	$kuhnian_display_featured_image_on_posts =
		get_option('kuhnian_display_featured_image_on_single_posts','OOPS!') ;
/*	Check validity of value of option 'kuhnian_display_featured_image_on_single_posts' */
	if ( $kuhnian_display_featured_image_on_posts == 'display' )
	{
		$alert_content = 	"Featured image <em>will</em> be displayed on post pages <br/> " .
							"Supplied value: '$kuhnian_display_featured_image_on_posts'." ;
		$cssclass = 'notice-info' ;
/*		kuhnian_generic_admin_alert( $cssclass, $alert_content ) ; */
	}
	elseif ( $kuhnian_display_featured_image_on_posts == 'hide' )
	{
		$alert_content = 	"Featured image will <em>not</em> be displayed on post pages <br/> " .
							"Supplied value: '$kuhnian_display_featured_image_on_posts'." ;
		$cssclass = 'notice-info' ;
/*		kuhnian_generic_admin_alert( $cssclass, $alert_content ) ; */
	}
	else
	{
		$alert_content = 	"Invalid preference for whether featured image should be displayed on post pages. <br/>" .
							"Supplied value: '$kuhnian_display_featured_image_on_posts'. <br/>" .
							"Value should be either (a) 'display' or (b) 'hide'. <br/>" .
							'Defaults to: Featured image will <em>not</em> be displayed on post pages.' ;
		$cssclass = 'notice-warning' ;
/*		kuhnian_generic_admin_alert( $cssclass, $alert_content ) ;	*/
	}
	$css_class_composite = "$css_class_prefix" . "$cssclass" . "$css_class_suffix" ;
	kuhnian_generic_alert( $css_class_composite, $alert_content ) ;
}

function kuhnian_generic_alert($cssclass,$content) {
/*	Issues admin alert with CSS classes .notice and .kuhnian-notice as well as the additional
	CSS class specified in argument $cssclass. (E.g., $cssclass='notice-warning')
	The content of the alert is contained in $content.
	This function will wrap $content (a) first, within _e()  and (b) second within <p> </p>
*/
	$prefix = 'kuhnian' ;
	$css_class_for_theme_admin_notices = 'kuhnian-notice';
/*	Construct string of CSS classes for alert */
	$css_classes_for_notice = "notice $css_class_for_theme_admin_notices $cssclass";
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
function kuhn_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kuhn_content_width', 640 );
}
add_action( 'after_setup_theme', 'kuhn_content_width', 0 );


/**
 * Register custom fonts.
 */
function kuhn_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Rubik and Roboto Mono translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$rubik = _x( 'on', 'Rubik font: on or off', 'kuhn' );
	$roboto_mono = _x( 'on', 'Roboto Mono font: on or off', 'kuhn' );
	$slabo = _x( 'on', 'Slabo 27px font: on or off', 'kuhn' );

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
function kuhn_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'kuhn-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'kuhn_resource_hints', 10, 2 );



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
function kuhn_content_image_sizes_attr( $sizes, $size ) {
	if ( is_singular() ) {
		$width = $size[0];
		if ( 610 <= $width ) {
			$sizes = '(min-width: 990px) 720px, (min-width: 1300px) 610px, 95vw';
		}
		return $sizes;
	}
}
add_filter( 'wp_calculate_image_sizes', 'kuhn_content_image_sizes_attr', 10, 2 );


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
function kuhn_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_singular() ) {
		$attr['sizes'] = '(min-width: 990px) 720px, (min-width: 1300px) 820px, 95vw';
	} else {
		$attr['sizes'] = '(min-width: 990px) 955px, (min-width: 1300px) 966px, 95vw';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'kuhn_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kuhn_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kuhn' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kuhn' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kuhn_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function kuhn_scripts() {
	// Enqueue Google Fonts:
	wp_enqueue_style( 'kuhn-fonts', kuhn_fonts_url() );

	wp_enqueue_style( 'kuhn-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kuhn-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
	wp_localize_script( 'kuhn-navigation', 'kuhnScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'kuhn'),
		'collapse' => __( 'Collapse child menu', 'kuhn'),
	));

	wp_enqueue_script( 'kuhn-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20161201', true );

	wp_enqueue_script( 'kuhn-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kuhn_scripts' );

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
