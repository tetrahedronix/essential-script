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
	 * Container for plugin options.
	 * 
	 * @var array The options contained in the Options object.
	 */
	private $options = array();
	/**
	 *
	 * @var string Script filename.
	 */
	private $filename;
	
	/**
	 * Setup class.
	 * 
	 * @param \ArrayAccess $opts Instance of the Options object.
	 * @return If a page has to be excluded.
	 */
	public function __construct( \ArrayAccess $opts ) {
		/**
		 * Save the options available in the class.
		 */
		$this->options = $opts;
		// The filename of our script.
		$this->filename = $this->options['path'] . '/' . $this->options['filename'];
	}
	
	public function inclusion() {
		/* User typically reads one page at a time */
		if ( ( is_front_page() && is_home() ) && 
				true === $this->options['pages']['index'] ) {
			// Default homepage is included.
			$this->router();
			//return;
		} 
		
		if ( is_single() && ( true === $this->options['pages']['single'] ) ) {
			// Single post is excluded.
			$this->router();
			//return;
		}
		
		if ( is_page() && ( true === $this->options['pages']['page'] ) ) {
			// Page is excluded.
			//return;
			$this->router();
		}
		
		if ( ( is_archive() && 
				( true === $this->options['pages']['archive'] ) ) ) {
			// Archive is excluded.
			//return;
			$this->router();
		}
		//$this->router();
	}
	/**
	 * Router.
	 * 
	 * This function routes the data to the correct filter.
	 */
	private function router() {
		// This instance allows to manipulate the output.
		$filter = new \EssentialScript\Frontend\Filter;
		// Initialize the filter with our data.
		$filter->init( 
				$this->options['script'], 
				$this->options['storage'],
				$this->filename
		);
		// Router
		var_dump ( $this->options['where'] );
		switch ( $this->options['where'] ) {
			case 'content':
				$filter->content();
				break;
			case 'foot':
				$filter->footer();
				break;
			case 'head':
				$filter->head();
				break;
		}
	}
}
