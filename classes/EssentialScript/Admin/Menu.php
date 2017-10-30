<?php
/**
 * @package Essential_Script\Admin
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
namespace EssentialScript\Admin;

/**
 * This class creates a new top-level menu or adds some submenus for it. 
 * 
 * Please visit https://en.wikipedia.org/wiki/Fluent_interface for more
 * details about this class. 
 *
 * @author docwho
 */
class Menu {
	/**
	 * The title of the page show in the browser window.
	 * 
	 * @var string The title of the page.
	 */
	private $page_title;
	/**
	 * The text to be used for the menu displayed on the Dashboard.
	 * 
	 * @var string The text to be used for the menu.
	 */
	private $menu_title;
	/**
	 * The capability required for this menu to be displayed to the user.
	 * 
	 * @var string The capability required.
	 */
	private $cap;
	/**
	 * The slug name to refer to this menu.
	 * 
	 * @var string The slug name.
	 */
	private $menu_slug;
	/**
	 * The function to be called to output the content for the page.
	 * 
	 * @var string The function to be called.
	 */
	private $call_back;
	/**
	 * The URL to the icon to be used for the menu.
	 * 
	 * @var string The URL to the icon. 
	 */
	private $icon_url;
	/**
	 * The position in the menu order this one should appear.
	 * 
	 * @var string The position in the menu.
	 */
	private $pos;
	/**
	 * The resulting page's hook_suffix returned by add_submenu_page.
	 * 
	 * @var string The hook suffix.
	 */
	private static $hook_suffix;

	/**
	 * Setter function.
	 * 
	 * @param string $cap The capability.
	 * @return $this The current object instance of the class.
	 */
	public function capability( $cap = '' ) {
		$this->cap = $cap;
		
		return $this;
	}

	/**
	 * Getter function
	 * 
	 * This function returns the menu hook_suffix.
	 * 
	 * @return string The hook suffix.
	 */
	public static function get_suffix() {
		return self::$hook_suffix;
	}
	
	/**
	 * Setter function.
	 * 
	 * @param string $icon_url URL to a custom image.
	 * @return $this The current object instance of the class.
	 */
	public function icon( $icon_url = '' ) {
		$this->icon_url = $icon_url;
		
		return $this;
	}
	
	/**
	 * Initialize the class with the options.
	 * 
	 * @param \Essentialscript\Admin\Page $obj The options object.
	 * @return $this The current object instance of the class
	 */
	public function init( \EssentialScript\Admin\Page $obj ) {
		$this->call_back = $obj;
		
		return $this;
	}
	
	/**
	 * Create a new top level menu for the plugin
	 * 
	 * @return string The slug name to refer to the main menu.
	 */
	public function main() {
		// Add a top-level menu page. Save the resulting page's hook_suffix.
		self::$hook_suffix = add_menu_page( 
				$this->page_title,
				$this->menu_title,
				$this->cap,
				$this->menu_slug,
				array ( $this->call_back, 'page' ),
				$this->icon_url
		);  
		
		return $this->menu_slug;
	}
	
	/**
	 * Setter function.
	 * 
	 * @param string $pos The position in the menu order this one should appear.
	 * @return $this The current object instance of the class.
	 */
	public function position( $pos ) {
		$this->pos = $pos;
		
		return $this;
	}

	/**
	 * Create a submenu.
	 * 
	 * @param string $parent_slug Top level menu slug
	 */
	public function submenu( $parent_slug ) {
		/* Add a submenu page. Save resulting page's hook_suffix,
		 * or false if the user does not have the capability required.
		 */
		self::$hook_suffix = add_submenu_page(
				$parent_slug,
				$this->page_title, 
				$this->menu_title, 
				$this->cap, 
				$this->menu_slug, 
				array ( $this->call_back, 'page' ) 
		);
		
		return self::$hook_suffix;
	}
	
	/**
	 * Setter function.
	 * 
	 * @param object $obj The page object.
	 * @return $this The current object instance of the class.
	 */
	public function slug( \EssentialScript\Admin\Page $obj ) {
		$this->menu_slug = $obj->getslug();
		
		return $this;
	}
	
	/**
	 * Setter function.
	 * Based on the number of arguments set page_title and menu_title.
	 * 
	 * @return $this The current object instance of the class.
	 */
	public function title() {
		// Returns an array comprising a function's argument list
		$arg_list = func_get_args();
		$numargs = func_num_args();
				
		if ( 1 === $numargs ) {
			$this->menu_title = $this->page_title = $arg_list[0];
		} else {
			$this->page_title = $arg_list[0];
			$this->menu_title = $arg_list[1];
		}

		return $this;
	}

	// Below simple Wrapper functions for submenu().
	
	/**
	 * Adds a submenu to Comments menu.
	 */
	public function comments() {
		self::$hook_suffix = $this->submenu( 'edit-comments.php' );
	}
	 
	/**
	 * Adds a submenu to the Dashboard menu.
	 */
	public function dashboard() {
		self::$hook_suffix = $this->submenu( 'index.php' );
	}
	
	/**
	 * Adds a submenu to Links menu.
	 */
	public function links() {
		self::$hook_suffix = $this->submenu( 'link-manager.php' );
	}
	
	/**
	 * Adds a submenu to Media menu.
	 */
	public function media() {
		self::$hook_suffix = $this->submenu( 'upload.php' );
	}

	/** 
	 * Adds a submenu to Settings menu,
	 */
	public function options() {
		self::$hook_suffix = $this->submenu( 'options-general.php' );
	}
	/**
	 * Adds a submenu to Pages menu.
	 */
	public function pages() {
		self::$hook_suffix = $this->submenu( 'edit.php?post_type=page' );
	}

	/**
	 * Adds a submenu to the Plugins menu.
	 */
	public function plugins() {
		self::$hook_suffix = $this->submenu( 'plugins.php' );
	}
	
	/**
	 * Adds a submenu to the Posts menu.
	 */
	public function posts() {
		self::$hook_suffix = $this->submenu( 'edit.php' );
	}

    /**
	 * Adds a submenu to the Theme menu.
	 */
	public function theme() {
		self::$hook_suffix = $this->submenu( 'themes.php' );
	}
	
	/** 
	 * Adds a submenu to the Tools menu.
	 */
	public function tools() {
		self::$hook_suffix = $this->submenu( 'tools.php' );
	}

	/**
	 * Adds a submenu to the Users menu.
	 */
	public function users() {
		self::$hook_suffix = $this->submenu( 'users.php' );
	}
}
