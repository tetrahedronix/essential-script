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
	public function __construct( $page_slug = '' ) {

		$this->slug = $page_slug;
		add_action( 'admin_enqueue_scripts', array ( $this, 'enqueueScript' ) );
	}
	
	/**
	 * Add the plugin admin CSS.
	 * 
	 * @param type $hook
	 */
	public function enqueueScript( $hook ) {
		
		if ( $this->slug !== $hook ) {
			return;
		}
		
		// Essential Script main CSS file
		wp_register_style(
			'essentialscript-plugin-style',
			plugins_url( 'css/essentialscript-admin.css', 
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
			array (),
			self::ESSENTIALSCRIPT_VER,
			false
		);
		wp_enqueue_style( 'essentialscript-plugin-style' );
	}

	/**
	 * Getter
	 * 
	 * @return mixed Extra data
	 */	
	public function getExtradata() {
		
		return $this->extra_data;
	}

	/**
	 * Getter
	 * 
	 * @return string The page slug
	 */	
	public function getSlug() {
		
		return $this->slug;
	}

	/**
	 * Setter
	 * 
	 * @param mixed $data Extra data
	 */	
	public function setExtradata( $data ) {
		
		$this->extra_data = $data;
	}
}
