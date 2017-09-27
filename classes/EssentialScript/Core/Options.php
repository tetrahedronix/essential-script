<?php
/**
 * @package Essential_Script\Core
 */
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
namespace EssentialScript\Core;

/**
 * Please visit http://be2.php.net/manual/en/class.arrayaccess.php for more
 * details about this class.
 */
class Options implements \ArrayAccess {
	/**
	 * Container for options.
	 * 
	 * @var int	 
	 */
	private $container = array ();
	/**
	 * Setup class.
	 */
	public function __construct() {
		// Retrieves the Essentialscript options from Wordpress DB.
		$this->container = get_option( 'essentialscript_options' );

		if ( !is_array ( $this->container ) ) {
			$this->container = array();
		}
		
		// Check whether you need to update any option.
		if ( !array_key_exists( 'where', $this->container ) ) {
			$this->container['where'] = 'foot';  // Save default
			update_option( 'essentialscript_options', $this->container['where'] );
		}
		
		if ( !array_key_exists( 'pages', $this->container ) ) {
			$this->container['pages'] = array ( 
				array (	'index' => true, 
					'single' => false,
					'page' => false,
					'archive' => false ),
			);
			update_option( 'essentialscript_options', $this->container['pages'] );
		}		

		if ( !array_key_exists( 'storage', $this->container ) ) {
			$this->container['storage'] = 'file';
			update_option( 'essentialscript_options', $this->container['storage'] );
		} 
		
		if ( !array_key_exists( 'enqueue', $this->container ) ) {
			$this->container['enqueue'] = 'false';
			update_option( 'essentialscript_options', $this->container['enqueue'] );
		}
	}
	
	public function offsetExists( $offset ) {
		return isset( $this->container[$offset] );
	}
	
	public function offsetGet( $offset ) {
		return isset( $this->container[$offset] ) ? 
			$this->container[$offset] : null;
			
	}
	
	public function offsetSet( $offset, $value ) {
		if (is_null( $offset ) ) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}
	
	public function offsetUnset( $offset ) {
		unset( $this->container[$offset] );
	}
}
