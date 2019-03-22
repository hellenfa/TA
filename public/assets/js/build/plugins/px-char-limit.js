

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxCharLimit
// --------------------------------------------------

var PxCharLimit = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxCharLimit';
  var DATA_KEY = 'px.charLimit';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    maxlength: null,
    counter: ''
  };

  var Event = {
    KEYUP: 'keyup' + EVENT_KEY,
    FOCUS: 'focus' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var CharLimit = function () {
    function CharLimit(element, config) {
      _classCallCheck(this, CharLimit);

      this.element = element;
      this.isTextarea = $(element).is('textarea');
      this.config = this._getConfig(config);
      this.counter = this._getLabel();

      this._setMaxLength();
      this._setListeners();

      this.update();
    }

    // getters

    _createClass(CharLimit, [{
      key: 'update',


      // public

      value: function update() {
        var maxlength = this.config.maxlength;
        var value = this.element.value;
        var charCount = void 0;

        if (this.isTextarea) {
          value = value.replace(/\r?\n/g, '\n');
        }

        charCount = value.length;

        if (charCount > maxlength) {
          this.element.value = value.substr(0, maxlength);
          charCount = maxlength;
        }

        if (this.counter) {
          this.counter.innerHTML = maxlength - charCount;
        }
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();

        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_getLabel',
      value: function _getLabel() {
        if (!this.config.counter) {
          return null;
        }

        return typeof this.config.counter === 'string' ? $(this.config.counter)[0] || null : this.config.counter;
      }
    }, {
      key: '_setMaxLength',
      value: function _setMaxLength() {
        if (!this.isTextarea) {
          this.element.setAttribute('maxlength', this.config.maxlength);
        } else {
          this.element.removeAttribute('maxlength');
        }
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        $(this.element).on(this.constructor.Event.KEYUP, $.proxy(this.update, this)).on(this.constructor.Event.FOCUS, $.proxy(this.update, this));
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(this.element).off(EVENT_KEY);
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        var result = $.extend({}, this.constructor.Default, { maxlength: this.element.getAttribute('maxlength') }, $(this.element).data(), config);

        if (!result.maxlength) {
          throw new Error('maxlength is not specified.');
        }

        // Remove maxlength attribute if the element is a textarea
        if (this.isTextarea && this.element.getAttribute('maxlength')) {
          this.element.removeAttribute('maxlength');
        }

        return result;
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new CharLimit(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            if (!data[config]) {
              throw new Error('No method named "' + config + '"');
            }
            data[config]();
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

    return CharLimit;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = CharLimit._jQueryInterface;
  $.fn[NAME].Constructor = CharLimit;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return CharLimit._jQueryInterface;
  };

  return CharLimit;
}(jQuery);
//# sourceMappingURL=px-char-limit.js.map
