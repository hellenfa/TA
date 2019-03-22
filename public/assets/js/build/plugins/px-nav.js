

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// Plugins / PxNav
// --------------------------------------------------

var PxNav = function ($) {
  'use strict';

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'pxNav';
  var DATA_KEY = 'px.nav';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    accordion: true,
    transitionDuration: 300,
    dropdownCloseDelay: 400,
    enableTooltips: true,
    animate: true,
    storeState: true,
    storagePrefix: 'px-nav.',

    modes: {
      phone: ['xs'],
      tablet: ['sm', 'md'],
      desktop: ['lg', 'xl']
    }
  };

  var ClassName = {
    NAV: 'px-nav',
    NAV_LEFT: 'px-nav-left',
    CONTENT: 'px-nav-content',
    EXPAND: 'px-nav-expand',
    STATIC: 'px-nav-static',
    COLLAPSE: 'px-nav-collapse',
    ANIMATE: 'px-nav-animate',
    NAV_TRANSITIONING: 'px-nav-transitioning',
    DIMMER: 'px-nav-dimmer',
    FIXED: 'px-nav-fixed',
    OFF_CANVAS: 'px-nav-off-canvas',
    SCROLLABLE_AREA: 'px-nav-scrollable-area',

    ITEM: 'px-nav-item',
    TOOLTIP: 'px-nav-tooltip',
    DROPDOWN: 'px-nav-dropdown',
    DROPDOWN_MENU: 'px-nav-dropdown-menu',
    DROPDOWN_MENU_TITLE: 'px-nav-dropdown-menu-title',
    DROPDOWN_MENU_SHOW: 'px-nav-dropdown-menu-show',
    DROPDOWN_MENU_WRAPPER: 'px-nav-dropdown-menu-wrapper',
    DROPDOWN_MENU_TOP: 'px-nav-dropdown-menu-top',

    OPEN: 'px-open',
    SHOW: 'px-show',
    FREEZE: 'freeze',
    ACTIVE: 'active',
    TRANSITIONING: 'transitioning',

    PERFECT_SCROLLBAR_CONTAINER: 'ps-container',
    NAVBAR_FIXED: 'px-navbar-fixed'
  };

  var Selector = {
    DATA_TOGGLE: '[data-toggle="px-nav"]',
    CONTENT: '.px-nav-content',
    ITEM: '> .px-nav-item',
    ITEM_LABEL: '> a > .px-nav-label',
    ROOT_LINK: '> .px-nav-item:not(.px-nav-dropdown) > a',
    DROPDOWN_LINK: '.px-nav-dropdown > a',
    DROPDOWN_MENU: '> .px-nav-dropdown-menu',
    DROPDOWN_MENU_TITLE: '> .px-nav-dropdown-menu-title',
    OPENED_DROPDOWNS: '> .px-nav-dropdown.px-open',
    SHOWN_DROPDOWNS: '> .px-nav-dropdown.px-show',
    FROZEN_DROPDOWNS: '.px-nav-dropdown.freeze',
    SCROLLABLE_AREA: '.px-nav-scrollable-area',
    NEAR_NAVBAR: '~ .px-navbar'
  };

  var Event = {
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY,
    RESIZE: 'resize' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    MOUSEENTER: 'mouseenter' + EVENT_KEY,
    MOUSELEAVE: 'mouseleave' + EVENT_KEY,
    SCROLL: 'scroll' + EVENT_KEY,

    INITIALIZED: 'initialized',
    EXPAND: 'expand' + EVENT_KEY,
    EXPANDED: 'expanded' + EVENT_KEY,
    COLLAPSE: 'collapse' + EVENT_KEY,
    COLLAPSED: 'collapsed' + EVENT_KEY,
    DESTROY: 'destroy' + EVENT_KEY,
    DROPDOWN_OPEN: 'dropdown-open' + EVENT_KEY,
    DROPDOWN_OPENED: 'dropdown-opened' + EVENT_KEY,
    DROPDOWN_CLOSE: 'dropdown-close' + EVENT_KEY,
    DROPDOWN_CLOSED: 'dropdown-closed' + EVENT_KEY,
    DROPDOWN_FROZEN: 'dropdown-frozen' + EVENT_KEY,
    DROPDOWN_UNFROZEN: 'dropdown-unfrozen' + EVENT_KEY
  };

  var PERFECT_SCROLLBAR_OPTIONS = {
    suppressScrollX: true,
    wheelPropagation: false,
    swipePropagation: false
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Nav = function () {
    function Nav(element, config) {
      _classCallCheck(this, Nav);

      this.uniqueId = pxUtil.generateUniqueId();

      this.element = element;
      this.content = $(element).find(Selector.CONTENT)[0];
      this.config = this._getConfig(config);

      // Internal variables
      this._curMode = this._getMode();
      this._isCollapsed = this._getNavState();
      this._stateChanging = 0;

      this._setupMarkup();

      this.dimmer = $(element).parent().find('> .' + ClassName.DIMMER)[0];

      this._setListeners();

      this._restoreNavState();

      this._detectActiveItem();

      this._enableAnimation();

      this._checkNavbarPosition();

      this._triggerEvent('INITIALIZED', element);
    }

    // getters

    _createClass(Nav, [{
      key: 'toggle',


      // public

      value: function toggle() {
        this[this._curMode !== 'desktop' && pxUtil.hasClass(this.element, ClassName.EXPAND) || this._curMode === 'desktop' && !pxUtil.hasClass(this.element, ClassName.COLLAPSE) ? 'collapse' : 'expand']();
      }
    }, {
      key: 'expand',
      value: function expand() {
        if (this._curMode !== 'phone' && !this.isCollapsed()) {
          return;
        }
        if (this._curMode === 'phone' && pxUtil.hasClass(this.element, ClassName.EXPAND)) {
          return;
        }
        if (!this._triggerPreventableEvent('EXPAND', this.element)) {
          return;
        }

        if (this._curMode !== 'phone') {
          this.closeAllDropdowns();
        }

        if (this.config.enableTooltips) {
          this._clearTooltips();
        }

        this._changeNavState(function () {
          var _this = this;

          if (this._curMode !== 'desktop') {
            (function () {
              var self = _this;

              // Collapse other navs
              $(_this.element).parent().find('> .' + ClassName.EXPAND).each(function () {
                if (this === self.element) {
                  return;
                }

                $(this)[NAME]('collapse');
              });

              $(_this.dimmer).on(_this.constructor.Event.CLICK, function () {
                return _this.collapse();
              });
              pxUtil.addClass(_this.element, ClassName.EXPAND);
            })();
          } else {
            pxUtil.removeClass(this.element, ClassName.COLLAPSE);
          }

          this._triggerEvent('EXPANDED', this.element);
        });
      }
    }, {
      key: 'collapse',
      value: function collapse() {
        if (this.isCollapsed()) {
          return;
        }
        if (!this._triggerPreventableEvent('COLLAPSE', this.element)) {
          return;
        }

        this._changeNavState(function () {
          if (this._curMode !== 'desktop') {
            $(this.dimmer).off('click');
            pxUtil.removeClass(this.element, ClassName.EXPAND);
          } else {
            pxUtil.addClass(this.element, ClassName.COLLAPSE);
          }

          $(window).trigger('scroll');
          this._triggerEvent('COLLAPSED', this.element);
        });
      }
    }, {
      key: 'isFixed',
      value: function isFixed() {
        return pxUtil.hasClass(this.element, ClassName.FIXED);
      }
    }, {
      key: 'isStatic',
      value: function isStatic() {
        return pxUtil.hasClass(this.element, ClassName.STATIC);
      }
    }, {
      key: 'isCollapsed',
      value: function isCollapsed() {
        return this._isCollapsed;
      }
    }, {
      key: 'activateItem',
      value: function activateItem(_el) {
        var el = this._getNode(_el, ClassName.ITEM);

        if (pxUtil.hasClass(el, ClassName.DROPDOWN)) {
          return;
        }

        // Deactivate all items
        $(this.element).find('.' + ClassName.ITEM + '.' + ClassName.ACTIVE).removeClass(ClassName.ACTIVE);

        pxUtil.addClass(el, ClassName.ACTIVE);

        // If item is in the root
        if (pxUtil.hasClass(el.parentNode, ClassName.CONTENT)) {
          return;

          // Else if item is in the floating opened dropdown
        } else if (pxUtil.hasClass(el.parentNode, ClassName.DROPDOWN_MENU_WRAPPER)) {
          var targetDropdown = $(el).parents('.' + ClassName.DROPDOWN_MENU).data('dropdown');

          if (!targetDropdown) {
            return;
          }

          targetDropdown.addClass(ClassName.ACTIVE);

          // Else
        } else {
          var curDropdown = $(el).parents('.' + ClassName.DROPDOWN)[0];
          var rootDropdown = void 0;

          this.openDropdown(curDropdown, false);

          while (curDropdown) {
            pxUtil.addClass(curDropdown, ClassName.ACTIVE);

            if (pxUtil.hasClass(curDropdown.parentNode, ClassName.DROPDOWN_MENU_WRAPPER)) {
              rootDropdown = $(curDropdown).parents('.' + ClassName.DROPDOWN_MENU).data('dropdown');
              curDropdown = null;

              if (!rootDropdown) {
                return;
              }

              pxUtil.addClass(rootDropdown, ClassName.ACTIVE);
            } else {
              rootDropdown = curDropdown;
              curDropdown = $(curDropdown).parents('.' + ClassName.DROPDOWN)[0];
            }
          }

          if (this.isCollapsed()) {
            $(this.content).find(Selector.OPENED_DROPDOWNS).removeClass(ClassName.OPEN);
            pxUtil.addClass(rootDropdown, ClassName.OPEN);
          }
        }
      }
    }, {
      key: 'openDropdown',
      value: function openDropdown(_el) {
        var showDropdown = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

        var el = this._getNode(_el);

        if (this.isStatic() && !this._isFloatingDropdown(el)) {
          return;
        }
        if ((!this._isFloatingDropdown(el) || showDropdown) && !this.isDropdownOpened(el) && !this._triggerPreventableEvent('DROPDOWN_OPEN', el)) {
          return;
        }

        // Open dropdown tree
        //

        var dropdowns = this.isDropdownOpened(el) ? [] : [el];
        var dropdown = el;

        // Collect unopened parent dropdowns
        while (dropdown = $(dropdown).parents('.' + ClassName.DROPDOWN)[0]) {
          if (!this.isDropdownOpened(dropdown)) {
            dropdowns.push(dropdown);
          }
        }

        var parent = dropdowns.pop();

        if (!parent) {
          return;
        }

        // Expand child dropdowns without animation
        for (var i = 0, l = dropdowns.length; i < l; i++) {
          this._expandDropdown(dropdowns[i], false);
        }

        if (this._isFloatingDropdown(parent)) {
          if (!showDropdown) {
            return;
          }

          this._showDropdown(parent);
        } else {
          this._expandDropdown(parent, true);
        }
      }
    }, {
      key: 'closeDropdown',
      value: function closeDropdown(_el) {
        var el = this._getNode(_el);

        if (!this.isDropdownOpened(el)) {
          return;
        }
        if (this.isStatic() && !this._isFloatingDropdown(el)) {
          return;
        }
        if (!this._triggerPreventableEvent('DROPDOWN_CLOSE', el)) {
          return;
        }

        if (this._isFloatingDropdown(el)) {
          this._hideDropdown(el);
        } else {
          this._collapseDropdown(el, true);
        }
      }
    }, {
      key: 'toggleDropdown',
      value: function toggleDropdown(_el) {
        var el = this._getNode(_el);

        this[this.isDropdownOpened(el) ? 'closeDropdown' : 'openDropdown'](el);
      }
    }, {
      key: 'closeAllDropdowns',
      value: function closeAllDropdowns() {
        var _parent = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : $(this.element).find('.' + ClassName.CONTENT);

        this._closeAllDropdowns(this._getNode(_parent, null));
      }
    }, {
      key: 'freezeDropdown',
      value: function freezeDropdown(_el) {
        var el = this._getNode(_el);

        if (!this._isFloatingDropdown(el) || !this.isDropdownOpened(el)) {
          return;
        }
        if (pxUtil.hasClass(el, ClassName.FREEZE)) {
          return;
        }

        pxUtil.addClass(el, ClassName.FREEZE);

        this._clearDropdownTimer(el);

        this._triggerEvent('DROPDOWN_FROZEN', el);
      }
    }, {
      key: 'unfreezeDropdown',
      value: function unfreezeDropdown(_el) {
        var el = this._getNode(_el);

        if (!this._isFloatingDropdown(el) || !this.isDropdownOpened(el)) {
          return;
        }
        if (!pxUtil.hasClass(el, ClassName.FREEZE)) {
          return;
        }

        pxUtil.removeClass(el, ClassName.FREEZE);

        this._triggerEvent('DROPDOWN_UNFROZEN', el);
      }
    }, {
      key: 'getDropdownContainer',
      value: function getDropdownContainer(_el) {
        var el = this._getNode(_el);

        return this._isFloatingDropdown(el) && this.isDropdownOpened(el) ? $($(el).data('dropdown')).find('.' + ClassName.DROPDOWN_MENU_WRAPPER) : $(el).find(Selector.DROPDOWN_MENU);
      }
    }, {
      key: 'isFloatingDropdown',
      value: function isFloatingDropdown(el) {
        return this._isFloatingDropdown(this._getNode(el));
      }
    }, {
      key: 'isDropdownOpened',
      value: function isDropdownOpened(_el) {
        var el = this._getNode(_el);
        var isRoot = this._isRootDropdown(el);
        var isCollapsed = this.isCollapsed();

        return isCollapsed && isRoot && pxUtil.hasClass(el, ClassName.SHOW) || isCollapsed && !isRoot && pxUtil.hasClass(el, ClassName.OPEN) || !isCollapsed && pxUtil.hasClass(el, ClassName.OPEN);
      }
    }, {
      key: 'isDropdownFrozen',
      value: function isDropdownFrozen(_el) {
        return pxUtil.hasClass(this._getNode(_el), ClassName.FREEZE);
      }
    }, {
      key: 'append',
      value: function append(item) {
        var parentDropdown = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

        return this.insert(item, null, parentDropdown);
      }
    }, {
      key: 'prepend',
      value: function prepend(item) {
        var parentDropdown = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

        return this.insert(item, 0, parentDropdown);
      }
    }, {
      key: 'insert',
      value: function insert(_item, position) {
        var _parent = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

        // Get item

        var $items = this._getNodeOrCreate(_item, ClassName.ITEM, false);

        if ($items.hasClass(ClassName.DROPDOWN) && !$items.find(Selector.DROPDOWN_MENU).length) {
          throw new Error('The .' + ClassName.DROPDOWN + ' item(s) must contain the child .' + ClassName.DROPDOWN_MENU + ' element.');
        }

        // Get target

        var $parent = _parent === null ? $(this.content) : this._getNode(_parent, ClassName.DROPDOWN, false);

        var $target = void 0;

        if ($parent.hasClass(ClassName.CONTENT)) {
          $target = $parent;
        } else {
          // If floating dropdown
          if (this._isFloatingDropdown($parent[0]) && this.isDropdownOpened($parent[0])) {
            $target = $($parent.data('dropdown')).find('.' + ClassName.DROPDOWN_MENU_WRAPPER);
          } else {
            $target = $parent.find(Selector.DROPDOWN_MENU);
          }

          if (!$target.length) {
            throw new Error('Targeted element is not found.');
          }
        }

        // Insert items

        var $dropdownItems = $target.find(Selector.ITEM);

        if (!$dropdownItems.length) {
          $target.append($items);
        } else if (position === null) {
          $items.insertAfter($dropdownItems.last());
        } else {
          var $found = $dropdownItems.eq(position);

          if ($found.length) {
            $items.insertBefore($found);
          } else {
            $items.insertAfter($dropdownItems.last());
          }
        }

        // Update scrollbar

        if (!this.isCollapsed() || $parent.hasClass(ClassName.CONTENT)) {
          this._updateScrollbar(this.content);
        } else if ($target.hasClass(ClassName.DROPDOWN_MENU_WRAPPER)) {
          this._updateScrollbar($target[0]);
        } else {
          this._updateScrollbar($target.parents('.' + ClassName.DROPDOWN_MENU_WRAPPER)[0]);
        }

        return $items;
      }
    }, {
      key: 'remove',
      value: function remove(_item) {
        var $item = this._getNode(_item, ClassName.ITEM, false);
        var $parent = $item.parent();

        if ($item.hasClass(ClassName.DROPDOWN)) {
          $($item.data('dropdown')).remove();
        }

        $item.remove();

        if (!this.isCollapsed() || $parent.hasClass(ClassName.CONTENT)) {
          this._updateScrollbar(this.content);
        } else if ($parent.hasClass(ClassName.DROPDOWN_MENU_WRAPPER)) {
          this._updateScrollbar($parent[0]);
        } else {
          this._updateScrollbar($parent.parents('.' + ClassName.DROPDOWN_MENU_WRAPPER)[0]);
        }
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

        // Disable animations
        pxUtil.removeClass(this.element, ClassName.ANIMATE);

        // Disable transitions
        pxUtil.removeClass(this.element, ClassName.TRANSITIONING);

        // Reset nav state
        pxUtil.removeClass(this.element, ClassName.EXPAND);

        // Close dropdowns
        if (this.isCollapsed()) {
          this.closeAllDropdowns();
        }

        // Remove dimmer if no initialized navs exists

        var initializedNavs = 0;

        $(this.element.parentNode).find('> .' + ClassName.NAV).each(function () {
          if ($(this).data(DATA_KEY)) {
            initializedNavs++;
          }
        });

        if (!initializedNavs) {
          $(this.dimmer).remove();
        }

        // Destroy scrollbar
        $(this.element).find('.' + ClassName.CONTENT).perfectScrollbar('destroy');
        $(this.content).unwrap(Selector.SCROLLABLE_AREA);
      }

      // private

    }, {
      key: '_getNode',
      value: function _getNode(_el) {
        var requiredClass = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ClassName.DROPDOWN;
        var returnPlainNode = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

        var $el = typeof _el === 'string' ? $(this.element).find(_el) : $(_el);

        if (!$el.length) {
          throw new Error('Element is not found.');
        }

        if (requiredClass && !$el.hasClass(requiredClass)) {
          throw new Error('Element(s) must have the .' + requiredClass + ' class.');
        }

        return returnPlainNode ? $el[0] : $el;
      }
    }, {
      key: '_getNodeOrCreate',
      value: function _getNodeOrCreate(_el) {
        var requiredClass = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ClassName.DROPDOWN;
        var returnPlainNode = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

        // Add simple check to detect CSS selector
        return this._getNode(typeof _el === 'string' && (_el[0] === '#' || _el[0] === '.') ? _el : $(_el), requiredClass, returnPlainNode);
      }
    }, {
      key: '_detectActiveItem',
      value: function _detectActiveItem() {
        var $activeItem = $(this.content).find('.' + ClassName.ITEM + '.' + ClassName.ACTIVE + ':not(.' + ClassName.DROPDOWN + ')');

        if (!$activeItem.length) {
          return;
        }

        this.activateItem($activeItem.first());
      }
    }, {
      key: '_expandDropdown',
      value: function _expandDropdown(el) {
        var animate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

        if (pxUtil.hasClass(el, ClassName.OPEN)) {
          return;
        }

        var $dropdown = $(el).find(Selector.DROPDOWN_MENU);

        function complete() {
          $dropdown.removeClass(ClassName.TRANSITIONING).height('');

          this._updateScrollbar(this.isCollapsed() ? $(el).parents('.' + ClassName.DROPDOWN_MENU_WRAPPER)[0] : this.content);

          // Trigger "opened" event
          this._triggerEvent('DROPDOWN_OPENED', el);
        }

        if (this.config.accordion) {
          this._closeAllDropdowns(el.parentNode, animate, $(el));
        }

        pxUtil.addClass(el, ClassName.OPEN);

        if (!$.support.transition || !animate) {
          return complete.call(this);
        }

        $dropdown.height(0).addClass(ClassName.TRANSITIONING).one('bsTransitionEnd', $.proxy(complete, this)).emulateTransitionEnd(this.config.transitionDuration).height($dropdown[0].scrollHeight);
      }
    }, {
      key: '_collapseDropdown',
      value: function _collapseDropdown(el) {
        var animate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

        if (!pxUtil.hasClass(el, ClassName.OPEN)) {
          return;
        }

        var $dropdown = $(el).find(Selector.DROPDOWN_MENU);

        function complete() {
          pxUtil.removeClass(el, ClassName.OPEN);
          $dropdown.removeClass(ClassName.TRANSITIONING).height('');

          // Collapse all sub-dropdowns
          $(el).find('.' + ClassName.OPEN).removeClass(ClassName.OPEN);

          this._updateScrollbar(this.isCollapsed() ? $(el).parents('.' + ClassName.DROPDOWN_MENU_WRAPPER)[0] : this.content);

          // Trigger "closed" event
          this._triggerEvent('DROPDOWN_CLOSED', el);
        }

        if (!$.support.transition || !animate) {
          return complete.call(this);
        }

        $dropdown.height($dropdown.height())[0].offsetHeight;

        $dropdown.addClass(ClassName.TRANSITIONING).height(0).one('bsTransitionEnd', $.proxy(complete, this)).emulateTransitionEnd(this.config.transitionDuration);
      }
    }, {
      key: '_showDropdown',
      value: function _showDropdown(el) {
        var _this2 = this;

        if (pxUtil.hasClass(el, ClassName.SHOW) || !this._isRootDropdown(el)) {
          return;
        }

        var container = el.parentNode.parentNode;
        var dropdown = $(el).find(Selector.DROPDOWN_MENU)[0];

        if (!dropdown) {
          return;
        }

        // Close all dropdowns
        this.closeAllDropdowns();

        var offsetTop = el.parentNode.offsetTop;
        var elTop = el.offsetTop - el.parentNode.scrollTop;

        var $dropdownTitle = $('<div class="' + ClassName.DROPDOWN_MENU_TITLE + '"></div>').html($(el).find(Selector.ITEM_LABEL).html()).prependTo(dropdown);

        pxUtil.addClass(el, ClassName.SHOW);
        pxUtil.addClass(dropdown, ClassName.SHOW);
        container.appendChild(dropdown);

        var elHeight = $(el).outerHeight();
        var $items = $(dropdown).find(Selector.ITEM);
        var itemHeight = $items.first().find('> a').outerHeight();
        var visibleArea = $(this.element).outerHeight() - offsetTop;
        var titleHeight = $dropdownTitle.outerHeight();
        var minHeight = titleHeight + itemHeight * 3;

        var dropdownWrapper = $('<div class="' + ClassName.DROPDOWN_MENU_WRAPPER + '"></div>').append($items).appendTo(dropdown)[0];

        var maxHeight = void 0;

        // Top dropdown
        if (elTop + minHeight > visibleArea) {
          maxHeight = elTop;

          if (this.isFixed() || this._curMode === 'tablet') {
            dropdown.style.bottom = visibleArea - elTop - elHeight + 'px';
          } else {
            dropdown.style.bottom = '0px';
          }

          pxUtil.addClass(dropdown, ClassName.DROPDOWN_MENU_TOP);
          dropdown.appendChild($dropdownTitle[0]);

          // Bottom dropdown
        } else {
          maxHeight = visibleArea - elTop - titleHeight;

          dropdown.style.top = offsetTop + elTop + 'px';
          dropdown.insertBefore($dropdownTitle[0], dropdown.firstChild);
        }

        dropdownWrapper.style.maxHeight = maxHeight - 10 + 'px';
        $(dropdownWrapper).perfectScrollbar(PERFECT_SCROLLBAR_OPTIONS);

        // Add event handlers
        $(dropdown).on(this.constructor.Event.MOUSEENTER, function () {
          return _this2._clearDropdownTimer(el);
        }).on(this.constructor.Event.MOUSELEAVE, function () {
          return _this2._setDropdownTimer(el);
        });

        // Link elements
        $(el).data('dropdown', dropdown);
        $(dropdown).data('element', el);

        this._updateScrollbar(el.parentNode);

        // Trigger "opened" event
        this._triggerEvent('DROPDOWN_OPENED', el);
      }
    }, {
      key: '_hideDropdown',
      value: function _hideDropdown(el) {
        if (!pxUtil.hasClass(el, ClassName.SHOW)) {
          return;
        }

        var dropdown = $(el).data('dropdown');

        if (!dropdown) {
          return;
        }

        // Remove classes
        pxUtil.removeClass(el, [ClassName.SHOW, ClassName.FREEZE]);
        pxUtil.removeClass(dropdown, ClassName.SHOW);
        pxUtil.removeClass(dropdown, ClassName.DROPDOWN_MENU_TOP);
        this.unfreezeDropdown(el);

        var $wrapper = $(dropdown).find('.' + ClassName.DROPDOWN_MENU_WRAPPER);

        // Remove title
        $(dropdown).find('.' + ClassName.DROPDOWN_MENU_TITLE).remove();

        // Remove wrapper
        $(dropdown).append($wrapper.find(Selector.ITEM));
        $wrapper.perfectScrollbar('destroy').remove();

        dropdown.setAttribute('style', '');
        el.appendChild(dropdown);

        $(el).data('dropdown', null);
        $(dropdown).data('element', null);

        this._clearDropdownTimer(el);

        // Remove event handlers
        $(dropdown).off('mouseenter').off('mouseleave');

        this._updateScrollbar(el.parentNode);

        // Trigger "closed" event
        this._triggerEvent('DROPDOWN_CLOSED', el);
      }
    }, {
      key: '_showTooltip',
      value: function _showTooltip(dropdown) {
        this._clearTooltips();

        var text = $(dropdown).find('.px-nav-label').contents().filter(function () {
          return this.nodeType === 3;
        }).text();

        var tooptip = $('<div class="' + ClassName.TOOLTIP + '"></div>').text(text)[0];

        var offsetTop = dropdown.parentNode.offsetTop;
        var elTop = dropdown.offsetTop - dropdown.parentNode.scrollTop;

        tooptip.style.top = offsetTop + elTop + 'px';

        // Link dropdown
        $(tooptip).data('dropdown', dropdown);

        dropdown.parentNode.parentNode.appendChild(tooptip);
      }
    }, {
      key: '_updateTooltipPosition',
      value: function _updateTooltipPosition() {
        var tooltip = $(this.element).find('.' + ClassName.TOOLTIP)[0];

        if (!tooltip) {
          return;
        }

        var dropdown = $(tooltip).data('dropdown');

        if (!dropdown) {
          $(tooltip).remove();
          return;
        }

        var offsetTop = dropdown.parentNode.offsetTop;
        var elTop = dropdown.offsetTop - dropdown.parentNode.scrollTop;

        tooltip.style.top = offsetTop + elTop + 'px';
      }
    }, {
      key: '_clearTooltips',
      value: function _clearTooltips() {
        $(this.element).find('.' + ClassName.TOOLTIP).remove();
      }
    }, {
      key: '_closeAllDropdowns',
      value: function _closeAllDropdowns(_parent, animate) {
        var $except = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

        var self = this;

        var _selector = void 0;
        var method = void 0;
        var parent = _parent;

        if (this.isCollapsed() && pxUtil.hasClass(parent, ClassName.CONTENT)) {
          _selector = Selector.SHOWN_DROPDOWNS;
          method = '_hideDropdown';
        } else {
          if (this._isFloatingDropdown(parent) && this.isDropdownOpened(parent)) {
            parent = $($(parent).data('dropdown')).find('.' + ClassName.DROPDOWN_MENU_WRAPPER)[0];
          } else if (pxUtil.hasClass(parent, ClassName.DROPDOWN)) {
            parent = $(parent).find(Selector.DROPDOWN_MENU)[0];
          }

          _selector = Selector.OPENED_DROPDOWNS;
          method = '_collapseDropdown';
        }

        $(parent).find(_selector).each(function () {
          if ($except && $except === $(this)) {
            return;
          }

          self[method](this, animate);
        });
      }
    }, {
      key: '_isRootDropdown',
      value: function _isRootDropdown(el) {
        return pxUtil.hasClass(el.parentNode, ClassName.CONTENT);
      }
    }, {
      key: '_isFloatingDropdown',
      value: function _isFloatingDropdown(el) {
        return this.isCollapsed() && this._isRootDropdown(el);
      }
    }, {
      key: '_getNavState',
      value: function _getNavState() {
        return (this._curMode === 'phone' || this._curMode === 'tablet') && !pxUtil.hasClass(this.element, ClassName.EXPAND) || this._curMode === 'desktop' && pxUtil.hasClass(this.element, ClassName.COLLAPSE);
      }
    }, {
      key: '_setDropdownTimer',
      value: function _setDropdownTimer(el) {
        var _this3 = this;

        if (this.isDropdownFrozen(el)) {
          return;
        }

        this._clearDropdownTimer(el);

        var timer = setTimeout(function () {
          if (_this3.isDropdownFrozen(el)) {
            return;
          }

          _this3._hideDropdown(el);
        }, this.config.dropdownCloseDelay);

        $(el).data('timer', timer);
      }
    }, {
      key: '_clearDropdownTimer',
      value: function _clearDropdownTimer(el) {
        var timer = $(el).data('timer');

        if (!timer) {
          return;
        }

        clearTimeout(timer);
      }
    }, {
      key: '_updateScrollbar',
      value: function _updateScrollbar(el) {
        if (el && pxUtil.hasClass(el, ClassName.PERFECT_SCROLLBAR_CONTAINER)) {
          $(el).perfectScrollbar('update');
        }
      }
    }, {
      key: '_changeNavState',
      value: function _changeNavState(fn) {
        this._stateChanging++;

        if (this.config.animate && $.support.transition) {
          pxUtil.addClass(this.element, ClassName.NAV_TRANSITIONING);
        }

        function transitionComplete() {
          this._stateChanging = this._stateChanging < 2 ? 0 : this._stateChanging - 1;

          if (!this._stateChanging) {
            pxUtil.removeClass(this.element, ClassName.NAV_TRANSITIONING);
          }

          this._updateScrollbar(this.content);
          pxUtil.triggerResizeEvent();
        }

        fn.call(this);

        this._isCollapsed = this._getNavState();
        this._storeNavState();

        if (!this.config.animate || !$.support.transition) {
          return transitionComplete.call(this);
        }

        $(this.element).one('bsTransitionEnd', $.proxy(transitionComplete, this)).emulateTransitionEnd(this.config.transitionDuration);
      }
    }, {
      key: '_getMode',
      value: function _getMode() {
        var screenSize = window.PixelAdmin.getScreenSize();

        var mode = void 0;

        if (this.config.modes.phone.indexOf(screenSize) !== -1) {
          mode = 'phone';
        } else if (this.config.modes.tablet.indexOf(screenSize) !== -1) {
          mode = 'tablet';
        } else if (this.config.modes.desktop.indexOf(screenSize) !== -1) {
          mode = 'desktop';
        } else {
          throw new Error('Cannot determine PxNav mode.');
        }

        return mode;
      }
    }, {
      key: '_prefixStorageKey',
      value: function _prefixStorageKey(key) {
        return this.config.storagePrefix + (pxUtil.hasClass(this.element, ClassName.NAV_LEFT) ? 'left.' : 'right.') + key;
      }
    }, {
      key: '_storeNavState',
      value: function _storeNavState() {
        if (!this.config.storeState) {
          return;
        }

        var key = this._prefixStorageKey('state');
        var state = pxUtil.hasClass(this.element, ClassName.COLLAPSE) ? 'collapsed' : 'expanded';

        window.PixelAdmin.storage.set(key, state);
      }
    }, {
      key: '_restoreNavState',
      value: function _restoreNavState() {
        if (!this.config.storeState) {
          return;
        }

        var key = this._prefixStorageKey('state');
        var state = window.PixelAdmin.storage.get(key) || 'expanded';

        pxUtil[state === 'collapsed' ? 'addClass' : 'removeClass'](this.element, ClassName.COLLAPSE);

        this._isCollapsed = this._getNavState();
        pxUtil.triggerResizeEvent();
      }
    }, {
      key: '_checkNavbarPosition',
      value: function _checkNavbarPosition() {
        if (!this.isFixed()) {
          return;
        }

        var navbar = $(this.element).find(Selector.NEAR_NAVBAR)[0];

        if (!navbar) {
          return;
        }

        if (!pxUtil.hasClass(navbar.parentNode, ClassName.NAVBAR_FIXED)) {
          console.warn('The ' + (pxUtil.hasClass(this.element, ClassName.NAV_LEFT) ? 'left' : 'right') + ' .px-nav is fixed, but the coterminous .px-navbar isn\'t. You need to explicitly add the .' + ClassName.NAVBAR_FIXED + ' class to the parent element to fix the navbar.');

          pxUtil.addClass(navbar.parentNode, ClassName.NAVBAR_FIXED);
        }
      }
    }, {
      key: '_setupMarkup',
      value: function _setupMarkup() {
        var $parent = $(this.element).parent();

        // Append dimmer
        if (!$parent.find('> .' + ClassName.DIMMER).length) {
          $parent.append('<div class="' + ClassName.DIMMER + '"></div>');
        }

        // Set scrollbar

        if (!$.fn.perfectScrollbar) {
          throw new Error('Scrolling feature requires the "perfect-scrollbar" plugin included.');
        }

        var $content = $(this.content);

        if ($content.length) {
          $content.wrap('<div class="' + ClassName.SCROLLABLE_AREA + '"></div>').perfectScrollbar(PERFECT_SCROLLBAR_OPTIONS);
        }
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        var _this4 = this;

        var self = this;

        $(window).on(this.constructor.Event.RESIZE + '.' + this.uniqueId, function () {
          self._curMode = self._getMode();
          self._isCollapsed = self._getNavState();

          if (self.isCollapsed()) {
            self.closeAllDropdowns();
          }

          if (self.config.enableTooltips) {
            self._clearTooltips();
          }

          self._updateScrollbar(self.content);
        });

        $(this.element).on(this.constructor.Event.CLICK, Selector.DROPDOWN_LINK, function (e) {
          e.preventDefault();

          var el = this.parentNode;

          if (self._isFloatingDropdown(el)) {
            if (self.isDropdownOpened(el)) {
              self[self.isDropdownFrozen(el) ? 'closeDropdown' : 'freezeDropdown'](el);
            } else {
              self.openDropdown(el);
              self.freezeDropdown(el);
            }
          } else {
            self.toggleDropdown(el);
          }
        });

        $(this.content).on(this.constructor.Event.MOUSEENTER, Selector.DROPDOWN_LINK, function () {
          if (window.PixelAdmin.isMobile) {
            return;
          }

          var el = this.parentNode;

          if (!self._isFloatingDropdown(el) || pxUtil.hasClass(self.element, ClassName.OFF_CANVAS)) {
            return;
          }

          if (!self.isDropdownOpened(el)) {
            if ($(self.element).find(Selector.FROZEN_DROPDOWNS).length) {
              return;
            }
            self.openDropdown(el);
          } else {
            self._clearDropdownTimer(el);
          }
        }).on(this.constructor.Event.MOUSELEAVE, Selector.DROPDOWN_LINK, function () {
          if (window.PixelAdmin.isMobile) {
            return;
          }

          var el = this.parentNode;

          if (!self._isFloatingDropdown(el) || !self.isDropdownOpened(el)) {
            return;
          }

          self._setDropdownTimer(el);
        }).on(this.constructor.Event.MOUSEENTER, Selector.ROOT_LINK, function () {
          if (window.PixelAdmin.isMobile) {
            return;
          }

          if (!self.config.enableTooltips || !self.isCollapsed() || pxUtil.hasClass(self.element, ClassName.OFF_CANVAS)) {
            return;
          }

          self._showTooltip(this.parentNode);
        }).on(this.constructor.Event.MOUSELEAVE, Selector.ROOT_LINK, function () {
          if (window.PixelAdmin.isMobile) {
            return;
          }

          if (!self.config.enableTooltips) {
            return;
          }

          self._clearTooltips();
        }).on(this.constructor.Event.SCROLL, function () {
          if (!_this4.isCollapsed()) {
            return;
          }

          if (_this4.config.enableTooltips) {
            _this4._updateTooltipPosition();
          }

          _this4.closeAllDropdowns();
        });
      }
    }, {
      key: '_unsetListeners',
      value: function _unsetListeners() {
        $(window).off(this.constructor.Event.RESIZE + '.' + this.uniqueId);
        $(this.element).off(EVENT_KEY);
        $(this.content).off(EVENT_KEY).find('.' + ClassName.DROPDOWN_MENU).off(EVENT_KEY);

        // Reset dimmer
        if (this._curMode !== 'desktop' && pxUtil.hasClass(this.element, ClassName.EXPAND)) {
          $(this.dimmer).off(EVENT_KEY);
        }
      }
    }, {
      key: '_enableAnimation',
      value: function _enableAnimation() {
        var _this5 = this;

        if (!this.config.animate) {
          return;
        }

        // Prevent animation "blink"
        pxUtil.addClass(this.element, ['off', ClassName.ANIMATE]);

        setTimeout(function () {
          pxUtil.removeClass(_this5.element, 'off');
        }, this.config.transitionDuration);
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
            data = new Nav(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            if (!data[config]) {
              throw new Error('No method named "' + config + '"');
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

    return Nav;
  }();

  /**
   * ------------------------------------------------------------------------
   * Data Api implementation
   * ------------------------------------------------------------------------
   */

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (e) {
    e.preventDefault();

    var $target = $(this).parents('.' + ClassName.NAV);

    if (!$target.length) {
      return;
    }

    if (!$target.data(DATA_KEY)) {
      Nav._jQueryInterface.call($target, $(this).data());
    }

    Nav._jQueryInterface.call($target, 'toggle');
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Nav._jQueryInterface;
  $.fn[NAME].Constructor = Nav;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Nav._jQueryInterface;
  };

  return Nav;
}(jQuery);
//# sourceMappingURL=px-nav.js.map
