

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var PixelAdmin = function ($) {
  'use strict';

  var PixelAdminObject = {
    isRtl: document.documentElement.getAttribute('dir') === 'rtl',
    isMobile: /iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()),
    isLocalStorageSupported: typeof window.Storage !== 'undefined',

    // Application-wide options
    options: {
      resizeDelay: 100,
      storageKeyPrefix: 'px_s_',
      cookieKeyPrefix: 'px_c_'
    },

    getScreenSize: function getScreenSize() {
      if (PixelAdminObject._breakpoints.$xs.is(':visible')) {
        return 'xs';
      } else if (PixelAdminObject._breakpoints.$sm.is(':visible')) {
        return 'sm';
      } else if (PixelAdminObject._breakpoints.$md.is(':visible')) {
        return 'md';
      } else if (PixelAdminObject._breakpoints.$lg.is(':visible')) {
        return 'lg';
      }

      return 'xl';
    },


    // Storage
    //

    storage: {
      _prefix: function _prefix(key) {
        return '' + PixelAdminObject.options.storageKeyPrefix + key;
      },
      set: function set(key, value) {
        var obj = typeof key === 'string' ? _defineProperty({}, key, value) : key;
        var keys = Object.keys(obj);

        try {
          for (var i = 0, len = keys.length; i < len; i++) {
            window.localStorage.setItem(this._prefix(keys[i]), obj[keys[i]]);
          }
        } catch (e) {
          PixelAdminObject.cookies.set(key, value);
        }
      },
      get: function get(key) {
        var keys = $.isArray(key) ? key : [key];
        var result = {};

        try {
          for (var i = 0, len = keys.length; i < len; i++) {
            result[keys[i]] = window.localStorage.getItem(this._prefix(keys[i]));
          }

          return $.isArray(key) ? result : result[key];
        } catch (e) {
          return PixelAdminObject.cookies.get(key);
        }
      }
    },

    // Cookies
    //

    cookies: {
      _prefix: function _prefix(key) {
        return '' + PixelAdminObject.options.cookieKeyPrefix + key;
      },
      set: function set(key, value) {
        var obj = typeof key === 'string' ? _defineProperty({}, key, value) : key;
        var keys = Object.keys(obj);

        var encodedKey = void 0;
        var encodedVal = void 0;

        for (var i = 0, len = keys.length; i < len; i++) {
          encodedKey = encodeURIComponent(this._prefix(keys[i]));
          encodedVal = encodeURIComponent(obj[keys[i]]);

          document.cookie = encodedKey + '=' + encodedVal;
        }
      },
      get: function get(key) {
        var cookie = ';' + document.cookie + ';';
        var keys = $.isArray(key) ? key : [key];
        var result = {};

        var escapedKey = void 0;
        var re = void 0;
        var found = void 0;

        for (var i = 0, len = keys.length; i < len; i++) {
          escapedKey = pxUtil.escapeRegExp(encodeURIComponent(this._prefix(keys[i])));
          re = new RegExp(';\\s*' + escapedKey + '\\s*=\\s*([^;]+)\\s*;');
          found = cookie.match(re);

          result[keys[i]] = found ? decodeURIComponent(found[1]) : null;
        }

        return $.isArray(key) ? result : result[key];
      }
    },

    _setBreakpoints: function _setBreakpoints() {
      var $xs = $('<div id="px-breakpoint-xs"></div>');
      var $sm = $('<div id="px-breakpoint-sm"></div>');
      var $md = $('<div id="px-breakpoint-md"></div>');
      var $lg = $('<div id="px-breakpoint-lg"></div>');

      $('body').prepend($xs).prepend($sm).prepend($md).prepend($lg);

      PixelAdminObject._breakpoints = { $xs: $xs, $sm: $sm, $md: $md, $lg: $lg };
    },
    _setDelayedResizeListener: function _setDelayedResizeListener() {
      function delayedResizeHandler(callback) {
        var resizeTimer = null;

        return function () {
          if (resizeTimer) {
            clearTimeout(resizeTimer);
          }

          resizeTimer = setTimeout(function () {
            resizeTimer = null;
            callback();
          }, PixelAdminObject.options.resizeDelay);
        };
      }

      var $window = $(window);
      var prevScreen = null;

      $window.on('resize', delayedResizeHandler(function () {
        var curScreen = PixelAdminObject.getScreenSize();

        $window.trigger('px.resize');

        if (prevScreen !== curScreen) {
          $window.trigger('px.screen.' + curScreen);
        }

        prevScreen = curScreen;
      }));
    }
  };

  PixelAdminObject._setBreakpoints();
  PixelAdminObject._setDelayedResizeListener();

  // Wait for the document load
  $(function () {
    // Remove the .nojs class from the <html> element
    $(document.documentElement).removeClass('nojs');

    if (PixelAdminObject.isMobile && window.FastClick) {
      window.FastClick.attach(document.body);
    }

    // Trigger 'px.load' and 'resize' events on window
    $(window).trigger('px.load');
    pxUtil.triggerResizeEvent();
  });

  return PixelAdminObject;
}(jQuery);

window.PixelAdmin = PixelAdmin;
//# sourceMappingURL=app.js.map
