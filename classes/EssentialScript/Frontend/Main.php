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

namespace EssentialScript\Frontend;

/**
 * Apply the filter to the current Web page.
 *
 * @author docwho
 */
class Main {
	/**
	 * @var object \ArrayAccess Options object.
	 */
	private $options;
	
	/**
	 * Initialize the class by saving the options.
	 * 
	 * @param \ArrayAccess $opts The Options object.
	 */
	public function __construct( \ArrayAccess $opts ) {
		$this->options = $opts;
	}
	
	/**
	 * Link the filter to the Web page.
	 * 
	 * @param object $filter_obj
	 * @return null If something goes wrong.
	 */
	public function inclusion( $filter_obj ) {
		/* User typically reads one page at a time */
		if ( ( is_front_page() && is_home() ) && 
				true === $this->options['pages']['index'] ) {
			/* Default homepage is included.
			 * Manipulate the filter if necessary here. 
			 */
		} elseif ( is_single() && ( true === $this->options['pages']['single'] ) ) {
			/* Single post is included.
			 * Manipulate the filter if necessary here. 
			 */
		} elseif ( is_page() && ( true === $this->options['pages']['page'] ) ) {
			/* Page is included.
			 * Manipulate the filter if necessary here. 
			 */
		} elseif ( ( is_archive() && 
				( true === $this->options['pages']['archive'] ) ) ) {
			/* Archive is included.
			 * Manipulate the filter if necessary here.
			 */
		} else {
			return;
		}
		// Apply filter.
		$filter_obj->filter();
	}
}
