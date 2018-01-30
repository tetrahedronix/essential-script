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

namespace EssentialScript\Admin\Scripts;

/**
 * Concrete component for Widget: 
 *
 * @author docwho
 */
class Widgets extends \EssentialScript\Admin\Scripts\Component {
	
	/**
	 * Setup class.
	 * 
	 * @param array $extra_data Extra data
	 */
	public function __construct( $extra_data = array() ) {
		
		$this->extra_data = $extra_data;
		$this->handle = 'essentialscript-widgets';
	}
	
	/**
	 * Adds necessary JavaScript file for using CodeMirror in Widget
	 * 
	 * @param string $hook The hook suffix for the current administration page.
	 * @return null If current page is not the widgets administration panel.
	 */
	public function enqueueScript() {

	}
	/**
	 * Getter
	 * 
	 * @return string The current script handle
	 */	
	public function getHandle() {
		
		return $this->handle;
	}

}
