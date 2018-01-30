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
 * Concrete component for Essential Script administration page
 *
 * @author docwho
 */
class Essentialscript extends \EssentialScript\Admin\Scripts\Component {
	
	/**
	 * Setup class.
	 * 
	 * @param string $page_slug The page slug
	 */
	public function __construct() {

		$this->handle = 'essentialscript-plugin-style';
		
	}
	
	/**
	 * Add the plugin admin CSS.
	 */
	public function enqueueScript() {
		
		// Essential Script main CSS file
		wp_register_style(
			$this->handle,
			plugins_url( 'css/essentialscript-admin.css', 
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
			array (),
			self::ESSENTIALSCRIPT_VER,
			false
		);
		wp_enqueue_style( $this->handle );
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
