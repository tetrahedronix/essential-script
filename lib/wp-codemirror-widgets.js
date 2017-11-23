wp.essentialScriptWidgets=(function($){
    'use strict';
    
    var component={
        idBases:['essential_script'],
        codeEditorSettings: {}
    };
    
    component.essentialScriptWidgetControl=Backbone.View.extend({
        events: {}
    });
    
    component.editorCodeMirror=function editorCodeMirror(baseSelector){
        var selector, textarea_node;
        selector='widget-'+baseSelector+'-content';
        textarea_node=document.getElementById(selector);
        if(textarea_node){
            var editor = wp.CodeMirror.fromTextArea(textarea_node,
                component.codeEditorSettings
            ); 
            return editor;
        }
    };
    
    component.init=function init(settings,id){
      component.idBases=id;
      _.extend(component.codeEditorSettings,settings);
      var $document=$(document);
      $document.on('widget-added', component.widgetAdded);
      $document.on('widget-synced widget-updated', component.widgetUpdated); 
      $(function initializeExistingWidget(){
        var widgetContainers;
        if( 'widgets'!==window.pagenow){
            return;
        }
        widgetContainers=$('.widgets-holder-wrap:not(#available-widgets)').find('div.widget');
        widgetContainers.one('click.toggle-widget-expaded',function toggleWidgetExpanded(){
           var widgetContainer=$(this);
           component.widgetAdded(new jQuery.Event('widget-added'),widgetContainer);
        });
      });
    };
    
    component.widgetControls={};
    
    component.widgetAdded=function(event, widgetContainer){
        var widgetForm,idBase,widgetId,fieldContainer,syncContainer,widgetControl,renderWhenAnimationDone,animatedCheckDelay=50,editor;
        widgetForm=widgetContainer.find('> .widget-inside > .form, > .widget-inside > form');
        idBase=widgetForm.find('> .id_base').val();
        if ( -1===component.idBases.indexOf(idBase)){
            return;
        }
        widgetId=widgetForm.find('.widget-id').val();
        if(component.widgetControls[widgetId]){
            return;
        }
        fieldContainer=$('<div></div>');
        syncContainer=widgetContainer.find('.widget-content:first');
        syncContainer.before(fieldContainer);
        widgetControl=new component.essentialScriptWidgetControl({
           el: fieldContainer,
           syncContainer: syncContainer
        });
        component.widgetControls[widgetId]=widgetControl;
        renderWhenAnimationDone=function(){
          if(!(wp.customize?widgetContainer.parent().hasClass('expanded'):widgetContainer.hasClass('open'))){
              setTimeout(renderWhenAnimationDone,animatedCheckDelay);
          }else{
            editor=component.editorCodeMirror(widgetId);
            editor.refresh();
          }
        };
        renderWhenAnimationDone();
        
        
    };
    
    component.widgetUpdated=function(event, widgetContainer){
        var widgetForm,idBase,widgetId,widgetControl,editor;
        
        widgetForm=widgetContainer.find('> .widget-inside > .form, > .widget-inside > form');
        idBase=widgetForm.find('> .id_base').val();
        if(-1===component.idBases.indexOf(idBase)){
            return;
        }
        widgetId=widgetForm.find('> .widget-id').val();
        widgetControl=component.widgetControls[widgetId];
        if(!widgetControl){
            return;
        }
        editor=component.editorCodeMirror(widgetId);
        editor.refresh();
    };

    
    return component;
})(jQuery);
