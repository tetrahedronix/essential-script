<?php
/**
 * @package Essential_Script\Admin
 */
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
 * Essential script menu and options page
 * 
 * Create the Essential Script menu & his options page.
 *
 * @author docwho
 */
class Menu {
	/**
	 * Submenu slug
	 * 
	 * @var string The resulting page's hook_suffix returned by add_submenu_page.
	 */
	private static $submenu_page;

	/**
	 * Getter function
	 * 
	 * This function returns the submenu slug.
	 * 
	 * @return string
	 */
	public static function get_slug() {
		return self::$submenu_page;
	}
	/**
	 * Menu initialization
	 * 
	 * Adds Essential Script submenu page to tools menu then it sets the
	 * submenu_page property.
	 */
	public static function init() {
		// Checks if we are displaying the Dashboard or the admin's panel.
		if ( is_admin() ) {
			self::$submenu_page = add_submenu_page(
				'tools.php',
				'Essential Script',
				'Essential Script',
				'manage_options',
				'essentialscript',
				'EssentialScript\Admin\Menu::options_page'
			);
		}
	}
	/**
	 * Output form tag for the settings page.
	 * 
	 * @return If user can't manage options.
	 */
	static function options_page() {
		// Check user capabilities
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		// check if the user have submitted the settings
	    if ( isset( $_GET['settings-updated'] ) ) {
		    // add settings saved message with the class of "updated"
	        add_settings_error(
				// slug title for our settings.
				'es_messages',
				// slug name for this error/event
				'es_updated',
				// The formatted message text to display.
				__( 'Script saved', 'essential-script' ),
				// The type of message it is: error/updated
				'updated'
			);
	    }
		//	Display error/update messages registered by add_settings_error(). 
		settings_errors( 'es_messages' );
		
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
            do_settings_sections( self::$submenu_page );
            // output save settings button
            submit_button( __( 'Save Script', 'essential-script' ) );		
		?>
	</form>	
</div>
<?php
	}
	
	
}
