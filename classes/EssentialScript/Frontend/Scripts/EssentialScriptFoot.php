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

namespace EssentialScript\Frontend\Scripts;

/**
 * The Concrete Component: enqueue the script in the footer.
 *
 * @author docwho
 */
class EssentialScriptFoot extends \EssentialScript\Frontend\Scripts\Component {
	/**
	 * @var string Path of the script relative to the WordPress root directory.
	 */
	private $filename;
	
	/**
	 * Setup class.
	 */
	public function __construct() {
		// Array access of the WP options.
		$opts = new \EssentialScript\Core\Options;
		$file_obj = new \EssentialScript\Core\File( $opts );
		// Full path to filename of our script.		
		$this->filename = $file_obj->getfilename();
		$this->handle = 'essential-script';
	}
	
	/**
	 * Register the script and enqueues it.
	 */
	public function enqueueScript() {
		
		wp_enqueue_script( $this->handle, 
					substr( $this->filename, strlen( ABSPATH )-1 ),
					array (), 
					parent::ESSENTIALSCRIPT_VER,
					true );
	}
	
	/**
	 * Getter method.
	 * 
	 * @return string Name of the script. Should be unique.
	 */
	public function getHandle() {
		
		return $this->handle;
	}

}
