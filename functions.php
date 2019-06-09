<?php
/**
 * Kuhn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kuhnian
 */

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
