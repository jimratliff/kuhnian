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

*/

function return_entity_id( $entity_name ) {
	$id_array = array(
		'id_setting_always_show_featured_image_in_post'	=> 'kuhnian_boolean_display_featured_image_for_blog_post'
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

function return_id_setting_always_show_featured_image_in_post() {
	return return_entity_id( 'id_setting_always_show_featured_image_in_post' )	;
//	return return_entity_id( 'zebra' )	; // Uncomment to test triggering error report
}


add_action( 'customize_register' , 'kuhnian_customize_register' ) ;
function kuhnian_customize_register( $wp_customize ) {
//	Initialize strings used later
	$threshold_capability			= 'edit_theme_options'	; // User level required to set options
	$id_panel						= 'kuhnian_panel'		;
	$id_section_general				= 'id_section_general'	;
//	$id_setting_always_show_featured_image_in_post	= 'kuhnian_boolean_display_featured_image_for_blog_post'	;
	$id_setting_always_show_featured_image_in_post	= return_id_setting_always_show_featured_image_in_post()	;
//	Strings that should be translatable
	$title_panel					= __( 'Kuhnian Theme' )										; // Displayed title of Kuhnian Customizer panel
	$description_panel				= __( 'Settings specific to Kuhnian Theme' )				; // Panel description (behind help button)
	$title_section_general			= __( 'General Settings' )									; // Displayed title of General section
	$description_section_general	= __( 'Settings that don\'t fall in any other category' )	; // Section description
	$label_control_always_show_featured_image_in_post	= __( 'Always show featured image at top of post\'s dedicated page' )	;
	$description_control_always_show_featured_image_in_post	= __( 'A post\'s featured image will appear on blogroll/archive/front pages in any case' )	;
	
//	Add panel for this theme's settings
	$wp_customize->add_panel(
		$id_panel,		// panel ID
		array(					//	array of properties for new panel
			'title'			=> $title_panel ,
			'description'	=> $description_panel
			)
		) ;

//	Add sections
//	Add General section
	$wp_customize->add_section(
		$id_section_general , // General-Section ID
		array(
			'title'			=> $title_section_general ,
			'description'	=> $description_section_general ,
			'panel'			=> $id_panel
		)
	) ;

//	Add settings and their controls
//	Add settings/controls to General section
//	Add setting/control whether to display featured image on each blog post's page
	$wp_customize->add_setting(
		$id_setting_always_show_featured_image_in_post ,	// id for setting
//			'kuhnian_boolean_display_featured_image_for_blog_post' ,	// id for setting
		array(
//			'type'				=> 'theme_mod' ,	// theme_mod is the default
			'default'			=>	false ,			// default value for checkbox variable
			'sanitize_callback'	=>	'sanitize_checkbox'  // Makes sure only true/false
		)
	) ;
	
	$wp_customize->add_control(
		$id_setting_always_show_featured_image_in_post ,
//		'kuhnian_boolean_display_featured_image_for_blog_post' ,
		array(
			'label'			=>	$label_control_always_show_featured_image_in_post ,
			'description'	=>	$description_control_always_show_featured_image_in_post ,
			'section'		=>	$id_section_general ,
			'type'			=>	'checkbox' ,
			'priority'		=>	10 ,
			'capability'	=> $threshold_capability
		)
	) ;
} // End kuhnian_customize_register()

//	Sanitizes checkbox response by coercing it to be either true or false
//		If true, returns true; otherwise, returns false
function sanitize_checkbox( $input ) {

	return ( $input === true ) ? true : false ;
}

function kuhnian_boolean_display_featured_image_on_posts() {
//	Returns true if theme_mod $id_setting_always_show_featured_image_in_post is true;
//		otherwise, returns false (or, $default_value, if for some reason get_theme_mod
//		can't fetch a value)
//	This is defined within the class to give access to $id_setting_always_show_featured_image_in_post.
//		Can be paired to an outside-of-class helper to make calling this less wordy and less
//		dependent on implementation by this class
//	E.g., see function kuhnian_boolean_display_featured_image_on_posts()
	$default_value = false ;
	$setting_id = return_id_setting_always_show_featured_image_in_post() ;
	$setting_value = get_theme_mod(
		$setting_id ,
		$default_value
		) ;
	$return_value = ( $setting_value === true ) ? true : false ;
	return $return_value ;
}
	