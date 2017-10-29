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

namespace EssentialScript\Core;

/**
 * Helper class for file management.
 *
 * @author docwho
 */
class File {

	/**
	 * @var string The filename 
	 */
	private $filename;
	/**
	 * @var object \ArrayAccess Options object. 
	 */
	private $options;
	/**
	 * Initialize the class.
	 * 
	 * @param \ArrayAccess $opts The Options object.
	 */
	public function __construct( \ArrayAccess $opts ) {
		/**
		 * Save the options available in the class.
		 */
		$this->options = $opts;
		// Full path to filename of our script.
		if ( $opts->offsetExists( 'path' ) && $opts->offsetExists( 'filename' ) ) {
			$this->filename = $this->options['path'] . '/' . $this->options['filename'];
		} else {
			$this->filename = null;
		}
	}
	/**
	 * Getter
	 * 
	 * @return mixed Return filename or false.
	 */
	public function getfilename() {
		return is_string( $this->filename ) ? $this->filename : false;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getcontent() {
		
		switch ( $this->options['storage'] ) {
			case 'wpdb':
				$script = $this->options['script'];
				break;
			case 'file':
				//$dir = wp_upload_dir();
				//$f = $dir['path'] . '/' . $options['filename'];
				$f = $this->options['path'] . '/' . $this->options['filename'];
				if ( file_exists( $f ) ) {
					$script = file_get_contents( $f );
				} else {
					add_settings_error(
						// slug title for our settings.
						'essentialscript_messages',
						// slug name for this error/event
						'essentialscript_file_error',
						// The formatted message text to display.
						__('File ' . $f . ' Not found', 'essential-script'),
						// The type of message it is: error/updated
						'error'								
					);
					settings_errors();
					$script = '';
				}
					break;
			default:
				$script = '';
			}
			
			return $script;
	}
	
}
