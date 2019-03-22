

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxValidate
// --------------------------------------------------

var PxValidate = function ($) {
  'use strict';

  if (!$.fn.validate) {
    throw new Error('jquery.validate.js required.');
  }

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxValidate';
  var DATA_KEY = 'px.validate';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var ClassName = {
    FORM_HELP: 'form-help-text',
    HAS_ERROR: 'has-validation-error',
    ERROR: 'validation-error',
    CONTAINER: 'validation-container',
    NO_ARROW: 'validation-error-no-arrow'
  };

  var Default = {
    errorElement: 'div',
    errorClass: 'form-message ' + ClassName.ERROR
  };

  var CONTAINER_REGEX = new RegExp('(^|\\s)(?:' + ClassName.CONTAINER + '|form-group|col-(?:xs|sm|md|lg)-\\d+)(\\s|$)');

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var PxValidator = function () {
    function PxValidator(element, config) {
      _classCallCheck(this, PxValidator);

      this.element = element;

      this.validator = $(element).validate(this._getConfig(element, config));
    }

    // getters

    _createClass(PxValidator, [{
      key: 'getValidator',


      // public

      value: function getValidator() {
        return this.validator;
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this.validator.destroy();
        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_highlight',
      value: function _highlight(control) {
        pxUtil.addClass($(control).parents('.form-group')[0], 'has-error ' + ClassName.HAS_ERROR);
      }
    }, {
      key: '_unhighlight',
      value: function _unhighlight(control) {
        pxUtil.removeClass($(control).parents('.form-group')[0], 'has-error ' + ClassName.HAS_ERROR);
      }
    }, {
      key: '_errorPlacement',
      value: function _errorPlacement($error, $element) {
        var $container = $(this._getParentContainer($element[0]));

        if (!$container.length) {
          return;
        }

        // Remove an old error
        $container.find('.' + ClassName.ERROR).remove();

        // Check if the element is a checkbox or radio
        //

        var elementType = $element[0].getAttribute('type');

        // Normalize type to avoid bugs
        elementType = elementType ? elementType.toLowerCase() : null;

        if (elementType === 'checkbox' || elementType === 'radio') {
          pxUtil.addClass($error[0], ClassName.NO_ARROW);
        }

        // Append error
        //

        var $helpBlock = $container.find('.' + ClassName.FORM_HELP).first();

        if ($helpBlock.length) {
          $error.insertBefore($helpBlock);
        } else {
          $container.append($error);
        }
      }
    }, {
      key: '_getParentContainer',
      value: function _getParentContainer(element) {
        var parent = element.parentNode;
        var nodeName = parent.nodeName.toUpperCase();

        if (nodeName === 'FORM' || nodeName === 'BODY') {
          console.error(new Error('Cannot find parent container.'));

          return null;
        }

        return CONTAINER_REGEX.test(parent.className) ? parent : this._getParentContainer(parent);
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(element, config) {
        return $.extend({}, this.constructor.Default, {
          highlight: this._highlight,
          unhighlight: this._unhighlight,
          errorPlacement: $.proxy(this._errorPlacement, this)
        }, $(element).data(), config);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        var result = void 0;

        var $el = this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new PxValidator(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            if (!data[config]) {
              throw new Error('No method named "' + config + '".');
            }
            result = data[config]();
          }
        });

        return typeof result !== 'undefined' ? result : $el;
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
    }]);

    return PxValidator;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = PxValidator._jQueryInterface;
  $.fn[NAME].Constructor = PxValidator;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return PxValidator._jQueryInterface;
  };

  return PxValidator;
}(jQuery);
//# sourceMappingURL=px-validate.js.map
