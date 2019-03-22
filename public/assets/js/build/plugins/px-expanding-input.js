

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxExpandingInput
// --------------------------------------------------

var PxExpandingInput = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxExpandingInput';
  var DATA_KEY = 'px.expanding-input';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var ClassName = {
    EXPANDED: 'expanded',
    CONTROL: 'expanding-input-control',
    OVERLAY: 'expanding-input-overlay',
    CONTENT: 'expanding-input-content'
  };

  var Event = {
    FOCUS: 'focus' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    EXPAND: 'expand' + EVENT_KEY,
    EXPANDED: 'expanded' + EVENT_KEY,
    COLLAPSE: 'collapse' + EVENT_KEY,
    COLLAPSED: 'collapsed' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var ExpandingInput = function () {
    function ExpandingInput(element) {
      _classCallCheck(this, ExpandingInput);

      this.element = element;
      this.control = $(element).find('.' + ClassName.CONTROL)[0];
      this.overlay = $(element).find('.' + ClassName.OVERLAY)[0];

      this._checkElements();
      this._setListeners();
    }

    // getters

    _createClass(ExpandingInput, [{
      key: 'expand',


      // public

      value: function expand() {
        if (pxUtil.hasClass(this.element, ClassName.EXPANDED)) {
          return;
        }

        var expandEvent = $.Event(this.constructor.Event.EXPAND, {
          target: this.element
        });

        // Trigger before expand event
        $(this.element).trigger(expandEvent);

        if (expandEvent.isDefaultPrevented()) {
          return;
        }

        pxUtil.addClass(this.element, ClassName.EXPANDED);

        // Trigger after expand event
        $(this.element).trigger($.Event(this.constructor.Event.EXPANDED, { target: this.element }));

        // Set focus on input
        $(this.control).trigger('focus');
      }
    }, {
      key: 'collapse',
      value: function collapse() {
        if (!pxUtil.hasClass(this.element, ClassName.EXPANDED)) {
          return;
        }

        var collapseEvent = $.Event(this.constructor.Event.COLLAPSE, {
          target: this.element
        });

        // Trigger before collapse event
        $(this.element).trigger(collapseEvent);

        if (collapseEvent.isDefaultPrevented()) {
          return;
        }

        pxUtil.removeClass(this.element, ClassName.EXPANDED);

        // Trigger after collapse event
        $(this.element).trigger($.Event(this.constructor.Event.COLLAPSED, { target: this.element }));
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();

        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_checkElements',
      value: function _checkElements() {
        if (!pxUtil.hasClass(this.element, 'expanding-input')) {
          throw new Error(NAME + ' plugin must be called on an element with \'expanding-input\' class.');
        }

        if (!this.control) {
          throw new Error('Input is not found.');
        }

        if (!this.overlay) {
          this.overlay = $('<div class="expanding-input-overlay"></div>').insertAfter(this.control)[0];
        }

        if (!$(this.element).find('.' + ClassName.CONTENT)[0]) {
          throw new Error('Content element is not found.');
        }
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        $(this.control).on(this.constructor.Event.FOCUS, $.proxy(this.expand, this));

        $(this.overlay).on(this.constructor.Event.CLICK, $.proxy(this.expand, this));

        // Set listeners on cancel buttons
        $(this.element).find('[data-collapse="true"]').on(this.constructor.Event.CLICK, $.proxy(this.collapse, this));
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(this.control).off(EVENT_KEY);
        $(this.overlay).off(EVENT_KEY);
        $(this.element).find('[data-collapse="true"]').off(EVENT_KEY);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface() {
        return this.each(function (method) {
          var data = $(this).data(DATA_KEY);

          if (!data) {
            data = new ExpandingInput(this);
            $(this).data(DATA_KEY, data);
          }

          if (typeof method === 'string') {
            if (!data[method]) {
              throw new Error('No method named "' + method + '".');
            }
            data[method]();
          }
        });
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

    return ExpandingInput;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = ExpandingInput._jQueryInterface;
  $.fn[NAME].Constructor = ExpandingInput;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return ExpandingInput._jQueryInterface;
  };

  return ExpandingInput;
}(jQuery);
//# sourceMappingURL=px-expanding-input.js.map
