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
	 * @var bool If the script has to appear on the front end with wp_enqueue_scripts.
	 */
	private $enqueue;
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
		// Full path to filename of our script.
		$file_obj = new \EssentialScript\Core\File( $opts );
		$this->filename = $file_obj->getfilename();
		// The script.
		$this->script = $opts->offsetExists( 'script' ) ? 
			$opts->offsetGet( 'script' ) : '';
		$this->storage = $opts->offsetExists( 'storage' ) ?
			$opts->offsetGet( 'storage' ) : '';
		$this->enqueue = $opts->offsetExists( 'enqueue' ) ?
			$opts->offsetGet( 'enqueue' ) : false;
	}
	
	/**
	 * Router.
	 * 
	 * This function routes the data to the correct filter.
	 */
	public function router() {

		switch ( $this->options['where'] ) {
			case 'head':
				// Initialize the filter with our data.
				$filter = new \EssentialScript\Frontend\Head(
					$this->filename,
					$this->script,
					$this->storage,
					$this->enqueue ); 
				break;
			case 'content':
				$filter = new \EssentialScript\Frontend\Content(
					$this->filename,
					$this->script,
					$this->storage );
				break;
			case 'shortcode':
				$filter = new \EssentialScript\Frontend\Shortcode(
					$this->filename,
					$this->script,
					$this->storage );
				break;
			case 'foot':
				$filter = new \EssentialScript\Frontend\Footer(
					$this->filename,
					$this->script,
					$this->storage,
					$this->enqueue );
				break;
		}
		// This instance allows to manipulate the output.
		return $filter;
	}
}
