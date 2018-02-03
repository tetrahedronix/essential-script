/* 
 * Copyright (C) 2018 docwho
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
if ( ! window.wp ) {
    window.wp = {};
}

wp.essentialScriptPointers=(function( $ ){
    'use strict';
    var component={};
    
    component.init = function init() {
      component.warning = $('.file-editor-warning');
      if ( component.warning.length > 0 ) {
          component.showWarning();
      }
    };
    
    component.showWarning = function() {
        var rawMessage = component.warning.find('.file-editor-warning-message').text();
        $('#wpwrap').attr('aria-hidden', true);
        $(document.body)
                .addClass('modal-open')
                .append(component.warning.detach());
        component.warning
                .removeClass('hidden')
                .find('.file-editor-warning-go-back').focus();
        component.warningTabbables = component.warning.find('a, button');
        component.warningTabbables.on('keydown',component.constrainTabbing);
        component.warning.on('click',
            '.file-editor-warning-dismiss',
            component.dismissWarning);
        setTimeout( function() {
            wp.a11y.speak( wp.sanitize.stripTags(
                    rawMessage.replace(/\s+/g, ' ') ), 'assertive');
        }, 100 );
    };
    
    component.dismissWarning = function() {
      /* Add our escript_editor_notice to dismiss_wp_pointer metakey */
        wp.ajax.post('dismiss-wp-pointer', {
          pointer: 'escript_editor_notice'
      });  
        /*Should add script_editor_notice to dismiss_essentialscript... metakey
         * wp.ajax.post( 'dismiss-essentialscript-pointer', {
            pointer: 'script_editor_notice'
        } ); */
        
/*        var data = {
            'action': 'dismiss-essentialscript-pointer',
            'whatever': 1234
        };
        $.post(ajaxurl,data,function(response){
            console.log( 'Got this from the server: ' + response ); 
        }); */
        component.warning.remove();
        $('#wpwrap').removeAttr('aria-hidden');
        $('body').removeClass('modal-open');
      
    };
    
    component.constrainTabbing = function(event) {
        var firstTabbable, lastTabbable;
        
        if (9 !== event.which) {
            return;
        }
        firstTabbable = component.warningTabbables.first()[0];
        lastTabbable = component.warningTabbables.last()[0];
        if (lastTabbable === event.target && ! event.shiftKey) {
            firstTabbable.focus();
            event.preventDefault();
        } else if (firstTabbable === event.target && event.shiftKey) {
            lastTabbable.focus();
            event.preventDefault();
        }
    };
    
    return component;
} )( jQuery );
