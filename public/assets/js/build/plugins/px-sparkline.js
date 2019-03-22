

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxSparkline
// --------------------------------------------------

var PxSparkline = function ($) {
  'use strict';

  if (!$.fn.sparkline) {
    throw new Error('jquery.sparkline.js required.');
  }

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxSparkline';
  var DATA_KEY = 'px.sparkline';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Event = {
    RESIZE: 'resize' + EVENT_KEY
  };

  var DEFAULT_BAR_SPACING = '2px';

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var PxSparklineCls = function () {
    function PxSparklineCls(element, values, config) {
      _classCallCheck(this, PxSparklineCls);

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.$parent = $(element.parentNode);

      // Get intial HTML
      var wrap = document.createElement('div');

      wrap.appendChild(this.element.cloneNode(true));
      this._initialHTML = wrap.innerHTML;

      this.update(values, config);

      this._setListeners();
    }

    // getters

    _createClass(PxSparklineCls, [{
      key: 'update',


      // public

      value: function update(values, config) {
        if (values !== null) {
          this._values = values;
        }

        if (config !== null) {
          // Set defaults
          if (config.width === '100%' && (config.type === 'bar' || config.type === 'tristate') && typeof config.barSpacing === 'undefined') {
            config.barSpacing = DEFAULT_BAR_SPACING;
          }

          this.config = config;
        }

        // Copy config
        var _config = $.extend(true, {}, this.config);

        if (_config.width === '100%') {
          if (_config.type === 'bar' || _config.type === 'tristate') {
            _config.barWidth = this._getBarWidth(this.$parent, this._values.length, _config.barSpacing);
          } else {
            _config.width = this.$parent.width();
          }
        }

        $(this.element).sparkline(this._values, _config);
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        this._unsetListeners();
        $(this.element).removeData(DATA_KEY);

        // Remove html element
        $(this._initialHTML).insertAfter(this.element);
        $(this.element).remove();
      }

      // private

    }, {
      key: '_getBarWidth',
      value: function _getBarWidth($parent, barsCount, spacer) {
        var width = $parent.width();
        var span = parseInt(spacer, 10) * (barsCount - 1);

        return Math.floor((width - span) / barsCount);
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        var _this = this;

        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, function () {
          if (_this.config.width !== '100%') {
            return;
          }

          // Copy config
          var _config = $.extend(true, {}, _this.config);

          if (_config.type === 'bar' || _config.type === 'tristate') {
            _config.barWidth = _this._getBarWidth(_this.$parent, _this._values.length, _config.barSpacing);
          } else {
            _config.width = _this.$parent.width();
          }

          $(_this.element).sparkline(_this._values, _config);
        });
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
      }

      // static

    }], [{
      key: '_parseArgs',
      value: function _parseArgs(element, args) {
        var values = void 0;
        var config = void 0;

        if (Object.prototype.toString.call(args[0]) === '[object Array]' || args[0] === 'html' || args[0] === null) {
          values = args[0];
          config = args[1] || null;
        } else {
          config = args[0] || null;
        }

        if ((values === 'html' || values === undefined) && values !== null) {
          values = element.getAttribute('values');

          if (values === undefined || values === null) {
            values = $(element).html();
          }

          values = values.replace(/(^\s*<!--)|(-->\s*$)|\s+/g, '').split(',');
        }

        if (!values || Object.prototype.toString.call(values) !== '[object Array]' || values.length === 0) {
          values = null;
        }

        return { values: values, config: config };
      }
    }, {
      key: '_jQueryInterface',
      value: function _jQueryInterface() {
        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
          args[_key] = arguments[_key];
        }

        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var method = args[0] === 'update' || args[0] === 'destroy' ? args[0] : null;

          var _PxSparklineCls$_pars = PxSparklineCls._parseArgs(this, method ? args.slice(1) : args);

          var values = _PxSparklineCls$_pars.values;
          var config = _PxSparklineCls$_pars.config;


          if (!data) {
            data = new PxSparklineCls(this, values || [], config || {});
            $(this).data(DATA_KEY, data);
          }

          if (method === 'update') {
            data.update(values, config);
          } else if (method === 'destroy') {
            data.destroy();
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

    return PxSparklineCls;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = PxSparklineCls._jQueryInterface;
  $.fn[NAME].Constructor = PxSparklineCls;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return PxSparklineCls._jQueryInterface;
  };

  return PxSparklineCls;
}(jQuery);
//# sourceMappingURL=px-sparkline.js.map
