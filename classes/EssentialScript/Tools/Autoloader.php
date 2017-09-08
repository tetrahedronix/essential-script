<?php
/**
 * @package Essential_Script\Tools
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
namespace EssentialScript\Tools;

/**
 * Autoloader automatically loads the files that we need without having 
 * to manually load them in our code. It uses spl_autoload_register().
 */
class Autoloader {
	/**
	 * Setup class.
	 */
	function __construct() {
		spl_autoload_register( array ( $this, 'autoload' ) );
	}
	/**
	 *  Automatically load our namespaced files.
	 * 
	 * @param string $package Namespace including the class.
	 * @return On error
	 */
	public function autoload( $package ) {
		
		// If the specified $class_name does not include our namespace, return.
		if ( false === strpos( $package, ESSENTIAL_SCRIPT1_PLUGIN_PACKAGE ) ) {
			return;
		}
		// Get last word preceded by \ in package.
		$class_name =  substr( strrchr( $package, '\\' ), 1 );
		$lenght = strlen( $class_name );
		
		if ( $lenght == 0 ) {
			return;
		}
		// Remove the class name from package.
		$namespace = substr( $package, 0, -$lenght );
		/*
         * Get a copy of $namespace where all occurrences of \ character in
         * $namespace have been translated to the DIRECTORY_SEPARATOR character.
         */
		$dir = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace );
		// Self explanatory.
		require_once ( ESSENTIAL_SCRIPT1_PLUGIN_DIR . 
				'classes' . DIRECTORY_SEPARATOR . $dir . $class_name . '.php' );
	}
}
