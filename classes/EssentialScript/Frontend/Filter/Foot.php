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

namespace EssentialScript\Frontend\Filter;

/**
 * Filter class for Footer section of the Web site.
 *
 * @author docwho
 */
class Foot implements \EssentialScript\Frontend\Filter\Strategy {
	/**
	 * @var string The filename.
	 */
	private $filename;
	/**
	 * @var string The script.
	 */
	private $script;
	/**
	 * @var string Where the script is saved: file or database.
	 */
	private $storage;
	/**
	 * @var bool If this filter should use wp_enqueue_scripts hook.
	 */	
	private $enqueue;

	/**
	 * Initialization parameters: see above for detailed descriptions.
	 * 
	 * @param string $filename
	 * @param string $script
	 * @param string $storage
	 * @param bool $enqueue
	 */
	public function __construct( $array_options ) {
		
		$this->filename = $array_options['filename'];
		$this->script = $array_options['script'];
		$this->storage = $array_options['storage'];
		$this->enqueue = $array_options['enqueue'];
	}
	
	/**
	 * Filter function.
	 * 
	 * @return null If something goes wrong or uses wp_enqueue_scripts.
	 */
	public function filter() {
		// Only use wp_enqueue_scripts with file storage.
		if ( ( 'file' === $this->storage ) && ( true === $this->enqueue ) && 
			file_exists( $this->filename ) ) {
			add_action( 'wp_enqueue_scripts', function() {
				wp_enqueue_script( 'essential-script', 
					substr( $this->filename, strlen( ABSPATH )-1 ),
					array(),
					null,
					true );
			});
			return;
		}
		/* has_action checks if any action has been registered for a 
		 * hook. 
		 * wp_footer may not be available on all themes, so you should 
		 * take this into account when using it. has_action avoids 
		 * the problem.
		 */
		if ( !has_action( 'wp_footer' ) ) {
			return;
		}

		if ( ( 'file' === $this->storage ) && file_exists( $this->filename ) ) {
			$this->script = file_get_contents( $this->filename );
		} 
		
		if ( $this->script === false ) {
			$this->print_error();
		}
		
		/* The only time script code should be added to this hook is when
		 * it's not located in a separate file. We have not a separate file
		 * when storage is wpdb.
		 */
		add_action( 'wp_footer', array ( $this, 'the_script' ), 20 );
	}
	
	/**
	 * Print a message error if this filter has encountered a problem.
	 */
	public function print_error() {
		wp_die( get_bloginfo( 'name' ) . 
				'has encountered a problem and needs to close. '
				. 'We are sorry for the inconvenience.' );		
	}

	/**
	 * Output the script. This function shouldn't return, and shouldn't take 
	 * any parameters. 
	 */	
	public function the_script( $content ) {

		// Output the script only when Head or Footer filters are used.		
		if ( !empty( $this->script ) ) {
			echo $this->script;
		} 
	}
}
