<?php

/*
 * Copyright (C) 2018 docwho
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
 * Description of PointerEssentialscript
 *
 * @author docwho
 */
class PointerEssentialscript extends \EssentialScript\Core\Pointers {
	
	private $userMeta;
	
	public function __construct() {
		
		parent::__construct();

		$this->userMeta = (string) get_user_meta(
			get_current_user_id(), 'dismissed_escript_pointers', true );
		// Include the pointer scripts and styles.
		add_action( 'admin_enqueue_scripts',
			array ( $this, 'enqueueScript' ) );
		add_action( 'essentialscript_pointer',
			array ( $this, 'displayPointer' ) );
		add_action( 'admin_print_footer_scripts',
			array (	$this, 'footerScript' ) );
	}
	
	public function displayPointer() {

		$dismissed_pointers = explode( ',', $this->userMeta );
		
		if ( ! in_array( 'plugin_editor_notice', $dismissed_pointers, true ) ) :
			// Get a back URL
			$referer = wp_get_referer();
			$excluded_referer_basenames = array( 'tools.php?page=essentialscript', 'wp-login.php' );
			
			if ( $referer && ! in_array( basename( parse_url( $referer, PHP_URL_PATH ) ), $excluded_referer_basenames, true ) ) {
				echo '---------1';
				$return_url = $referer;
			} else {
				echo '---------2';
				$return_url = admin_url( '/' );
			}
			echo '-------------------';
			var_dump( $return_url );
?>
<div id="file-editor-warning" class="notification-dialog-wrap file-editor-warning hide-if-no-js hidden">
	<div class="notification-dialog-background"></div>
	<div class="notification-dialog">
		<div class="file-editor-warning-content">
			<div class="file-editor-warning-message">
				<h1><?php _e( 'Heads up!' ); ?></h1>
				<p><?php _e( 'You appear to be adding JavaScript to your Wordpress platform. We recommend that you pay attention while you are about to do so. Adding JavaScript may 
introduce <b>dangerous code</b> that break your Web Site making it vulnerable to hacker attacks. Cross-site scripting is a type of hack that uses JavaScript.' ); ?></p>
				<p><?php _e( 'If you are fully aware of these risks and how to avoid them, then you can proceed beyond this screen, if something goes wrong you can always disable 
					this plugin. Otherwise stop here and go back.' ); ?></p>
			</div>
			<p>
				<a class="button file-editor-warning-go-back" href="<?php echo esc_url( $return_url ); ?>"><?php _e( 'Go back' ); ?></a>
				<button type="button" class="file-editor-warning-dismiss button button-primary"><?php _e( 'I understand' ); ?></button>
			</p>
		</div>
	</div>
</div>
<?php
endif; // editor warning notice		
	}

	public function footerScript() {
?>
<script type="text/javascript">
	wp.essentialScriptPointers.init();
</script>
<?php
	}
}
