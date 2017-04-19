/**
 * Plugin File Management For SummerNote
 * @author Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 */
(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}(function ($) {

  // Extends plugins for adding hello.
  //  - plugin is external module for customizing.
  $.extend($.summernote.plugins, {
    /**
     * @param {Object} context - context object has status of editor.
     */
    'filemanager': function (context) {
      var self = this;

      // ui has renders to build ui elements.
      //  - you can create a button with `ui.button`
      var ui = $.summernote.ui;

      // add hello button
      context.memo('button.filemanager', function () {
        // create button
        var button = ui.button({
          contents: '<i class="fa fa-picture-o text-red"/> Quản lý file',
          tooltip: 'Quản lý file',
          click: function () {
            //   if (typeof fileManager === 'undefined') {
            //       var fileManager = new FileManage($('#fileManagerType').val(), $('#fileManagerPath').val());
            //   }
              fileManager.okCallback = function(file) {
                  context.invoke('editor.insertImage', file.url, file.name);
              };
              fileManager.showBox();
          }
        });

        // create jQuery object from button instance.
        var $hello = button.render();
        return $hello;
      });

      // This events will be attached when editor is initialized.
      this.events = {
        // This will be called after modules are initialized.
        'summernote.init': function (we, e) {},
        // This will be called when user releases a key on editable.
        'summernote.keyup': function (we, e) {}
      };

      // This method will be called when editor is initialized by $('..').summernote();
      // You can create elements for plugin
      this.initialize = function () {};

      // This methods will be called when editor is destroyed by $('..').summernote('destroy');
      // You should remove elements on `initialize`.
      this.destroy = function () {};
    }
  });
}));
