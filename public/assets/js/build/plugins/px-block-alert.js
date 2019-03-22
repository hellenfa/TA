

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

// Plugins / PxBlockAlert
// --------------------------------------------------

var PxBlockAlert = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxBlockAlert';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    type: null,
    style: null,
    namespace: 'default',
    animate: true,
    timer: 0,
    closeButton: true
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var BlockAlert = {

    // public

    add: function add($el, content) {
      var _config = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

      if (!content) {
        throw new Error('Content is not specified');
      }

      var config = BlockAlert._getConfig(_config);
      var $container = BlockAlert._getContainer($el);
      var namespaceClass = 'px-block-alerts-namespace--' + config.namespace;

      var $namespaceContainer = $($container.find('.' + namespaceClass)[0] || $('<div class="' + namespaceClass + '"></div>').appendTo($container)[0]);

      var $alert = $('<div class="alert"></div>');

      if (config.closeButton) {
        $alert.append('<button type="button" class="close">×</button>');
      }

      if (config.type) {
        $alert.addClass('alert-' + config.type);
      }

      if (config.style) {
        $alert.addClass('alert-' + config.style);
      }

      $alert.addClass(namespaceClass + '__alert').append(content);

      $container.removeClass('px-block-alerts-empty');

      if (config.animate) {
        $alert.css('display', 'none').attr('data-animate', 'true');
      }

      $namespaceContainer.append($alert);

      if (config.animate) {
        $alert.slideDown(300);
      }

      if (config.timer) {
        $alert.data('px-block-alert-timer', setTimeout(function () {
          return BlockAlert.remove($el, $alert, config.animate);
        }, 1000 * config.timer));
      }
    },
    remove: function remove($el, $target) {
      var animate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

      var $alert = $el.find($target);

      if (!$alert.length) {
        return;
      }

      var timer = $alert.data('px-block-alert-timer');

      if (timer) {
        clearTimeout(timer);
        $alert.data('px-block-alert-timer', null);
      }

      function done() {
        var $container = $el.find('> .px-block-alerts');

        $alert.remove();

        if (!$container.find('.alert').length) {
          $container.addClass('px-block-alerts-empty');
        }
      }

      if ($alert.attr('data-animate') === 'true' && animate === true) {
        return $alert.slideUp(300, done);
      }

      done();
    },
    clear: function clear($el) {
      var namespace = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'default';
      var animate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

      if (typeof namespace !== 'string') {
        throw new Error('Namespace must be a string.');
      }

      var $namespaceContainer = $el.find('> .px-block-alerts .px-block-alerts-namespace--' + namespace);

      if (!$namespaceContainer.length) {
        return;
      }

      $namespaceContainer.find('.alert').each(function () {
        BlockAlert.remove($el, $(this), animate);
      });
    },
    clearAll: function clearAll($el) {
      var animate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

      $el.find('> .px-block-alerts .alert').each(function () {
        BlockAlert.remove($el, $(this), animate);
      });
    },
    destroy: function destroy($el) {
      var $container = $el.find('> .px-block-alerts');

      if (!$container.length) {
        return;
      }

      BlockAlert._unsetListeners($container);
      $container.remove();
    },


    // private

    _getContainer: function _getContainer($el) {
      var $container = $el.find('> .px-block-alerts');

      if (!$container.length) {
        $container = $('<div class="px-block-alerts"></div>');

        if (!$el.hasClass('panel')) {
          $container.prependTo($el);
        } else {
          var $header = $el.find('> .panel-heading');

          if (!$header.length) {
            $header = $el.find('> .panel-subtitle');
          }

          if (!$header.length) {
            $header = $el.find('> .panel-title');
          }

          if ($header.length) {
            $container.insertAfter($header.first());
          } else {
            $container.prependTo($el);
          }
        }
      }

      if (!$container.data('pxBlockAlert-listenersDefined')) {
        BlockAlert._setListeners($container);
        $container.data('pxBlockAlert-listenersDefined', true);
      }

      return $container;
    },
    _getConfig: function _getConfig(config) {
      var result = $.extend({}, Default, config);

      result.animate = !(result.animate === 'false' || result.animate === false);
      result.closeButton = !(result.closeButton === 'false' || result.closeButton === false);
      result.timer = parseInt(String(result.timer), 10) || 0;

      return result;
    },
    _setListeners: function _setListeners($container) {
      $container.on('click', '.close', function () {
        BlockAlert.remove($container.parent(), $(this).parents('.alert'));
      });
    },
    _unsetListeners: function _unsetListeners($container) {
      $container.off();
    }
  };

  function _jQueryInterface() {
    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    return this.each(function () {
      if (['remove', 'clear', 'clearAll', 'destroy'].indexOf(args[0]) !== -1) {
        return BlockAlert[args[0]].apply(null, [$(this)].concat(args.slice(1)));
      }

      BlockAlert.add.apply(BlockAlert, [$(this), args[0]].concat(_toConsumableArray(args.slice(1))));
    });
  }

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = _jQueryInterface;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return _jQueryInterface;
  };

  return BlockAlert;
}(jQuery);
//# sourceMappingURL=px-block-alert.js.map
