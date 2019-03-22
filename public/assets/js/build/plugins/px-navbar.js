

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxNavbar
// --------------------------------------------------

var PxNavbar = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxNavbar';
  var DATA_KEY = 'px.navbar';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var ClassName = {
    NAVBAR: 'px-navbar',
    INNER: 'px-navbar-collapse-inner',
    IN: 'in',
    COLLAPSED: 'collapsed'
  };

  var Selector = {
    DATA_TOGGLE: '.navbar-toggle[data-toggle="collapse"]',
    DROPDOWN_TOGGLE: '.dropdown-toggle[data-toggle="dropdown"]',
    COLLAPSE: '.navbar-collapse',
    DROPDOWN: '.dropdown'
  };

  var Event = {
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY,
    RESIZE: 'resize' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    MOUSEDOWN: 'mousedown' + EVENT_KEY,
    COLLAPSE_SHOW: 'show.bs.collapse' + EVENT_KEY,
    COLLAPSE_SHOWN: 'shown.bs.collapse' + EVENT_KEY,
    COLLAPSE_HIDDEN: 'hidden.bs.collapse' + EVENT_KEY,
    DROPDOWN_SHOWN: 'shown.bs.dropdown' + EVENT_KEY,
    DROPDOWN_HIDDEN: 'hidden.bs.dropdown' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Navbar = function () {
    function Navbar(element) {
      _classCallCheck(this, Navbar);

      if (!$.fn.perfectScrollbar) {
        throw new Error('Scrolling feature requires the "perfect-scrollbar" plugin included.');
      }

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.$collapse = $(element).find(Selector.COLLAPSE);
      this.$toggle = $(element).find(Selector.DATA_TOGGLE);

      this._scrollbarEnabled = 0;
      this._curScrollTop = 0;

      if (!this.$collapse.length || !this.$toggle.length) {
        return;
      }

      this.$inner = this._setupInnerContainer();

      this._setListeners();
    }

    // getters

    _createClass(Navbar, [{
      key: 'updateScrollbar',


      // public

      value: function updateScrollbar() {
        if (!this._scrollbarEnabled) {
          return;
        }

        this._updateHeight();

        this.$inner.scrollTop(this._curScrollTop).perfectScrollbar('update');
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();

        this._disableScrollbar();

        this.$collapse.append(this.$inner.find('> *'));

        this.$inner.remove();

        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_updateHeight',
      value: function _updateHeight() {
        var maxHeight = $(window).height() - this.$collapse[0].offsetTop;

        this.$collapse.height('');

        var curHeight = this.$collapse.height();

        if (curHeight > maxHeight) {
          this.$collapse.height(maxHeight + 'px');
        }
      }
    }, {
      key: '_enableScrollbar',
      value: function _enableScrollbar() {
        if (this._scrollbarEnabled) {
          return;
        }

        this._updateHeight();
        this.$inner.perfectScrollbar({ suppressScrollX: true });

        this._scrollbarEnabled = 1;
      }
    }, {
      key: '_disableScrollbar',
      value: function _disableScrollbar() {
        if (!this._scrollbarEnabled) {
          return;
        }

        this.$collapse.height('');
        this.$inner.perfectScrollbar('destroy');

        this._scrollbarEnabled = 0;
      }
    }, {
      key: '_setupInnerContainer',
      value: function _setupInnerContainer() {
        var $inner = $('<div class="' + ClassName.INNER + '"></div>');

        $inner.append(this.$collapse.find('> *'));

        this.$collapse.append($inner);

        return $inner;
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        var _this = this;

        var self = this;

        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, function () {
          if (!_this._scrollbarEnabled) {
            return;
          }

          // TODO: Remove dependency on toggle button
          if (_this.$toggle.is(':visible')) {
            _this._curScrollTop = _this.$inner[0].scrollTop;
            _this.updateScrollbar();
          } else {
            _this._disableScrollbar();
            _this.$collapse.removeClass(ClassName.IN);
            _this.$toggle.addClass(ClassName.COLLAPSED);
            _this.$collapse.attr('aria-expanded', 'false');
            _this.$toggle.attr('aria-expanded', 'false');
          }
        });

        $(this.element).on(this.constructor.Event.COLLAPSE_SHOW, Selector.COLLAPSE, function () {
          _this.$collapse.find('.dropdown.open').removeClass('open');
        }).on(this.constructor.Event.COLLAPSE_SHOWN, Selector.COLLAPSE, function () {
          _this._enableScrollbar();
        }).on(this.constructor.Event.COLLAPSE_HIDDEN, Selector.COLLAPSE, function () {
          _this._disableScrollbar();
        }).on(this.constructor.Event.DROPDOWN_SHOWN + ' ' + this.constructor.Event.DROPDOWN_HIDDEN, Selector.DROPDOWN, function () {
          _this.updateScrollbar();
        }).on(this.constructor.Event.MOUSEDOWN, Selector.DROPDOWN_TOGGLE, function () {
          if (!_this._scrollbarEnabled) {
            return true;
          }

          _this._curScrollTop = _this.$inner[0].scrollTop;
        }).on(this.constructor.Event.CLICK, Selector.DROPDOWN_TOGGLE, function (e) {
          if (!self._scrollbarEnabled) {
            return true;
          }
          if (this.getAttribute('href') === '#') {
            return true;
          }

          // Prevent dropdown open
          e.preventDefault();
          e.stopPropagation();

          // Simulate link click and prevent dropdown toggling
          this.removeAttribute('data-toggle');
          this.click();
          this.setAttribute('data-toggle', 'dropdown');
        });
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
        $(this.element).off(EVENT_KEY);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(method) {
        for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
          args[_key - 1] = arguments[_key];
        }

        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          if (!data) {
            data = new Navbar(this);
            $(this).data(DATA_KEY, data);

            if (!$.support.transition && $(this).find(Selector.DATA_TOGGLE).attr('aria-expanded') === 'true') {
              data._enableScrollbar();
            }
          }

          if (typeof method === 'string') {
            if (!data[method]) {
              throw new Error('No method named "' + method + '"');
            }
            data[method].apply(data, args);
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

    return Navbar;
  }();

  /**
   * ------------------------------------------------------------------------
   * Data Api implementation
   * ------------------------------------------------------------------------
   */

  $(document).on(Event.CLICK_DATA_API, '.' + ClassName.NAVBAR + ' ' + Selector.DATA_TOGGLE, function (e) {
    e.preventDefault();

    var $target = $(this).parents('.' + ClassName.NAVBAR);

    if (!$target.length) {
      return;
    }

    if (!$target.data(DATA_KEY)) {
      Navbar._jQueryInterface.call($target);
    }
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Navbar._jQueryInterface;
  $.fn[NAME].Constructor = Navbar;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Navbar._jQueryInterface;
  };

  return Navbar;
}(jQuery);
//# sourceMappingURL=px-navbar.js.map
