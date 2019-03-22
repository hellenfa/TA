

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

// Extensions / Dropzone
// --------------------------------------------------

(function ($, Dropzone) {
  'use strict';

  if (!Dropzone) {
    throw new Error('dropzone.js required.');
  }

  var dropzoneError = Dropzone.prototype.defaultOptions.error;

  // Extend Dropzone default options
  Dropzone.prototype.defaultOptions = $.extend({}, Dropzone.prototype.defaultOptions, {
    previewTemplate: '\n<div class="dz-preview dz-file-preview">\n  <div class="dz-details">\n    <div class="dz-filename" data-dz-name></div>\n    <div class="dz-size" data-dz-size></div>\n    <div class="dz-thumbnail">\n      <img data-dz-thumbnail>\n      <span class="dz-nopreview">No preview</span>\n      <div class="dz-success-mark"></div>\n      <div class="dz-error-mark"></div>\n      <div class="dz-error-message"><span data-dz-errormessage></span></div>\n    </div>\n  </div>\n  <div class="progress">\n    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>\n  </div>\n</div>',
    addRemoveLinks: true,

    error: function error(file, message) {
      var result = dropzoneError.call(this, file, message);

      if (file.previewElement) {
        $(file.previewElement).find('.progress-bar-success').removeClass('progress-bar-success').addClass('progress-bar-danger');
      }

      return result;
    }
  });

  // jQuery plugin
  $.fn.dropzone = function (config) {
    for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
      args[_key - 1] = arguments[_key];
    }

    return this.each(function () {
      var data = $(this).data('dropzone');
      var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

      if (!data) {
        data = new Dropzone(this, _config);
        $(this).data('dropzone', data);
      }

      if (typeof config === 'string') {
        var _data;

        if (!data[config]) {
          throw new Error('No method named "' + config + '".');
        }
        (_data = data)[config].apply(_data, args);
      }
    });
  };
})(jQuery, window.Dropzone);
//# sourceMappingURL=dropzone.js.map
