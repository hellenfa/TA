

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxResponsiveBg
// --------------------------------------------------

var PxResponsiveBg = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxResponsiveBg';
  var DATA_KEY = 'px.responsiveBg';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    backgroundImage: null,
    overlay: false,
    overlayOpacity: 0.2
  };

  var ClassName = {
    CONTAINER: 'px-responsive-bg-container',
    IMAGE: 'px-responsive-bg',
    OVERLAY: 'px-responsive-bg-overlay'
  };

  var Event = {
    RESIZE: 'resize' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var ResponsiveBg = function () {
    function ResponsiveBg(element, config) {
      var _this = this;

      _classCallCheck(this, ResponsiveBg);

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.config = this._getConfig(config);

      this._loadImage(this.config.backgroundImage, function (img) {
        _this._sizeRatio = img.height / img.width;

        _this._setupMarkup(img);
        _this._setListeners();

        _this.update();
      });
    }

    // getters

    _createClass(ResponsiveBg, [{
      key: 'update',


      // public

      value: function update() {
        var parentEl = this.image.parentNode;
        var parentHeight = $(parentEl).height();
        var parentWidth = $(parentEl).width();

        var height = void 0;
        var width = void 0;
        var top = void 0;
        var left = void 0;

        if (parentWidth * this._sizeRatio > parentHeight) {
          width = '100%';
          height = Math.ceil(parentWidth * this._sizeRatio);
          top = Math.floor(-1 * (height - parentHeight) / 2);
          left = 0;
        } else {
          width = Math.ceil(parentHeight / this._sizeRatio);
          height = parentHeight;
          top = 0;
          left = Math.floor(-1 * (width - parentWidth) / 2);
        }

        this.image.style.width = width === '100%' ? width : width + 'px';
        this.image.style.height = height + 'px';
        this.image.style.top = top + 'px';
        this.image.style.left = left + 'px';
      }
    }, {
      key: 'destroy',
      value: function destroy(clearMarkup) {
        this._unsetListeners();

        if (clearMarkup) {
          $(this.element).removeClass(ClassName.CONTAINER).find('> .' + ClassName.IMAGE).remove();
        }

        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_loadImage',
      value: function _loadImage(path, cb) {
        var img = new Image();

        img.onload = function () {
          return cb(img);
        };
        img.src = path;
      }
    }, {
      key: '_setupMarkup',
      value: function _setupMarkup(img) {
        pxUtil.addClass(this.element, ClassName.CONTAINER);

        var $imageContainer = $(this.element).find('> .' + ClassName.IMAGE);

        if (!$imageContainer.length) {
          $imageContainer = $('<div class="' + ClassName.IMAGE + '"></div>').appendTo(this.element);
          $imageContainer.append('<img alt="">');
        }

        this.image = $imageContainer.find('> img')[0];

        if (!this.image) {
          throw new Error('Background <img> element not found!');
        }

        $(this.image).attr('src', img.src);

        if (this.config.overlay !== false) {
          $imageContainer.find('.' + ClassName.OVERLAY).remove();

          $imageContainer.prepend($('<div class="' + ClassName.OVERLAY + '"></div>').css({
            background: typeof this.config.overlay === 'boolean' ? '#000' : this.config.overlay,
            opacity: this.config.overlayOpacity
          }));
        } else {
          $imageContainer.find('> .' + ClassName.OVERLAY).remove();
        }
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, $.proxy(this.update, this));
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        var result = $.extend({}, this.constructor.Default, $(this.element).data(), config);

        if (!result.backgroundImage) {
          throw new Error('Background image is not specified.');
        }

        return result;
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
          args[_key - 1] = arguments[_key];
        }

        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new ResponsiveBg(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            var _data;

            if (!data[config]) {
              throw new Error('No method named "' + config + '"');
            }
            (_data = data)[config].apply(_data, args);
          }
        });
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }, {
      key: 'NAME',
      get: function get() {
        return NAME;
      }
    }, {
      key: 'DATA_KEY',
      get: function get() {
        return DATA_KEY;
      }
    }, {
      key: 'Event',
      get: function get() {
        return Event;
      }
    }, {
      key: 'EVENT_KEY',
      get: function get() {
        return EVENT_KEY;
      }
    }]);

    return ResponsiveBg;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = ResponsiveBg._jQueryInterface;
  $.fn[NAME].Constructor = ResponsiveBg;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return ResponsiveBg._jQueryInterface;
  };

  return ResponsiveBg;
}(jQuery);
//# sourceMappingURL=px-responsive-bg.js.map
