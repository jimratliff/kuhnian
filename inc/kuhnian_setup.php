<?php
/**
 * To be included by functions.php via locate_template().
 *
 * @package Kuhnian
 */
/*
	function kuhnian_setup()
		Sets up theme defaults and registers support for various WordPress features.
		Make theme available for translation.
		Add default posts and comments RSS feed links to head.
		Let WordPress manage the document title.
		Enable support for Post Thumbnails on posts and pages.
		This theme uses wp_nav_menu() in one location.
		Output valid HTML5 on search form, comment form, and comments.
		Add theme support for Custom Logo.
		Add theme support for selective refresh for widgets.
	function kuhnian_content_width()
		Set the content width in pixels, based on the theme's design and stylesheet.
	function kuhnian_content_image_sizes_attr
		Add custom image sizes attribute to enhance responsive image functionality for content images.
	function kuhnian_post_thumbnail_sizes_attr
		Add custom image sizes attribute to enhance responsive image functionality for post thumbnails.
	function kuhnian_widgets_init()
		Register widget area.
	function kuhnian_scripts()
		Enqueue scripts and styles.
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
//	Makes separate query to load additional fonts because I inexplicably failed to add
//		using function kuhnian_fonts_url() 
	wp_enqueue_style( 'kuhnian-additional-fonts', kuhnian_additional_fonts_url() );
	

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