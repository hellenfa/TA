

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxWizard
// --------------------------------------------------

var PxWizard = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxWizard';
  var DATA_KEY = 'px.wizard';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    minStepWidth: 200
  };

  var ClassName = {
    WRAPPER: 'wizard-wrapper',
    STEPS: 'wizard-steps',
    PANE: 'wizard-pane',
    FROZEN: 'frozen',
    FINISHED: 'finished',
    ACTIVE: 'active',
    COMPLETED: 'completed'
  };

  var Event = {
    RESIZE: 'resize' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    CHANGE: 'stepchange' + EVENT_KEY,
    CHANGED: 'stepchanged' + EVENT_KEY,
    FINISH: 'finish' + EVENT_KEY,
    FINISHED: 'finished' + EVENT_KEY,
    FROZEN: 'frozen' + EVENT_KEY,
    UNFROZEN: 'unfrozen' + EVENT_KEY,
    RESETED: 'reseted' + EVENT_KEY,
    DESTROY: 'destroy' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Wizard = function () {
    function Wizard(element, config) {
      _classCallCheck(this, Wizard);

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.steps = $(element).find('.' + ClassName.STEPS)[0];
      this.stepItems = $(this.steps).find('li');
      this.wrapper = $(element).find('.' + ClassName.WRAPPER)[0];
      this.config = this._getConfig(config);

      this.activeStep = null;

      this._isRtl = $('html').attr('dir') === 'rtl';

      this._resetStepsWidth();
      this.resizeStepItems();
      this.goTo(this.getActiveStepIndex());

      this._setListeners();
    }

    // getters

    _createClass(Wizard, [{
      key: 'resizeStepItems',


      // public

      value: function resizeStepItems() {
        var stepCount = this.stepItems.length;
        var curWrapperWidth = $(this.wrapper).width();
        var minWrapperWidth = this.config.minStepWidth * stepCount;

        var newWidth = curWrapperWidth > minWrapperWidth ? Math.floor(curWrapperWidth / stepCount) : this.config.minStepWidth;

        for (var i = 0; i < stepCount; i++) {
          this._setStrictWidth(this.stepItems[i], newWidth);
        }

        if (this.activeStep !== null) {
          this._placeStepsContainer();
        }
      }
    }, {
      key: 'getActiveStepIndex',
      value: function getActiveStepIndex() {
        var curStep = this.activeStep || $(this.steps).find('li.' + ClassName.ACTIVE)[0];

        if (!curStep) {
          return 0;
        }

        return this._getStepIndex(curStep);
      }
    }, {
      key: 'getStepCount',
      value: function getStepCount() {
        return this.stepItems.length;
      }
    }, {
      key: 'goTo',
      value: function goTo(step) {
        if (this.isFrozen() || this.isFinished()) {
          return;
        }

        var stepItem = void 0;
        var stepIndex = void 0;
        var stepTarget = void 0;

        // Get active step index
        var _getStepItemAndTarget2 = this._getStepItemAndTarget(step);

        var _getStepItemAndTarget3 = _slicedToArray(_getStepItemAndTarget2, 3);

        stepIndex = _getStepItemAndTarget3[0];
        stepItem = _getStepItemAndTarget3[1];
        stepTarget = _getStepItemAndTarget3[2];
        var activeStepIndex = this.activeStep ? this._getStepIndex(this.activeStep) : null;

        if (activeStepIndex !== null && stepIndex === activeStepIndex) {
          return;
        }

        if (activeStepIndex !== null) {
          // Trigger before change event
          var eventResult = this._triggerPreventableEvent('CHANGE', this.element, {
            activeStepIndex: activeStepIndex,
            nextStepIndex: stepIndex
          });

          if (!eventResult) {
            return;
          }
        }

        this.activeStep = stepItem;

        this._activateStepItem(stepItem, stepIndex);
        this._activateStepPane(stepTarget);

        if (activeStepIndex !== null) {
          // Trigger after change event
          this._triggerEvent('CHANGED', this.element, {
            prevStepIndex: activeStepIndex,
            activeStepIndex: stepIndex
          });
        }
      }
    }, {
      key: 'getPaneByIndex',
      value: function getPaneByIndex(stepIndex) {
        var _stepItem = void 0;
        var _stepIndex = void 0;
        var stepTarget = void 0;

        var _getStepItemAndTarget4 = this._getStepItemAndTarget(stepIndex);

        var _getStepItemAndTarget5 = _slicedToArray(_getStepItemAndTarget4, 3);

        _stepIndex = _getStepItemAndTarget5[0];
        _stepItem = _getStepItemAndTarget5[1];
        stepTarget = _getStepItemAndTarget5[2];


        return $(stepTarget);
      }
    }, {
      key: 'getActivePane',
      value: function getActivePane() {
        return this.getPaneByIndex(this.getActiveStepIndex());
      }
    }, {
      key: 'goNext',
      value: function goNext() {
        if (this.isFrozen() || this.isFinished()) {
          return;
        }

        var nextIndex = this._getStepIndex(this.activeStep) + 1;

        if (nextIndex >= this.stepItems.length) {
          return this.finish();
        }

        this.goTo(nextIndex);
      }
    }, {
      key: 'goPrev',
      value: function goPrev() {
        if (this.isFrozen() || this.isFinished()) {
          return;
        }

        var prevIndex = this._getStepIndex(this.activeStep) - 1;

        if (prevIndex < 0) {
          return;
        }

        this.goTo(prevIndex);
      }
    }, {
      key: 'finish',
      value: function finish() {
        if (this.isFrozen() || this.isFinished()) {
          return;
        }

        // Trigger before finish event
        if (!this._triggerPreventableEvent('FINISH', this.element)) {
          return;
        }

        var curIndex = this._getStepIndex(this.activeStep);
        var lastIndex = this.stepItems.length - 1;

        if (curIndex !== lastIndex) {
          this.goTo(lastIndex);
        }

        pxUtil.addClass(this.element, ClassName.FINISHED);
        this.freeze();

        // Trigger after finish event
        this._triggerEvent('FINISHED', this.element);
      }
    }, {
      key: 'isFinished',
      value: function isFinished() {
        return pxUtil.hasClass(this.element, ClassName.FINISHED);
      }
    }, {
      key: 'freeze',
      value: function freeze() {
        pxUtil.addClass(this.element, ClassName.FROZEN);

        // Trigger after freeze event
        this._triggerEvent('FROZEN', this.element);
      }
    }, {
      key: 'unfreeze',
      value: function unfreeze() {
        if (this.isFinished()) {
          return;
        }

        pxUtil.removeClass(this.element, ClassName.FROZEN);

        // Trigger after unfreeze event
        this._triggerEvent('UNFROZEN', this.element);
      }
    }, {
      key: 'isFrozen',
      value: function isFrozen() {
        return pxUtil.hasClass(this.element, ClassName.FROZEN);
      }
    }, {
      key: 'reset',
      value: function reset() {
        var resetSteps = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

        pxUtil.removeClass(this.element, ClassName.FROZEN);
        pxUtil.removeClass(this.element, ClassName.FINISHED);

        if (resetSteps) {
          this.goTo(0);
        }

        // Trigger after reset event
        this._triggerEvent('RESETED', this.element);
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        // Trigger before destroy event
        if (!this._triggerPreventableEvent('DESTROY', this.element)) {
          return;
        }

        this._unsetListeners();
        $(this.element).removeData(DATA_KEY);
      }

      // private

    }, {
      key: '_resetStepsWidth',
      value: function _resetStepsWidth() {
        this.steps.style.width = 'auto';
      }
    }, {
      key: '_setStrictWidth',
      value: function _setStrictWidth(element, width) {
        element.style.minWidth = width + 'px';
        element.style.maxWidth = width + 'px';
        element.style.width = width + 'px';
      }
    }, {
      key: '_getStepItemAndTarget',
      value: function _getStepItemAndTarget(step) {
        var stepItem = void 0;
        var stepIndex = void 0;

        if (typeof step === 'number') {
          stepItem = this.stepItems[step];
          stepIndex = step;

          if (!stepItem) {
            throw new Error('Step item with index "' + step + '" is not found.');
          }
        } else {
          stepItem = step[0] || step;
          stepIndex = this._getStepIndex(stepItem);
        }

        var stepTarget = stepItem.getAttribute('data-target');

        if (!stepTarget) {
          throw new Error('The step item has invalid "data-target" attribute.');
        }

        return [stepIndex, stepItem, stepTarget];
      }
    }, {
      key: '_activateStepItem',
      value: function _activateStepItem(stepItem, index) {
        pxUtil.addClass(stepItem, ClassName.ACTIVE);
        pxUtil.removeClass(stepItem, ClassName.COMPLETED);

        // Add completed and remove active classes for the previous items
        for (var i = 0; i < index; i++) {
          pxUtil.addClass(this.stepItems[i], ClassName.COMPLETED);
          pxUtil.removeClass(this.stepItems[i], ClassName.ACTIVE);
        }

        // Remove completed and active classes for the next items
        for (var j = index + 1, len = this.stepItems.length; j < len; j++) {
          pxUtil.removeClass(this.stepItems[j], ClassName.ACTIVE);
          pxUtil.removeClass(this.stepItems[j], ClassName.COMPLETED);
        }

        this._placeStepsContainer();
      }
    }, {
      key: '_activateStepPane',
      value: function _activateStepPane(selector) {
        var panes = $(this.element).find('.' + ClassName.PANE + '.' + ClassName.ACTIVE);

        // Remove active state
        for (var i = 0, len = panes.length; i < len; i++) {
          pxUtil.removeClass(panes[i], ClassName.ACTIVE);
        }

        // Add active class to target
        pxUtil.addClass($(this.element).find(selector)[0], ClassName.ACTIVE);
      }
    }, {
      key: '_placeStepsContainer',
      value: function _placeStepsContainer() {
        var wrapperWidth = $(this.wrapper).width();
        var stepsWidth = $(this.steps).width();
        var curStepWidth = $(this.activeStep).outerWidth();
        var delta = Math.floor((wrapperWidth - curStepWidth) / 2);
        var curStepX = $(this.activeStep).position().left;
        var offset = void 0;

        if (this._isRtl) {
          curStepX = stepsWidth - curStepX - curStepWidth;
        }

        if (stepsWidth > wrapperWidth && curStepX > delta) {
          offset = -1 * curStepX + delta;

          if (stepsWidth + offset < wrapperWidth) {
            offset = -1 * stepsWidth + wrapperWidth;
          }
        } else {
          offset = 0;
        }

        this.steps.style[this._isRtl ? 'right' : 'left'] = offset + 'px';
      }
    }, {
      key: '_getStepIndex',
      value: function _getStepIndex(stepItem) {
        var stepIndex = void 0;

        for (var i = 0, len = this.stepItems.length; i < len; i++) {
          if (stepItem === this.stepItems[i]) {
            stepIndex = i;
            break;
          }
        }

        if (typeof stepIndex === 'undefined') {
          throw new Error('Cannot find step item index.');
        }

        return stepIndex;
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        var self = this;

        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, $.proxy(this.resizeStepItems, this));

        $(this.steps).on(this.constructor.Event.CLICK, '> li', function () {
          if (!pxUtil.hasClass(this, ClassName.COMPLETED)) {
            return;
          }
          self.goTo(this);
        });

        $(this.element).on(this.constructor.Event.CLICK, '[data-wizard-action]', function () {
          var action = this.getAttribute('data-wizard-action');

          if (action === 'next') {
            return self.goNext();
          }

          if (action === 'prev') {
            return self.goPrev();
          }

          if (action === 'finish') {
            return self.finish();
          }

          throw new Error('Action "' + action + '" is not found.');
        });
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
        $(this.element).off(EVENT_KEY);
        $(this.steps).off(EVENT_KEY);
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
      key: '_getConfig',
      value: function _getConfig(config) {
        return $.extend({}, this.constructor.Default, $(this.element).data(), config);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
          args[_key - 1] = arguments[_key];
        }

        var result = void 0;

        var $el = this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = (typeof config === 'undefined' ? 'undefined' : _typeof(config)) === 'object' ? config : null;

          if (!data) {
            data = new Wizard(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            if (!data[config]) {
              throw new Error('No method named "' + config + '".');
            }
            result = data[config].apply(data, args);
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

    return Wizard;
  }();

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Wizard._jQueryInterface;
  $.fn[NAME].Constructor = Wizard;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Wizard._jQueryInterface;
  };

  return Wizard;
}(jQuery);
//# sourceMappingURL=px-wizard.js.map
