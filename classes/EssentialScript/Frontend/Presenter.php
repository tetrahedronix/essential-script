<?php
/**
 * @package Essential_Script\Frontend
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
namespace EssentialScript\Frontend;

/**
 * Presentation layer
 *
 * Manage the end-user facing views of the plugin.
 * 
 * @author docwho
 */
class Presenter {
	/**
	 * @var array Array container with essential options for use the filter.
	 */
	private $options = array ();
	/**
	 * Setup class.
	 * 
	 * @param \ArrayAccess $opts Instance of the Options object.
	 */
	public function __construct() {
		
		$this->options = new \EssentialScript\Core\Options;
	}
	
	/**
	 * Router.
	 * 
	 * This function routes the data to the correct filter.
	 * 
	 * @return object $filter The filter to use.
	 */
	public function router() {
		
		// Prevents uncaught error if class name is an invalid string.
		if ( ! isset( $this->options['where'] ) ) {
			return null;
		}
		// Trigger: does use of variable function to fire the correct method.
		$func = "\\EssentialScript\\Frontend\Filter\\" . 
			ucwords( $this->options['where'] );
		// Uses Strategy pattern.
		$context_filter = new \EssentialScript\Frontend\Filter\Context(
			new $func( clone ( $this->options ) )
		);
		
		// This instance allows to manipulate the output.
		return $context_filter;
	}
}
