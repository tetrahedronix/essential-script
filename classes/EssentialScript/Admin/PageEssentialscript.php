<?php

/*
 * Copyright (C) 2017 docwho
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace EssentialScript\Admin;

/**
 * Manages the administration page, print the fields.
 *
 * @author docwho
 */
class PageEssentialscript extends \EssentialScript\Admin\Page {

	/**
	 * Output form tag for the settings page.
	 * 
	 * @return If user can't manage options.
	 */
	public function page() {
		// Check user capabilities
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		// check if the user have submitted the settings
	    if ( isset( $_GET['settings-updated'] ) ) {
		    // add settings saved message with the class of "updated"
	        add_settings_error(
				// slug title for our settings.
				'essentialscript_messages',
				// slug name for this error/event
				'essentialscript_updated',
				// The formatted message text to display.
				__( 'Script saved', 'essential-script' ),
				// The type of message it is: error/updated
				'updated'
			);
	    }
		//	Display error/update messages registered by add_settings_error(). 
		settings_errors( 'essentialscript_messages' );
		
		?>
<div class="wrap">
	<h1><?= esc_html( get_admin_page_title() ); ?></h1>
	<p><?= esc_html_e( 'Essential Script plugin offers you the ability to plug and manage your essential scripts through a basic input interface.', 'essential-script' ); ?></p>
	<form action="options.php" method="POST">
		<?php
			// output security fields for the registered setting "wporg_options" 
            settings_fields( 'essentialscript_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( $this->submenu_page );
            // output save settings button
            submit_button( __( 'Save Script', 'essential-script' ) );		
		?>
	</form>	
</div>
<?php		
	}
	/**
	 * Use the Factory Pattern to create fieldsets and sections.
	 */
	public function settings() {
		// Add a new section to a settings page.
		$section = new \EssentialScript\Admin\Settings\SectionCreator;
		add_settings_section(
			'essentialscript_section_id',		// HTML ID tag
			'Script Area',			// The section title text
			// Callback that will echo some explanations
			$section->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptSection ),	
			$this->submenu_page		// Settings page
		);
		// Register a settings field to a settings page and section.
		$field = new \EssentialScript\Admin\Settings\FieldCreator;
		add_settings_field(
			'essentialscript_highlighter',
			__( 'What syntax highlighter to use', 'essential-script' ),
			$field->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptHighlighter ),
			$this->submenu_page,
			'essentialscript_section_id'
		);
		add_settings_field(
			'essentialscript_textarea',
			__( 'Enter the script code here', 'essential-script' ),
			$field->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptTextarea ),
			$this->submenu_page,
			'essentialscript_section_id'			
		);
		add_settings_field(
			'essentialscript_radiobutton_where',
			__( 'Choose where to plug the script', 'essential-script' ),  
			$field->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptWhere ),
			$this->submenu_page,
			'essentialscript_section_id' );
		add_settings_field(
			'essentialscript_checkbox_pages',
			__( 'What pages include the script', 'essential-script' ),
			$field->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptPages ),
			$this->submenu_page,
			'essentialscript_section_id'
		);
		add_settings_field(
			'essentialscript_radiobutton_storage',
			__( 'Choose where to store the script', 'essential-script' ),
			$field->doFactory( new \EssentialScript\Admin\Settings\EssentialscriptStorage ),
			$this->submenu_page,
			'essentialscript_section_id'			
		);
	}
	
	/**
	 * Sanitize the input received from the settings page.
	 * 
	 * @param type $input The user input
	 * @return string The user input safe to use.
	 */
	public function settings_sanitize( $input ) {
		$sane = array ();
		// List of allowed tags and attributes 
		add_filter( 'safe_style_css', function( $styles ) {
			$styles[] = 'display';
			return $styles;
		} );
		$allow_html = array (
			'a' => array (
				'href' => true,
			),
			'center' => array(),
			'img' => array (
				'src' => true,
				'alt' => true,
				'style' => true,
			),
			'ins' => array ( 
				'class' => true,
				'style' => array (
					'display' => true, 
					'width'=> true, 
					'height'=> true ), 
				'data-ad-client' => true,
				'data-ad-slot' => true ),
			'noscript' => true,
			'script' => array (
				'async' => true,
				'src' => true ),
		);
		/*
		 * Sanitize the highlighter
		 */
		switch ( $input['highlighter'] ) {
			case 'xml':
				$sane['highlighter'] = 'xml';
				break;
			case 'javascript':
				$sane['highlighter'] = 'javascript';
				break;
			default:
				$sane['highlighter'] = 'xml'; 
		}
		/*
		 *  Sanitize the script
		 */
		$sane['script'] = substr( wp_kses( $input['script'], $allow_html ), 0, 511 );
		/*
		 *  Sanitize where we want the script
		 */
 		switch ( $input['where'] ) {
			case 'head':
				$sane['where'] = 'head';
				break;
			case 'content':
				$sane['where'] = 'content';
				break;
			case 'shortcode':
				$sane['where'] = 'shortcode';
				break;
			case 'foot':
				$sane['where'] = 'foot';
				break;
			default:
				$sane['where'] = 'foot';
		} 
		/* 
		 * Sanitize the filename: 
		 * 
		 * if no name was specified then it creates a hash for the filename, else
		 * sanitize the user input.
		 */
		$f = ( '' === $input['filename'] ) ?
				uniqid( 'es', true ) : sanitize_file_name( $input['filename'] );
		/* Equivalent to:
		if ( $input['filename'] === '' ) {
			// Creates a 23 character hash for the filename
			//$f = md5( time() . mt_rand() );
			$f = uniqid( 'es', true );
		} else {
			$f = sanitize_file_name( $input['filename'] );
		} */
		/*
		 *  Sanitize the checkboxes:
		 */
		$sane['pages']['index'] = ( 'on' === $input['pages']['index'] ) ? 
				true : false;
		$sane['pages']['single'] = ( 'on' === $input['pages']['single'] ) ? 
				true : false;
		$sane['pages']['page'] = ( 'on' === $input['pages']['page'] ) ? 
				true : false;
		$sane['pages']['archive'] = ( 'on' === $input['pages']['archive'] ) ? 
				true : false;
		$sane['enqueue'] = ( 'on' === $input['enqueue'] ) ? true: false;
		/* Equivalent to:
		 * if ( $input['pages']['index'] === 'on' ) {
			$sane['pages']['index'] = true;
		} else {
			$sane['pages']['index'] = false;
		}
		if ( $input['pages']['single'] === 'on' ) {
			$sane['pages']['single'] = true;
		} else {
			$sane['pages']['single'] = false;
		}
		if ( $input['pages']['page'] === 'on' ) {
			$sane['pages']['page'] = true;
		} else {
			$sane['pages']['page'] = false;
		}
		if ( $input['pages']['archive'] === 'on' ) {
			$sane['pages']['archive'] = true;
		} else {
			$sane['pages']['archive'] = false;
		} */
		/*
		 *  Sanitize the radio buttons:
		 */
		switch ( $input['storage'] ) {
			case 'wpdb':
				$sane['storage'] = 'wpdb';
				$sane['filename'] = '';
				$sane['path'] = '';
				// Forcing enqueue checkbox to false
				$sane['enqueue'] = false;
				break;
			case 'file':
				$dir = wp_upload_dir();
				// Path to the file where to write the data. 
				$path = $dir['path'] . DIRECTORY_SEPARATOR . $f;
				$sane['storage'] = 'file';
				file_put_contents( $path, $sane['script'] );
				$sane['path'] = $dir['path'];
				$sane['filename'] = $f;
				$sane['script'] = '';
				break;
		} 

		return $sane;
	}
}
