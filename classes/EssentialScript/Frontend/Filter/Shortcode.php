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
 * This filter class add your shortcode  by using Shortcode API.
 *
 * @author docwho
 */
class Shortcode implements \EssentialScript\Frontend\Filter\Strategy {
	/**
	 * @var string Script filename.
	 */
	private $filename;
	/**
	 * @var string Uses this property when the database is selected.
	 */	
	private $script;
	/**
	 * @var type Storage space where the script can be kept.
	 */	
	private $storage;
	
	/**
	 * Initialization parameters: see above for detailed descriptions.
	 * 
	 * @param type $filename
	 * @param type $script
	 * @param type $storage
	 */
	public function __construct( $array_options ) {
		// Save the parameters in the class properties.
		$file_obj = new \EssentialScript\Core\File( $array_options );
		// Full path to filename of our script.
		$this->filename = $file_obj->getfilename();
		$this->script = $array_options->offsetExists( 'script' ) ? 
			$array_options->offsetGet( 'script' ) : '';
		$this->storage = $array_options->offsetExists( 'storage' ) ?
			$array_options->offsetGet( 'storage' ) : '';
	}

	/**
	 * Filter function.
	 * 
	 * @return null If something goes wrong.
	 */
	public function filter() {
		if ( ( 'file' === $this->storage ) && file_exists( $this->filename ) ) {
			$this->script = file_get_contents( $this->filename );
		} 
			
		if ( empty ( $this->script ) ) {
			return;
		}
		
		if ( $this->script === false ) {
			$this->print_error();
		}

		add_shortcode( 'essential-script', array ( $this, 'the_script' ) ); 
	}
	
	/**
	 * Print a message error if this filter has encountered a problem.
	 */	
	public function print_error() {
		wp_die( get_bloginfo( 'name' ) . 
			' has encountered a problem and needs to close. '
			. 'We are sorry for the inconvenience.' );
	}

	/**
	 * Output the script.
	 * 
	 * @param string $content The original content to be filtered.
	 * @return string The content filtered with or without the script.
	 */	
	public function the_script( $content ) {
		if ( !empty ( $this->script ) ) {
			return $content . $this->script;
		}

		return $content;
	}
}
