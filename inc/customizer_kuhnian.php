<?php
/*	Enables Customizer for modifying theme-specific modifications for Kuhnian, above and
	beyond what is enabled by the Kuhn-provided file customizer.php
	
	The approach in this file does NOT define an OOP class. Although there are many
	examples of defining a class for using Customizer, it's not clear to me why that is 
	appropriate. (The Customizer object, $wp_customizer, IS a class object of course.)
	
	In particular, there is a dogma that the constructor should not do any work. However,
	in all the examples I've seen, the constructor does ALL the work! I.e., the class is 
	instantiated only once, that triggers the constructor, which then performs an
	add_action('customize_register','someFunction()'), which then does everything.

	Draws upon:
	Rachel McCollin, "WordPress Development for Intermediate Users: Making Your Themes
		Customizer-Ready," WPMU DEV, October 15, 2017,
		https://premium.wpmudev.org/blog/wordpress-development-for-intermediate-users-making-your-themes-customizer-ready/
	Ashley Gibson, "Tutorial: Using the Customizer to Add Settings to Your WordPress Theme,"
		Nose Graze, May 2, 2016, https://www.nosegraze.com/customizer-settings-wordpress-theme/

	Note: Per https://developer.wordpress.org/themes/customize-api/customizer-objects/#panels
		"THEMES SHOULD NOT REGISTER THEIR OWN PANELS IN MOST CASES. Sections do not need
		to be nested under a panel, and each section should generally contain multiple
		controls. Controls should also be added to the Sections that core provides, such as
		adding color options to the colors Section.… Panels are designed as contexts for
		entire features such as Widgets, Menus, or Posts, not as wrappers for generic sections."
	I.e., my implementation below is a violation of this guidance.

*/

add_action( 'customize_register' , 'kuhnian_customize_register' ) ;
function kuhnian_customize_register( $wp_customize ) {
//	Initialize strings and arrays used later as arguments to Customizer methods
	$threshold_capability			= 'edit_theme_options'	; // User level required to set options
	$type_of_option_or_theme_mod	= 'theme_mod'			; // 'theme_mod' or 'option'

//		Panel (Kuhnian Theme Customizer panel)
	$id_panel						= 'kuhnian_panel'									;
	$title_panel					= esc_attr__( 'Kuhnian Theme' )						; 
	$description_panel				= esc_attr__( 'Settings specific to Kuhnian Theme' );

	$property_array_panel = array(
		'title'			=> $title_panel			,
		'description'	=> $description_panel	,
		) ;

//		Section: General
	$id_section_general				= 'id_section_general'										;
	$title_section_general			= esc_attr__( 'General Settings' )									;
	$description_section_general	= esc_attr__( 'Settings that don\'t fall in any other category' )	;

	$property_array_section_general = array(
		'title'			=> $title_section_general		,
		'description'	=> $description_section_general	,
		'panel'			=> $id_panel					,
		'capability'	=> $threshold_capability	,
		) ;

//		Setting/Control: Always show featured image at top of post's page
//			Setting
	$id_setting_always_show_featured_image_in_post					= return_id_setting_always_show_featured_image_in_post()	;
	$default_setting_always_show_featured_image_in_post				= false														;
	$callback_sanitize_setting_always_show_featured_image_in_post	= 'kuhnian_sanitize_checkbox'								;

	$property_array_setting_always_show_featured_image_in_post		= array(
		'default'			=> $default_setting_always_show_featured_image_in_post				, // default value for checkbox variable
		'sanitize_callback'	=> $callback_sanitize_setting_always_show_featured_image_in_post	,  // Makes sure only true/false
		'capability'		=> $threshold_capability											,
		'type'				=> $type_of_option_or_theme_mod										,
		) ;
//			Control
	$label_control_always_show_featured_image_in_post 		=
		esc_attr__( 'Always show featured image at top of post\'s dedicated page' )							;
	$description_control_always_show_featured_image_in_post	=
		esc_attr__( 'A post\'s featured image will appear on blogroll/archive/front pages in any case' )	;

	$property_array_control_always_show_featured_image_in_post = array(
		'type'			=>	'checkbox'												,
		'label'			=>	$label_control_always_show_featured_image_in_post		,
		'description'	=>	$description_control_always_show_featured_image_in_post	,
		'section'		=>	$id_section_general										,
//		'priority'		=>	10														,
		'capability'	=> $threshold_capability									,
		) ;

//		Setting/Control: Character to separate categories when post has multiple categories
//			Setting
	$id_setting_character_separate_categories					= return_id_character_separate_categories()	;
	$default_setting_character_separate_categories				= 'space'									;
	$callback_sanitize_setting_character_separate_categories	= 'sanitize_text_field'						;

	$property_array_setting_character_separate_categories		= array(
		'default'			=> $default_setting_character_separate_categories			, 
		'sanitize_callback'	=> $callback_sanitize_setting_character_separate_categories	, 
		'capability'		=> $threshold_capability									,
		'type'				=> $type_of_option_or_theme_mod								,
		) ;
//			Control
	$label_control_character_separate_categories		=
		esc_attr__( 'Category-separation character' )					;
	$description_control_character_separate_categories	=
		esc_attr__( 'Separates multiple categories in "meta" line' )	;

	$choices_array_control_character_separate_categories	= array(
//		Note: the right-hand strings need to be translatable
		'space'		=> esc_attr__('Space (\'␣\') (e.g., separates rectangles)')		,
		'comma'		=> esc_attr__('Comma-space (\',␣\')')							,
		'diamond'	=> esc_attr__('Diamond (\'␣◆␣\')')								,
		'empty'		=> esc_attr__('Empty (produces unordered list, i.e., \'<ul>\')'),
		) ;

	$property_array_control_character_separate_categories	= array(
		'type'			=> 'select'												,
		'label'			=> $label_control_character_separate_categories			,
		'description'	=> $description_control_character_separate_categories	,
		'choices'		=> $choices_array_control_character_separate_categories	,
		'section'		=> $id_section_general									,
//		'priority'		=> 10													,
		'capability'	=> $threshold_capability								,
		) ;

//	Call methods to implement Customizer panel
//	Add main panel for theme modifications
	$wp_customize->add_panel(
		$id_panel,
		$property_array_panel
		) ;

//	Add General section
	$wp_customize->add_section(
		$id_section_general ,
		$property_array_section_general
		) ;

//	Add setting/control whether to display featured image on each blog post's page
	$wp_customize->add_setting(
		$id_setting_always_show_featured_image_in_post ,
		$property_array_setting_always_show_featured_image_in_post
		) ;

	$wp_customize->add_control(
		$id_setting_always_show_featured_image_in_post ,
		$property_array_control_always_show_featured_image_in_post
		) ;

//	Add setting/control for character to separate multiple category names in meta line
	$wp_customize->add_setting(
		$id_setting_character_separate_categories ,
		$property_array_setting_character_separate_categories
		) ;

	$wp_customize->add_control(
		$id_setting_character_separate_categories ,
		$property_array_control_character_separate_categories
		) ;


} // End kuhnian_customize_register()

//	Sanitizes checkbox response by coercing it to be either true or false
//		If true, returns true; otherwise, returns false
function kuhnian_sanitize_checkbox( $input ) {

	return ( $input === true ) ? true : false ;
}

function kuhnian_return_customizer_entity_id( $entity_name ) {
//	The master definition for ids associated with Customizer entities.
//	The argument $entity_name is an internal reference name for each setting. It is NOT
//		necessarily the actual id for the entity.
//	This function can be queried by other helper functions to make it easy to use
//		these ids beyond the scope where they could be defined.
//		(Because the id is required both to set the setting as well as to retrieve it,
//		and these occur in different functions.)

	$id_array = array(
		'id_setting_always_show_featured_image_in_post'	=> 'kuhnian_boolean_display_featured_image_for_blog_post'	,
		'id_setting_character_separate_categories'		=> 'kuhnian_select_character_separate_categories'			,
	);

/*	See Nik Tang, "PHP – isset() vs array_key_exists() : a better way to determine array
	element’s existence," Think of Dev, April 3, 2011,
	http://thinkofdev.com/php-fast-way-to-determine-a-key-elements-existance-in-an-array/
*/
	if ( isset( $id_array[ $entity_name ] ) ) {
		$value = $id_array[ $entity_name ] ;
	} else {
		$value = NULL ;
		throw new Exception( 'Kuhnian/Customizer error: id \'' . $entity_name . '\' is undefined.' ) ;
	}
	return $id_array[ $entity_name ] ;
}

//---------------------------------------------------------------------------------------
function kuhnian_return_customizer_entity_default_value( $entity_name ) {
//	The master definition for default value associated with each Customizer entity.
//	The argument $entity_name is an internal reference name for each setting. It is NOT
//		necessarily the actual id for the entity.
//	This function can be queried by other helper functions to make it easy to use
//		these default values beyond the scope where they could be defined.
//		(Because the default value is required both to set the setting as well as to retrieve
//		it, and these occur in different functions.)

	$default_value_array = array(
		'id_setting_always_show_featured_image_in_post'	=> false	,
		'id_setting_character_separate_categories'		=> 'none'	,
	);

/*	See Nik Tang, "PHP – isset() vs array_key_exists() : a better way to determine array
	element’s existence," Think of Dev, April 3, 2011,
	http://thinkofdev.com/php-fast-way-to-determine-a-key-elements-existance-in-an-array/
*/
	if ( isset( $default_value_array[ $entity_name ] ) ) {
		$value = $default_value_array[ $entity_name ] ;
	} else {
		$value = NULL ;
		throw new Exception( 'Kuhnian/Customizer error: default value \'' . $entity_name . '\' is undefined.' ) ;
	}
	return $default_value_array[ $entity_name ] ;
}
//---------------------------------------------------------------------------------------

function return_id_setting_always_show_featured_image_in_post() {
//	Returns the id of the setting determining whether the featured image for a post should be automatically
//		displayed at the top of the post's page
	return kuhnian_return_customizer_entity_id( 'id_setting_always_show_featured_image_in_post' ) ;
//	return kuhnian_return_customizer_entity_id( 'zebra' )	; // Uncomment to test triggering error report
}

function return_default_value_setting_always_show_featured_image_in_post() {
//	Returns the id of the setting determining whether the featured image for a post should be automatically
//		displayed at the top of the post's page
	return kuhnian_return_customizer_entity_default_value( 'id_setting_always_show_featured_image_in_post' ) ;
//	return kuhnian_return_customizer_entity_default_value( 'zebra' )	; // Uncomment to test triggering error report
}

function kuhnian_boolean_display_featured_image_on_posts() {
//	Returns true if theme_mod $id_setting_always_show_featured_image_in_post is true;
//		otherwise, returns false (or, $default_value, if for some reason get_theme_mod
//		can't fetch a value)
	$setting_id = return_id_setting_always_show_featured_image_in_post() ;
	$default_value = return_default_value_setting_always_show_featured_image_in_post() ;
	$setting_value = get_theme_mod(
		$setting_id ,
		$default_value
		) ;
	$return_value = ( $setting_value === true ) ? true : false ;
	return $return_value ;
}

function return_id_character_separate_categories() {
//	Returns the id of the setting determining the character, if any, to separate multiple category names
//		in the meta informatino displayed for a post
	return kuhnian_return_customizer_entity_id( 'id_setting_character_separate_categories' ) ;
}

function return_default_value_character_separate_categories() {
//	Returns the id of the setting determining whether the featured image for a post should be automatically
//		displayed at the top of the post's page
	return kuhnian_return_customizer_entity_default_value( 'id_setting_character_separate_categories' ) ;
//	return kuhnian_return_customizer_entity_default_value( 'zebra' )	; // Uncomment to test triggering error report
}

function kuhnian_character_separate_categories() {
//	Returns desired character to separate multiple category names in meta line for a post
//		when the post belongs to more than one category
//	Queries the template_mod as set by user (or the default)
	$setting_id		= return_id_character_separate_categories() ;
	$default_value	= return_default_value_character_separate_categories() ;
	$setting_value	= get_theme_mod(
		$setting_id ,
		$default_value
		) ;
	switch ( $setting_value ) {
		case 'space' :
			$return_value = ' ' ;
			break ;
		case 'empty' :
			$return_value = '' ;
			break ;
		case 'comma' :
			$return_value = ', ' ;
			break ;
		case 'diamond' :
			$return_value = ' &diamondsuit; ' ;
			break ;
		default:
			$return_value = $default_value ;
			throw new Exception( 
				esc_attr( 'Kuhnian/Customizer error: this category-separator option is unrecognized: «' )
				. $setting_value . esc_attr( '».' ) ) ;
	}
	return $return_value ;
}


	