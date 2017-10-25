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
 * Concrete fieldset: provides the radiobuttons.
 *
 * @author docwho
 */
class FieldWhere implements \EssentialScript\Admin\Settings\Setting {
	
	/**
	 * The options from Wordpress DB.
	 * @var array 
	 */
	private $options = array ();
	
	/**
	 * Setup class.
	 */
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
	 * Outputs the radiobuttons.
	 */
	public function printItem() {

?>
<fieldset id="front-static-pages">		
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'Choose where to plug the script',
			'essential-script' ); ?></span></legend>
<label>
	<input type="radio" name="essentialscript_options[where]" value="head" 
<?php checked( $this->options['where'], 'head', true ); ?>>
	<span class="input-text">
		<?php esc_html_e( 'Head', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[where]" value="content" 
<?php checked( $this->options['where'], 'content', true ); ?>>
	<span class="input-text">
		<?php esc_html_e( 'Content', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[where]" value="shortcode"
<?php checked( $this->options['where'], 'shortcode', true ); ?>>
	<span class="input-text">
		<?php esc_html_e( 'Content with Shortcode', 'essential-script' ); ?>
	</span>
	<span>( <strong><?php esc_html_e( 'Note: ',
			'essential-script' ); ?></strong>
		<i><?php esc_html_e( 'Use the tag [essential-script]', 
			'essential-script' ); ?></i> )</span>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[where]" value="foot" 
<?php checked( $this->options['where'], 'foot', true ); ?>>
	<span class="input-text">
		<?php esc_html_e( 'Foot', 'essential-script' ); ?></span>
</label>
</fieldset>					
<?php
		
	}

}
