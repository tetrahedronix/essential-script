<?php

/*
 * Copyright (C) 2018 docwho
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
 * Abstract class that defines the methods and data to be used and set up with
 * the Pointer.
 *
 * @author docwho
 */
abstract class Pointers {
	/**
	 *  Uses provided system metakey instead of custom. It could change later. 
	 */
	const WORDPRESS_DISMISSED_POINTER = 'dismissed_wp_pointers';
	//const ESSENTIALSCRIPT_DISMISSED_POINTER = 'dismissed_essentialscript_pointers';

	/**
	 * @since 0.9
	 */
	const ESSENTIALSCRIPT_VER = '0.9';
	/**
	 * Setup class.
	 */
	public function __construct() {
		// Retrieves the information pertaining to the currently logged in user
		$current_user = wp_get_current_user();
		// Determine if dismissed_wp_pointers is present in wp_usermeta
		$havemeta = metadata_exists( 'user', $current_user->ID,
			self::WORDPRESS_DISMISSED_POINTER );
		// Adds meta data to a user if there is no assigned meta.
		if ( ! $havemeta ) {
			add_user_meta( get_current_user_id(),
			self::WORDPRESS_DISMISSED_POINTER, '', false );
		}
	}
	
	abstract public function displayPointer();
	/**
	 * Registers every functional script for the Pointer
	 */
	public function enqueueScript() {
		wp_register_script(
			'wp-essentialscript-pointers',
			plugins_url( 'lib/wp-essentialscript-pointers.js',
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
			array ( 'wp-util',	// Necessary to use wp.ajax.post
				'wp-a11y',		// Necessary to use wp.a11y.speak
				'wp-sanitize'),	// Necessary to use wp.sanitize
			self::ESSENTIALSCRIPT_VER, false );
		
		wp_enqueue_script( 'wp-essentialscript-pointers' );
		//wp_enqueue_style( 'wp-pointer' );
		//wp_enqueue_script( 'wp-pointer' );
	}
	
	abstract public function footerScript();
}
