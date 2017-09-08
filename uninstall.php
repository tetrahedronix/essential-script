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

// If uninstall.php is not called by WordPress, die
if ( !defined ( 'WP_UNINSTALL_PLUGIN' ) ) {
	die();
}
/* A plugin is considered uninstalled if a user has deactivated the plugin,
 * and then clicks the delete link within the WordPress Admin.
 */

/*
 * A safe way of removing a named option/value pair from the options
 * database table. 
 */
global $wpdb;		// Required by delete_option()
		
delete_option( 'essentialscript_options' );

// drop a custom database table