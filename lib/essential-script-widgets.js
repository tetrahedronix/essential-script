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

// Avalaible triggers: widget-added, widget-updated, widget-synced 
jQuery(document).on('widget-added', function() {
    editor=widgetCodemirror();
    editor.refresh();
    console.log("widget-added:");
});
jQuery(document).on('widget-updated', function() {
    editor=widgetCodemirror();
    editor.refresh();
    console.log("widget-updated:");
}); 
jQuery(document).on('widget-synced', function() {
    console.log("widget-synced:");
});
function widgetCodemirror() {
    var selector = 'textarea[id^="widget-essential_script"';
    var textarea_node=document.querySelectorAll(selector);
    if ((typeof textarea_node[1] !== 'undefined')&&(textarea_node.length>0)) {
        var editor = CodeMirror.fromTextArea(textarea_node[1], {
            lineNumbers: true,
            mode: { name: "xml", htmlMode: true },
            lineWrapping: true,
            viewportMargin: Infinity,
            autofocus: true,
            readOnly: true,
            dragDrop: false
        }); 
        editor.refresh(); 
        return editor;
    }
}