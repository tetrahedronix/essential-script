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
	
	/**
	 * Print the basic Codemirror script for the HTML textarea.
	 */
	static public function fromtextarea() {
		echo<<<'JS'
<!-- Codemirror -->   
<script>
   var textarea_node=document.getElementById("textarea-script");
   var editor = CodeMirror.fromTextArea(textarea_node, {
		lineNumbers: true,
		mode: { name: "xml", htmlMode: true },
		viewportMargin: Infinity,
		lint: true
});
</script> 
JS
. PHP_EOL;
	}
}
