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
 * Enqueue various scripts and files for the administration page.
 *
 * @author docwho
 */
class Queuing {

	/**
	 * @var string The page slug. 
	 */
	private $page;
	
	/**
	 * @var mixed $extra_data Extra data used by wp_add_inline_script
	 */
	private $extra_data;
	
	/**
	 * Setup class.
	 * 
	 * @param string $slug Page slug.
	 * @param array $scripts Script requirements.
	 * @param mixed $extra_data Extra data used by wp_add_inline_script
	 * @return null On error
	 */
	public function __construct( $slug = '', 
								$scripts =  array(), 
								$extra_data = '' ) {

		$this->extra_data = $extra_data;
		
		// Select the concrete component.
		if ( 'tools_page_essentialscript' === $slug ) {
			$this->page = 
				new \EssentialScript\Admin\Scripts\Essentialscript( $slug );
		} elseif ( 'widgets.php' === $slug ) {
			$this->page = 
				new \EssentialScript\Admin\Scripts\Widgets( $slug );
			$this->page->setExtradata( $this->extra_data );
		} else {
			return;
		}
		
		// Remove all values from $scripts which are equal to null, 0, '' or false.
		$test_array = array_filter( $scripts );
		
		if ( !empty ( $test_array ) ) {
			array_walk( $test_array, array( $this, 'accessorize' ) );
		}
	}
	
	/**
	 * Make sure the correct wrapper is called based on the requirements of the
	 * concrete component.
	 * 
	 * @param string $key Current requirement
	 */
	public function accessorize( $key ) {

		switch ( $key ) {
			case 'dist-codemirror-script':
				$this->page = 
					new \EssentialScript\Admin\Scripts\CodemirrorScript(
						$this->page	);
				break;
			case 'dist-codemirror-style':
				$this->page =
					new \EssentialScript\Admin\Scripts\CodemirrorStyle(
						$this->page );
				break;
			case 'dist-codemirror-mode-js':
				$this->page =
					new \EssentialScript\Admin\Scripts\CodemirrorModeJS(
						$this->page );
				break;
			case 'dist-codemirror-mode-xml':
				$this->page =
					new \EssentialScript\Admin\Scripts\CodemirrorModeXml(
						$this->page );
				break;
			case 'codemirror-style-override':
				$this->page =
					new \EssentialScript\Admin\Scripts\CodemirrorStyleOverride(
						$this->page );
				break;
			case 'essential-script-widgets':
				$this->page =
					new \EssentialScript\Admin\Scripts\WidgetsEssentialscript(
						$this->page );
				break;
			case 'wp-codemirror':
				$this->page =
					new \EssentialScript\Admin\Scripts\WidgetsWPCodemirror(
						$this->page );
				
		}
	}
}
