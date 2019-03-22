

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxSidebar
// --------------------------------------------------

var PxSidebar = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxSidebar';
  var DATA_KEY = 'px.sidebar';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    width: null,
    enableScrollbar: true,
    desktopMode: ['lg', 'xl']
  };

  var ClassName = {
    NAVBAR_FIXED: 'px-navbar-fixed',
    LEFT: 'px-sidebar-left'
  };

  var Event = {
    RESIZE: 'resize' + EVENT_KEY,
    SCROLL: 'scroll' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY,

    EXPAND: 'expand' + EVENT_KEY,
    EXPANDED: 'expanded' + EVENT_KEY,
    COLLAPSE: 'collapse' + EVENT_KEY,
    COLLAPSED: 'collapsed' + EVENT_KEY
  };

  var Selector = {
    DATA_TOGGLE: '[data-toggle="sidebar"]',
    CONTENT: '.px-sidebar-content',
    NAVBAR_HEADER: '> .px-navbar .navbar-header'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Sidebar = function () {
    function Sidebar(element, config) {
      _classCallCheck(this, Sidebar);

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.$content = $(element).find(Selector.CONTENT);
      this.parent = element.parentNode;

      this.config = this._getConfig(config);

      this._isRtl = $('html').attr('dir') === 'rtl';

      this._setWidth();
      this._setScrollbar();
      this._checkMode();

      this._setListeners();
    }

    // getters

    _createClass(Sidebar, [{
      key: 'toggle',


      // public

      value: function toggle() {
        if (!this._triggerPreventableEvent(pxUtil.hasClass(this.element, 'open') ? 'COLLAPSE' : 'EXPAND', this.element)) {
          return;
        }

        pxUtil.toggleClass(this.element, 'open');

        this._triggerEvent(pxUtil.hasClass(this.element, 'open') ? 'EXPANDED' : 'COLLAPSED', this.element);
      }
    }, {
      key: 'update',
      value: function update() {
        var $navbarHeader = $(this.parent).find(Selector.NAVBAR_HEADER);

        if ($navbarHeader.length) {
          var height = $navbarHeader.height();

          if (pxUtil.hasClass(this.parent, ClassName.NAVBAR_FIXED) || !this._positioning) {
            this.element.style.top = height + 'px';
          } else {
            var scrollTop = this.parent === document.body ? document.documentElement && document.documentElement.scrollTop || document.body.scrollTop : this.parent.scrollTop;

            this.element.style.top = scrollTop > height ? '0px' : height - scrollTop + 'px';
          }
        }

        if (this.config.enableScrollbar) {
          this.$content.perfectScrollbar('update');
        }
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();
        this._unsetScrollbar();
        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_setWidth',
      value: function _setWidth() {
        var width = parseInt(this.config.width || $(this.element).width(), 10);

        var pos = void 0;

        if (!this._isRtl) {
          pos = pxUtil.hasClass(this.element, ClassName.LEFT) ? 'left' : 'right';
        } else {
          pos = pxUtil.hasClass(this.element, ClassName.LEFT) ? 'right' : 'left';
        }

        this.element.style.width = width + 'px';
        this.element.style[pos] = '-' + width + 'px';
      }
    }, {
      key: '_checkMode',
      value: function _checkMode() {
        this._positioning = this.config.desktopMode.indexOf(window.PixelAdmin.getScreenSize()) !== -1;

        this.update();
      }
    }, {
      key: '_setScrollbar',
      value: function _setScrollbar() {
        if (!this.config.enableScrollbar) {
          return;
        }

        if (!this.$content.length) {
          throw new Error('.px-sidebar-content element is not found.');
        }

        this.$content.perfectScrollbar();
      }
    }, {
      key: '_unsetScrollbar',
      value: function _unsetScrollbar() {
        if (!this.config.enableScrollbar || !this.$content.length) {
          return;
        }

        this.$content.perfectScrollbar('destroy');
      }
    }, {
      key: '_triggerEvent',
      value: function _triggerEvent(eventKey, target) {
        var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

        $(this.element).trigger($.Event(this.constructor.Event[eventKey], { target: target }), [data]);
      }
    }, {
      key: '_triggerPreventableEvent',
      value: function _triggerPreventableEvent(eventKey, target) {
        var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

        var event = $.Event(this.constructor.Event[eventKey], { target: target });

        $(this.element).trigger(event, [data]);

        return !event.isDefaultPrevented();
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, $.proxy(this._checkMode, this)).on(this.constructor.Event.SCROLL + '.' + this.uniqueId, $.proxy(this.update, this));
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId).off(this.constructor.Event.SCROLL + '.' + this.uniqueId);
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        return $.extend({}, this.constructor.Default, $(this.element).data(), config);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new Sidebar(this, _config);
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

    return Sidebar;
  }();

  /**
   * ------------------------------------------------------------------------
   * Data Api implementation
   * ------------------------------------------------------------------------
   */

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (e) {
    e.preventDefault();

    var selector = this.getAttribute('data-target');
    var target = selector ? $(selector)[0] : null;

    if (!target) {
      return;
    }

    if (!$(target).data(DATA_KEY)) {
      Sidebar._jQueryInterface.call($(target), $(this).data());
    }

    Sidebar._jQueryInterface.call($(target), 'toggle');
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Sidebar._jQueryInterface;
  $.fn[NAME].Constructor = Sidebar;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Sidebar._jQueryInterface;
  };

  return Sidebar;
}(jQuery);
//# sourceMappingURL=px-sidebar.js.map
