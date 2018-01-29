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

namespace EssentialScript\Core;

/**
 * Helper class: Codemirror interface.
 *
 * @author docwho
 */
class Codemirror {
	
	static private $main_settings = array ( 
		'lineNumbers' => true,
		'mode' => array ( 'name' => 'xml', 'htmlMode' => true ),
		'lint' => true
	);
	/**
	 * Print the basic Codemirror script for the HTML textarea.
	 * 
	 * @param string $highlighter Syntax highlighter to use.
	 */
	static public function fromTextarea( $id, $highlighter ) {

		/*
		 * Enable an option under certain conditions 
		 */		
		switch ( $highlighter ) {
			case 'javascript':
				$mode = array ( 'name' => "javascript" );
				break;
			case 'xml':
			default:
				$mode = array ( 'name' => 'xml', 'htmlMode' => true );
				break;
		}
		
		self::$main_settings['mode'] = $mode;
		
		$settings = json_encode( self::$main_settings );
		$jscode=<<<'JS'
<!-- Codemirror -->   
<script>
(function($,settings) {
	var textarea_node=document.getElementById("%s");
	var editor = wp.CodeMirror.fromTextArea(textarea_node,settings);
})(window.jQuery, %s); 
</script> 
JS
. PHP_EOL;
		echo sprintf( $jscode, $id, $settings );
	}
}
