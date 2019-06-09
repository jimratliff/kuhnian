<?php
/*	Enables Customizer for modifying theme-specific modifications for Kuhnian, above and
	beyond what is enabled by the Kuhn-provided file customizer.php

	Draws upon:
	Ashley Gibson, "Tutorial: Using the Customizer to Add Settings to Your WordPress Theme,"
		Nose Graze, May 2, 2016, https://www.nosegraze.com/customizer-settings-wordpress-theme/
	Rachel McCollin, "WordPress Development for Intermediate Users: Making Your Themes
		Customizer-Ready," WPMU DEV, October 15, 2017,
		https://premium.wpmudev.org/blog/wordpress-development-for-intermediate-users-making-your-themes-customizer-ready/
*/
class Kuhnian_Theme_Customizer {
//	Initialize strings used later
	protected $threshold_capability								= 'edit_theme_options'	; // User level required to set options
	protected $id_panel											= 'kuhnian_panel'		;
	protected $id_section_general								= 'id_section_general'	;
	protected $id_setting_always_show_featured_image_in_post	= 'kuhnian_boolean_display_featured_image_for_blog_post'	;

//	Strings that should be translatable
//		In order to be translatable, these strings need to be assigned via the __() function. 
//		Therefore they can't be assigned in the class itself. Thus they are now assigned in the __construct().
//		E.g., see https://stackoverflow.com/a/40828676/8401379
	protected $title_panel	;
	protected $description_panel	;
	protected $title_section_general	;
	protected $description_section_general	;
	protected $label_control_always_show_featured_image_in_post	;
	protected $description_control_always_show_featured_image_in_post	;

	public function __construct() {
		add_action(
			'customize_register' ,
			array( $this, 'kuhnian_customize_register'  )
		);
//		Strings that should be translatable
		$this->title_panel												= __( 'Kuhnian Theme' )										; // Displayed title of Kuhnian Customizer panel
		$this->description_panel										= __( 'Settings specific to Kuhnian Theme' )				; // Panel description (behind help button)
		$this->title_section_general									= __( 'General Settings' )									; // Displayed title of General section
		$this->description_section_general								= __( 'Settings that don\'t fall in any other category' )	; // Section description
		$this->label_control_always_show_featured_image_in_post			= __( 'Always show featured image at top of post' )			;
		$this->description_control_always_show_featured_image_in_post	= __( 'A post\'s featured image will appear on blog/archive/front pages in any case' )	;

	}
	public function kuhnian_customize_register( $wp_customize ) {
	//	Add panel for this theme's settings
		$wp_customize->add_panel(
			$this->id_panel,		// panel ID
			array(					//	array of properties for new panel
				'title'			=> $this->title_panel ,
				'description'	=> $this->description_panel
				)
			) ;
	//	Add sections
	//	Add General section
		$wp_customize->add_section(
			$this->id_section_general ,
			array(
				'title'			=> $this->title_section_general ,
				'description'	=> $this->description_section_general ,
				'panel'			=> $this->id_panel
			)
		) ;
	//	Add settings and their controls
	//	Add settings/controls to General section
	//	Add setting/control whether to display featured image on each blog post's page
		$wp_customize->add_setting(
			$this->id_setting_always_show_featured_image_in_post ,	// id for setting
//			'kuhnian_boolean_display_featured_image_for_blog_post' ,	// id for setting
			array(
//				'type'				=> 'theme_mod' ,	// theme_mod is the default
				'default'			=>	false ,			// default value for checkbox variable
				'sanitize_callback'	=>	array( $this , 'sanitize_checkbox' ) // Makes sure only true/false
			)
		) ;
		
		$wp_customize->add_control(
			$this->id_setting_always_show_featured_image_in_post ,
//			'kuhnian_boolean_display_featured_image_for_blog_post' ,
			array(
				'label'			=>	$this->label_control_always_show_featured_image_in_post ,
				'description'	=>	$this->description_control_always_show_featured_image_in_post ,
				'section'		=>	$this->id_section_general ,
				'type'			=>	'checkbox' ,
				'priority'		=>	10 ,
				'capability'	=> $this->threshold_capability
			)
		) ;

	}	// End kuhnian_customize_register()
	
//	Sanitizes checkbox response by coercing it to be either true or false
//		If true, returns true; otherwise, returns false
	public function sanitize_checkbox( $input ) {
	
		return ( $input === true ) ? true : false ;
	}

	public function boolean_display_featured_image_on_posts(): bool {
//		Returns true if theme_mod $id_setting_always_show_featured_image_in_post is true;
//			otherwise, returns false (or, $default_value, if for some reason get_theme_mod
//			can't fetch a value)
//		This is defined within the class to give access to $id_setting_always_show_featured_image_in_post.
//			Can be paired to an outside-of-class helper to make calling this less wordy and less
//			dependent on implementation by this class
//		E.g., see function kuhnian_boolean_display_featured_image_on_posts()
		$default_value = false ;
		$return_value = get_theme_mod(
			$this->id_setting_always_show_featured_image_in_post ,
			$default_value
		)
		return $return_value ;
	}

} // End class Kuhnian_Theme_Customizer
new Kuhnian_Theme_Customizer() ;

function kuhnian_boolean_display_featured_image_on_posts(): bool {
//		Returns true if theme_mod $id_setting_always_show_featured_image_in_post is true;
//			otherwise, returns false
	$return_value = Kuhnian_Theme_Customizer->boolean_display_featured_image_on_posts() ;
	return $return_value ;
}





