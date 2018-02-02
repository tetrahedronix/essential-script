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
 * Description of Pointer
 *
 * @author docwho
 */
abstract class Pointers {
	
	const ESSENTIALSCRIPT_DISMISSED_POINTER = 'dismissed_escript_pointers';
	const ESSENTIALSCRIPT_VER = '0.9';
	
	public function __construct() {
		//  WordPress global variable associated with the current user
		global $current_user;
		// Retrieves the information pertaining to the currently logged in user
		get_currentuserinfo();
		// Determine if dismissed_escript_pointers is present in wp_usermeta
		$havemeta = metadata_exists( 'user', $current_user->ID,
			self::ESSENTIALSCRIPT_DISMISSED_POINTER );
		// Adds meta data to a user if there is no assigned meta.
		if ( ! $havemeta ) {
			add_user_meta( get_current_user_id(),
			self::ESSENTIALSCRIPT_DISMISSED_POINTER, '', false );
		}
	}
	
	abstract public function displayPointer(); 
	
	public function enqueueScript() {
		wp_register_script(
			'wp-essentialscript-pointers',
			plugins_url( 'lib/wp-essentialscript-pointers.js',
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ), array (),
			self::ESSENTIALSCRIPT_VER, false );
		
		wp_enqueue_script( 'wp-essentialscript-pointers' );
		//wp_enqueue_style( 'wp-pointer' );
		//wp_enqueue_script( 'wp-pointer' );
	}
	
	abstract public function footerScript();
}
