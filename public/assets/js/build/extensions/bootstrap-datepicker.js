

// Extensions / Bootstrap-datepicker
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.datepicker) {
    throw new Error('bootstrap-datepicker.js required.');
  }

  var datepickerPlace = $.fn.datepicker.Constructor.prototype.place;

  $.fn.datepicker.Constructor.prototype.place = function () {
    datepickerPlace.call(this);

    if (!this.o.rtl) {
      return this;
    }

    var $container = $(this.o.container);
    var right = parseInt(this.picker.css('right'), 10);

    right += $container.outerWidth() - $container.width();

    if (!this.picker.hasClass('datepicker-orient-left')) {
      var cW = this.picker.outerWidth();
      var w = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);

      right += 2 * w - 2 * cW;
    }

    this.picker.css({ right: right });
    return this;
  };

  $.fn.datepicker.defaults.rtl = $('html').attr('dir') === 'rtl';
})(jQuery);
//# sourceMappingURL=bootstrap-datepicker.js.map
