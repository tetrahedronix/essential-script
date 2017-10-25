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
 * Concrete fieldset: provides the radiobuttons required for the Where option.
 *
 * @author docwho
 */
class FieldPages implements \EssentialScript\Admin\Settings\Setting {
	
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
	 * Outputs the radiobuttons required for the Where option.
	 */
	public function printItem() {

?>
<fieldset>
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'What pages include the script', 'essential-script' ); ?></span></legend>
<label>
	<input type="checkbox" name="essentialscript_options[pages][index]" 
<?php checked( $this->options['pages']['index'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Default Homepage',
			'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][single]" 
<?php checked( $this->options['pages']['single'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Single Post',
			'essential-script' ); ?></span>	
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][page]" 
<?php checked( $this->options['pages']['page'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Pages', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][archive]" 
<?php checked( $this->options['pages']['archive'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Archive', 'essential-script' ); ?></span>
</label>
</fieldset>
<?php
		
	}

}
