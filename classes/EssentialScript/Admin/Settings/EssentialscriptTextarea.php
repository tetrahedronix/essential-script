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
class EssentialscriptTextarea implements \EssentialScript\Admin\Settings\Setting {
	/**
	 * Container for plugin options.
	 * 
	 * @var object The options contained in the Options object. 
	 */
	private $options;
	/**
	 * Object for file management.
	 * 
	 * @var object File object.
	 */
	private $file_obj;
	
	public function __construct() {
		
		$this->options = new \EssentialScript\Core\Options;		
		
		$this->file_obj = new \EssentialScript\Core\File( $this->options );
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
	
		$textarea = $this->file_obj->getcontent();
?>
<textarea id="textarea-script" name="essentialscript_options[script]"
		  rows="10" cols="80"><?php echo $textarea; ?></textarea>
<p class="description"><?php esc_html_e( 'Max 512 chars. The allowed tags are listed in settings_sanitize(). You can add or remove tags as required.',
		'essential-script' ); ?></p>
<?php
	\EssentialScript\Core\Codemirror::fromtextarea();

	}
}
