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
 * Description of class
 *
 * @author docwho
 */
class Filter {
	private $script;
	private $storage;
	private $enqueue;
	private $filename;
	
	public function enqueue_script() {
		wp_enqueue_script( 'essential-script', 
			substr( $this->filename, strlen( ABSPATH )-1 ),
			array(),
			null,
			true );
	}
	
	public function init( $script, $storage, $enqueue, $filename ) {
		$this->script = $script;
		$this->storage = $storage;
		$this->enqueue = $enqueue;
		$this->filename = $filename;
	}
	/**
	 * Append the script to the post content
	 */
	public function content() {
		
		if ( ( 'file' === $this->storage ) && file_exists( $this->filename ) ) {
			$this->script = file_get_contents( $this->filename );
		} 
		
		if ( empty ( $this->script ) ) {
			// Do not do nothing
			return;
		} 
		
		if ( $this->script === false ) {
			$this->print_error();
		}

		// We can't use wp_enqueue_script.
		add_filter( 'the_content', array ( $this, 'the_script' ) );

	}
	
	public function footer() {
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
	
	public function head() {
		// Only use wp_enqueue_scripts with file storage.
		if ( ( 'file' === $this->storage ) && ( true === $this->enqueue ) && 
			file_exists( $this->filename ) ) {
			add_action( 'wp_enqueue_scripts', function() {
				wp_enqueue_script( 'essential-script', 
					substr( $this->filename, strlen( ABSPATH )-1 ) );
			});
			return;
		}
		
		if ( !has_action( 'wp_head' ) ) {
			return;
		}
		
		if ( ( 'file' === $this->storage ) && file_exists( $this->filename ) ) {
			$this->script = file_get_contents( $this->filename );
		}
		
		if ( $this->script === false ) {
			$this->print_error();
		}
		
		add_action( 'wp_head', array( $this, 'the_script' ) );
	}
	
	public function print_error() {
		wp_die( get_bloginfo( 'name' ) . 
				'has encountered a problem and needs to close. '
				. 'We are sorry for the inconvenience.' );
	}
	
	public function the_script( $content = '' ) {
		if ( 'the_content' === current_filter() ) {
			return $content . $this->script;
		}
		
		if ( !empty( $this->script ) ) {
			echo $this->script;
		} 
	}
}
