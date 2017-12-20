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
	 * Ex:
	 * 	a:10:{
	 *      s:4:"name";s:25:"es59e08b5e7c4822.61452256";
	 *		s:11:"highlighter";s:3:"xml";	  
	 *      s:6:"script";s:0:"";
	 *      s:5:"where";s:4:"head";
	 *      s:5:"pages";a:4:{s:5:"index";b:1;
	 *                       s:6:"single";b:1;
	 *                       s:4:"page";b:1;
	 *                       s:7:"archive";b:0;}
	 *      s:7:"enqueue";b:0;
	 *      s:7:"storage";s:4:"file";
	 *      s:4:"path";s:53:"/var/www/sandbox/portfolio/wp-content/uploads/2017/11";
	 *      s:8:"filename";s:25:"es59e08b5e7c4822.61452256";
	 *		s:11: "filefeature";a:2:{
	 *						s:5:"async";b:0;
	 *						s:5:"defer";b:0;}
	 * }
	 * 
	 * @var array
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
