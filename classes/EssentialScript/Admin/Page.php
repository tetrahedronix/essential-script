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
abstract class Page {

	/**
	 * Submenu slug
	 * 
	 * @var string The submenu slug for the administration page
	 */
	protected $submenu_page;
	
	/**
	 * Setup class.
	 */
	public function __construct( $submenu_page ) {
	
		$this->submenu_page = $submenu_page;
		
		if ( $this->submenu_page ) {
			register_setting( 'essentialscript_options', 
				'essentialscript_options',
				array ( $this, 'settings_sanitize' )
			);
			$this->settings();
		}
	}

	/**
	 * Getter function.
	 * 
	 * @return string The submenu slug for the administration page.
	 */	
	public function getslug() {
		return $this->submenu_page;
	}
	
	abstract public function page();

	/**
	 * Use the Factory Pattern to create fieldsets and sections.
	 */
	abstract public function settings();
	
	/**
	 * Sanitize the input received from the settings page.
	 */
	abstract public function settings_sanitize( $input );
}