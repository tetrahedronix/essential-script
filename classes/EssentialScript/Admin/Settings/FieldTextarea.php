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

namespace EssentialScript\Admin\Settings;

/**
 * Concrete fieldset: provides the textarea to the client.
 *
 * @author docwho
 */
class FieldTextarea implements \EssentialScript\Admin\Settings\Setting {
	/**
	 * The options from Wordpress DB.
	 * @var array 
	 */
	private $options = array ();
	
	public function __construct() {
		
		$this->options = new \EssentialScript\Core\Options;
	}
	
	/**
	 * @return array Used by add_settings_field().
	 */
	public function provideItem() {
		
		return array ( $this, 'printItem' );
	}

	/**
	 * Outputs the textarea.
	 */
	public function printItem() {
	
		$textarea = $this->gettextarea();
?>
<textarea id="textarea-script" name="essentialscript_options[script]"
		  rows="10" cols="80"><?php echo $textarea; ?></textarea>
<p class="description"><?php esc_html_e( 'Max 512 chars. The allowed tags are listed in settings_sanitize(). You can add or remove tags as required.',
		'essential-script' ); ?></p>
<?php
		echo<<<'JS'
<!-- Codemirror -->   
<script>
   var textarea_node=document.getElementById("textarea-script");
   var editor = CodeMirror.fromTextArea(textarea_node, {
		lineNumbers: true,
		mode: { name: "xml", htmlMode: true },
		viewportMargin: Infinity,
		lint: true
});
</script> 
JS
. PHP_EOL;

	}
	
	public function gettextarea() {
	
		switch ( $this->options['storage'] ) {
			case 'wpdb':
				$textarea = $this->options['script'];
				break;
			case 'file':
				//$dir = wp_upload_dir();
				//$f = $dir['path'] . '/' . $options['filename'];
				$f = $this->options['path'] . '/' . $this->options['filename'];
				if ( file_exists( $f ) ) {
					$textarea = file_get_contents( $f );
				} else {
					add_settings_error(
						// slug title for our settings.
						'es_messages',
						// slug name for this error/event
						'es_file_error',
						// The formatted message text to display.
						__('File ' . $f . ' Not found', 'essential-script'),
						// The type of message it is: error/updated
						'error'								
					);
					settings_errors();
					$textarea = '';
				}
					break;
			default:
				$textarea = '';
			}
			
			return $textarea;
	}
}
