wp.essentialScriptWidgets=(function($){
    'use strict';
    
    var component={
        idBases:['essential_script']
    };
    
    component.essentialScriptWidgetControl=Backbone.View.extend({
        events: {}
    });
    
    component.editorCodeMirror=function editorCodeMirror(baseSelector){
        var selector, textarea_node;
        selector='widget-'+baseSelector+'-content';
        console.log('selector:');
        console.log(selector);
        textarea_node=document.getElementById(selector);
        console.log('textarea_node:');
        console.log(textarea_node);
        if(textarea_node){
            var editor = CodeMirror.fromTextArea(textarea_node, {
                lineNumbers: true,
                mode: { name: "xml", htmlMode: true },
                lineWrapping: true,
                viewportMargin: Infinity,
                autofocus: true,
                readOnly: true,
                dragDrop: false
            }); 
            return editor;
        }
    };
    
    component.init=function init(id){
      console.log('id:');
      console.log(id);  
      var $document=$(document);
      $document.on('widget-added', component.handleWidgetAdded);
      $document.on('widget-synced widget-updated', component.handleWidgetUpdated); 
      $(function initializeExistingWidget(){
        var widgetContainers;
        if( 'widgets'!==window.pagenow){
            return;
        }
        widgetContainers=$('.widgets-holder-wrap:not(#available-widgets)').find('div.widget');
        console.log('widgetContainers:');
        console.log(widgetContainers);
        widgetContainers.one('click.toggle-widget-expaded',function toggleWidgetExpanded(){
           var widgetContainer=$(this);
           component.widgetAdded(new jQuery.Event('widget-added'),widgetContainer);
        });
      });
    };
    
    component.widgetControls={};
    
    component.widgetAdded=function(event, widgetContainer){
        var widgetForm,idBase,widgetId,fieldContainer,syncContainer,widgetControl,renderWhenAnimationDone,animatedCheckDelay=50,editor;
        console.log('event:');
        console.log(event);
        console.log('widgetContainer:');
        console.log(widgetContainer);
        widgetForm=widgetContainer.find('> .widget-inside > .form, > .widget-inside > form');
        console.log('widgetForm:');
        console.log(widgetForm);
        idBase=widgetForm.find('> .id_base').val();
        console.log('idBase:');
        console.log(idBase);
        if ( -1===component.idBases.indexOf(idBase)){
            return;
        }
        widgetId=widgetForm.find('.widget-id').val();
        console.log('widgetId:');
        console.log(widgetId);
        if(component.widgetControls[widgetId]){
            return;
        }
        fieldContainer=$('<div></div>');
        console.log('fieldContainer:');
        console.log(fieldContainer);
        syncContainer=widgetContainer.find('.widget-content:first');
        console.log('syncContainer:');
        console.log(syncContainer);
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
            console.log('editor:');
            console.log(editor);
            editor.refresh();
          }
        };
        renderWhenAnimationDone();
        
        
    };
    
    component.widgetUpdated=function(){
        
    };

    
    return component;
})(jQuery);
