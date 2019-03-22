

var pxUtil = function () {
  'use strict';

  var classListSupported = 'classList' in document.documentElement;

  /* Based on https://github.com/toddmotto/apollo */

  function forEach(items, fn) {
    var itemsArray = Object.prototype.toString.call(items) === '[object Array]' ? items : items.split(' ');

    for (var i = 0; i < itemsArray.length; i++) {
      fn(itemsArray[i], i);
    }
  }

  var _hasClass = classListSupported ? function (elem, className) {
    return elem.classList.contains(className);
  } : function (elem, className) {
    return new RegExp('(?:^|\\s)' + className + '(?:\\s|$)').test(elem.className);
  };

  var _addClass = classListSupported ? function (elem, className) {
    return elem.classList.add(className);
  } : function (elem, className) {
    if (_hasClass(elem, className)) {
      return;
    }
    elem.className += (elem.className ? ' ' : '') + className;
  };

  var _removeClass = classListSupported ? function (elem, className) {
    return elem.classList.remove(className);
  } : function (elem, className) {
    if (!_hasClass(elem, className)) {
      return;
    }
    elem.className = elem.className.replace(new RegExp('(?:^' + className + '\\s+)|(?:^\\s*' + className + '\\s*$)|(?:\\s+' + className + '$)', 'g'), '').replace(new RegExp('\\s+' + className + '\\s+', 'g'), ' ');
  };

  var _toggleClass = classListSupported ? function (elem, className) {
    return elem.classList.toggle(className);
  } : function (elem, className) {
    return (_hasClass(elem, className) ? _removeClass : _addClass)(elem, className);
  };

  /*** ***/

  return {
    // Based on http://stackoverflow.com/a/34168882
    generateUniqueId: function generateUniqueId() {
      // desired length of Id
      var idStrLen = 32;

      // always start with a letter -- base 36 makes for a nice shortcut
      var idStr = (Math.floor(Math.random() * 25) + 10).toString(36) + '_';

      // add a timestamp in milliseconds (base 36 again) as the base
      idStr += new Date().getTime().toString(36) + '_';

      // similar to above, complete the Id using random, alphanumeric characters
      do {
        idStr += Math.floor(Math.random() * 35).toString(36);
      } while (idStr.length < idStrLen);

      return idStr;
    },
    escapeRegExp: function escapeRegExp(str) {
      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    },
    hexToRgba: function hexToRgba(color, opacity) {
      var hex = color.replace('#', '');
      var r = parseInt(hex.substring(0, 2), 16);
      var g = parseInt(hex.substring(2, 4), 16);
      var b = parseInt(hex.substring(4, 6), 16);

      return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + opacity + ')';
    },


    // Triggers native resize event
    triggerResizeEvent: function triggerResizeEvent() {
      var event = void 0;

      if (document.createEvent) {
        event = document.createEvent('HTMLEvents');
        event.initEvent('resize', true, true);
      } else {
        event = document.createEventObject();
        event.eventType = 'resize';
      }

      event.eventName = 'resize';

      if (document.createEvent) {
        window.dispatchEvent(event);
      } else {
        window.fireEvent('on' + event.eventType, event);
      }
    },
    hasClass: function hasClass(elem, className) {
      return _hasClass(elem, className);
    },
    addClass: function addClass(elem, classes) {
      forEach(classes, function (className) {
        return _addClass(elem, className);
      });
    },
    removeClass: function removeClass(elem, classes) {
      forEach(classes, function (className) {
        return _removeClass(elem, className);
      });
    },
    toggleClass: function toggleClass(elem, classes) {
      forEach(classes, function (className) {
        return _toggleClass(elem, className);
      });
    }
  };
}();
//# sourceMappingURL=util.js.map
