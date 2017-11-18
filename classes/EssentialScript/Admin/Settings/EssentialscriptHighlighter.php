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
 * Description of EssentialscriptHighlighter
 *
 * @author docwho
 */
class EssentialscriptHighlighter implements \EssentialScript\Admin\Settings\Setting {
	
	private $options = array ();
	
	public function __construct() {

		$this->options = new \EssentialScript\Core\Options;
	}
	
	public function provideItem() {

		return array ( $this, 'printItem' );
	}
	
	public function printItem() {
?>		
<fieldset id="front-static-page">
	<legend class="screen-reader-text">
		<span><?php esc_html_e( 'What syntax highlighter to use',
			'essential-script' );?></span></legend>
	<p>
	<label>
		<input type="radio" 
			   name="essentialscript_options[highlighter]" value="xml"
<?php checked( $this->options['highlighter'], 'xml', true ); ?>>
		<?php esc_html_e( 'XML', 'essential-script' ); ?>
	</label></p>
	<p>
	<label>
		<input type="radio"
			   name="essentialscript_options[highlighter]" value="javascript"
<?php checked( $this->options['highlighter'], 'javascript', true ); ?>>
		<?php esc_html_e( 'JavaScript', 'essential-script' ); ?>
	</label></p>		
</fieldset>
<?php
	}
}
