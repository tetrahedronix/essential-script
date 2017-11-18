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
 * Concrete section: provides the section to the client.
 *
 * @author docwho
 */
class EssentialscriptSection implements \EssentialScript\Admin\Settings\Setting {
	/**
	 * The options from Wordpress DB.
	 * @var array 
	 */
	private $options = array ();
	
	public function __construct() {
		
		$this->options = new \EssentialScript\Core\Options;
	}
	
	/**
	 * @return array Used by add_settings_section().
	 */
	public function provideItem() {
		
		return array ( $this, 'printItem' );
	}
	
	/**
	 * Outputs the descriptive text of the section.
	 */
	public function printItem() {
		echo ( '<p>' );
		esc_html_e( 'Fill your script settings below: script code, position and storage.',
				'essential-script' );
		echo ( '</p>' );

	}
}
