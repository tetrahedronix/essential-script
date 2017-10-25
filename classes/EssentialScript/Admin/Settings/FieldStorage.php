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
 * Concrete fieldset: provides various HTML related elements.
 *
 * @author docwho
 */
class FieldStorage implements \EssentialScript\Admin\Settings\Setting {
	
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
	 * Outputs various related HTML elements with the Storage option.
	 */
	public function printItem() {

?>
<fieldset id="front-static-pages">
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'Choose where to store the script',
			'essential-script' ); ?></span></legend>
<label>
	<input type="radio" name="essentialscript_options[storage]" value="file" 
<?php checked( $this->options['storage'], 'file', true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'File (Recommended)',
			'essential-script' ); ?></span>
	<input type="text" name="essentialscript_options[filename]" value="<?php echo esc_attr( $this->options['filename'] ); ?>" size="25" />
	</label>
	<p class="description"><?php esc_html_e( 'Enter the filename',
			'essential-script' ); ?></p>	
<ul>
	<li><label for="enqueue">
			<input type="checkbox" 
				   id="enqueue" 
				   name="essentialscript_options[enqueue]" 
				   <?php checked( $this->options['enqueue'], true, true ); ?> />
			<?php printf( __( 'Use <a href="%s">wp_enqueue_scripts</a> hook (where possible)',
				'essential-script' ),
				'https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts'  ); ?>
	</label></li>
	<li><strong><?php esc_html_e( 'Note:', 'essential-script' ); ?></strong>
		<i><?php esc_html_e( 'The external script file cannot contain the <script> tag.',
		'essential-script') ?></i></li>
</ul>
<p><label>
	<input type="radio" name="essentialscript_options[storage]" value="wpdb" 
<?php checked( $this->options['storage'], 'wpdb', true ); ?>/>
	<span class="input-radio"><?php esc_html_e( 'Wordpress DB',
			'essential-script' ); ?></span>
	</label></p>
</fieldset>
<?php
		
	}

}
