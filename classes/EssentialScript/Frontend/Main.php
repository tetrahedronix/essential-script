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
	 * @var object	The object reference of the concrete filter
	 */
	private $filter_obj;
	
	/**
	 * Initialize the class by saving the options.
	 */
	public function __construct() {
		
		$this->options = new \EssentialScript\Core\Options;
	}

	/**
	 * Requires the concrete strategy for Archive page.
	 */
	public function displayArchive() {
		
		$context_page = new \EssentialScript\Frontend\Pages\Context(
			new Pages\Archive );
		$context_page->display( $this->filter_obj );
	}
	
	/**
	 * Requires the concrete strategy for Index page.
	 */
	public function displayIndex() {
		
		$context_page = new \EssentialScript\Frontend\Pages\Context(
			new Pages\Index );
		$context_page->display( $this->filter_obj );
	}
	
	/**
	 * Requires the concrete strategy for the single Page.
	 */
	public function displayPage() {
		
		$context_page = new \EssentialScript\Frontend\Pages\Context(
			new Pages\Page );
		$context_page->display( $this->filter_obj );
	}
	
	/**
	 * Requires the concrete strategy for the single Post.
	 */
	public function displaySingle() {
		
		$context_page = new \EssentialScript\Frontend\Pages\Context(
			new Pages\Single );
		$context_page->display( $this->filter_obj );
	}
	
	/**
	 * Fires the methods for the different concrete strategies.
	 * 
	 * @param type $filter_obj
	 */
	public function trigger( $filter_obj ) {
		
		$this->filter_obj = $filter_obj;
		// Finds each page triggered to the options with boolean true.
		$triggered = array_keys( $this->options['pages'], true );
		// Calls each trigger separately using variable function.
		foreach ( $triggered as $func ) {
			$func = 'display' . ucwords( $func );
			$this->$func();
		}
		
	}
}
