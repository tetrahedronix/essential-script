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

namespace EssentialScript\Frontend;

/**
 * Wraps the component selected by the user in one or more decorators.
 *
 * @author docwho
 */
class Queuing {
	/**
	 * @var object Instance of the concrete component. 
	 */
	private $script;
	
	/**
	 * Setup class
	 * 
	 * @param string $handle Name of the script. Should be unique.
	 * @param array $accessories An array of accessories to wrap.
	 * @return null If something goes wrong.
	 */
	public function __construct( $handle, $accessories ) {

		if ( !is_string( $handle ) ) {
			return;
		}
		
		$func = "\\EssentialScript\\Frontend\Scripts\\" . 
				str_replace( '-', '', ucwords( $handle, '-' ) );
		// Select the concrete component using variable function syntax.
		$this->script = new $func();
		
		// Remove all accessories which are equal to null, 0, '' or false.
		$test_accessories = array_filter( $accessories );

		if ( !empty ( $test_accessories ) ) {
			array_walk( $test_accessories, array( $this, 'accessorize' ) );
		}

		// Enqueue the script together all his accessories.
		add_action( 'wp_enqueue_scripts', array ( $this->script, 'enqueueScript') );
	}
	
	public function accessorize( $value, $key ) {
	
		$func = "\\EssentialScript\\Frontend\Scripts\\" .
			str_replace( '-', '', ucwords( $key, '-' ) );
		$this->script = new $func( $this->script );
	}

}
