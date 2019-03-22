

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxTabResize
// --------------------------------------------------

var PxTabResize = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxTabResize';
  var DATA_KEY = 'px.tab-resize';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    template: '\n<li class="dropdown">\n  <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>\n  <ul class="dropdown-menu"></ul>\n</li>',
    content: '<span class="tab-resize-icon"></span>'
  };

  var ClassName = {
    TAB_RESIZE: 'tab-resize',
    TAB_RESIZE_NAV: 'tab-resize-nav',
    SHOW: 'show',
    ACTIVE: 'active'
  };

  var Selector = {
    NAV_ITEMS: '> li:not(.tab-resize)',
    NAV_LINK: '> a',
    DROPDOWN_TOGGLE: '> .dropdown-toggle',
    DROPDOWN_MENU: '> .dropdown-menu',
    DROPDOWN_ITEMS: '> li'
  };

  var Event = {
    RESIZE: 'resize' + EVENT_KEY,
    SHOWN: 'shown.bs.tab' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var TabResize = function () {
    function TabResize(element, config) {
      _classCallCheck(this, TabResize);

      this.uniqueId = pxUtil.generateUniqueId();
      this.config = this._getConfig(config);

      this.element = element;
      pxUtil.addClass(element, ClassName.TAB_RESIZE_NAV);

      this.navItem = this._createNavItemElement();
      this.navLink = this._getNavLinkElement();
      this.dropdown = this._getDropdownElement();

      this._setListeners();

      this.placeTabs();
    }

    // getters

    _createClass(TabResize, [{
      key: 'placeTabs',


      // public

      value: function placeTabs() {
        this._resetDropdown();

        var $navItems = $(this.element).find(Selector.NAV_ITEMS);
        var curIndex = $navItems.length - 1;
        var curNavItem = $navItems[curIndex];
        var offsetTop = curNavItem ? $navItems[0].offsetTop : 0;

        if (!curNavItem || curNavItem.offsetTop <= offsetTop) {
          pxUtil.removeClass(this.navItem, ClassName.SHOW);
          return;
        }

        // Show dropdown menu
        pxUtil.addClass(this.navItem, ClassName.SHOW);

        while (curNavItem) {
          if (curNavItem.offsetTop <= offsetTop) {
            break;
          }

          this._moveItemToDropdown(curNavItem);

          curNavItem = $navItems[--curIndex];
        }
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();
        this._resetDropdown();
        this.navItem.remove();
        pxUtil.removeClass(this.element, ClassName.TAB_RESIZE_NAV);
        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_createNavItemElement',
      value: function _createNavItemElement() {
        var navItem = $(this.config.template).addClass(ClassName.TAB_RESIZE)[0];

        this.element.insertBefore(navItem, this.element.firstChild);

        return navItem;
      }
    }, {
      key: '_getNavLinkElement',
      value: function _getNavLinkElement() {
        return $(this.navItem).find(Selector.DROPDOWN_TOGGLE).html(this.config.content)[0];
      }
    }, {
      key: '_getDropdownElement',
      value: function _getDropdownElement() {
        return $(this.navItem).find(Selector.DROPDOWN_MENU)[0];
      }
    }, {
      key: '_moveItemToDropdown',
      value: function _moveItemToDropdown(_navItem) {
        $(this.dropdown).prepend(_navItem);

        // Check if nav item is active
        if (pxUtil.hasClass(_navItem, ClassName.ACTIVE)) {
          pxUtil.addClass(this.navItem, ClassName.ACTIVE);
          this.navLink.innerHTML = $(_navItem).find(Selector.NAV_LINK)[0].innerHTML;
        }
      }
    }, {
      key: '_resetDropdown',
      value: function _resetDropdown() {
        pxUtil.removeClass(this.navItem, ClassName.ACTIVE);
        this.navLink.innerHTML = this.config.content;

        $(this.element).append($(this.dropdown).find(Selector.DROPDOWN_ITEMS));
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, $.proxy(this.placeTabs, this));

        $(this.element).on(this.constructor.Event.SHOWN, $.proxy(this.placeTabs, this));
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
        $(this.element).off(EVENT_KEY);
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        return $.extend({}, this.constructor.Default, config);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new TabResize(this, _config);
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

    return TabResize;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = TabResize._jQueryInterface;
  $.fn[NAME].Constructor = TabResize;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return TabResize._jQueryInterface;
  };

  return TabResize;
}(jQuery);
//# sourceMappingURL=px-tab-resize.js.map
