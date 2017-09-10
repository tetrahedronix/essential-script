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

namespace EssentialScript\Admin;

/**
 * Essential Script Widget
 * 
 * Creates a widget for adding the script to your sidebar. 
 * Please visit https://codex.wordpress.org/Widgets_API for more details
 * about this class.
 *
 * @author docwho
 */
class Widget extends \WP_Widget {
	
	private $options;
	
	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		// Essential Script options.
		$this->options = new \EssentialScript\Core\Options;
		// Widget options
		$widget_opts = array (
			/* According mathiasbynens.be/demo/crazy-class,
			 * __CLASS__ is valid css name.
			 */
			'classname' => __CLASS__,   // class name added to the <li> element.
			'description' => 'Essential Script Widget'
		);
		parent::__construct( __CLASS__, 'Essential Script', $widget_opts );
	}
	
	/**
	 * Displays the widget form in Apparence/Widgets menu.
	 * 
	 * @param array $instance
	 */
	public function form( $instance ) {
		echo __CLASS__;
	}
	
	/**
	 * Outputs the content of the Widget.
	 * 
	 * @param array $arg
	 * @param array $instance
	 */
	public function widget( $arg, $instance ) {
		echo __CLASS__;
	}
	
	/**
	 * Processing widget options on save.
	 * 
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {
		
	}
}
