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
	
	private $options;
	
	public function __construct( $opts ) {
		$this->options = $opts;
		
	}
	
	public function inclusion( $filter_obj ) {
		/* User typically reads one page at a time */
		if ( ( is_front_page() && is_home() ) && 
				true === $this->options['pages']['index'] ) {
			// Default homepage is included.
		} elseif ( is_single() && ( true === $this->options['pages']['single'] ) ) {
			// Single post is included.
		} elseif ( is_page() && ( true === $this->options['pages']['page'] ) ) {
			// Page is included.
		} elseif ( ( is_archive() && 
				( true === $this->options['pages']['archive'] ) ) ) {
			// Archive is included.
		} else {
			return;
		}
		
		$filter_obj->filter();
	}
}
