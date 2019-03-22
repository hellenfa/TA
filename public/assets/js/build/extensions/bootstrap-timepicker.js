

// Extensions / Bootstrap-timepicker
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.timepicker) {
    throw new Error('bootstrap-timepicker.js required.');
  }

  var timepickerInit = $.fn.timepicker.Constructor.prototype._init;
  var timepickerPlace = $.fn.timepicker.Constructor.prototype.place;

  $.fn.timepicker.Constructor.prototype._init = function () {
    this.$element.on({
      'focus.timepicker': $.proxy(this.highlightUnit, this),
      'click.timepicker': $.proxy(this.highlightUnit, this),
      'keydown.timepicker': $.proxy(this.elementKeydown, this),
      'blur.timepicker': $.proxy(this.blurElement, this)
    });

    this.$element.parent('.input-group').find('.input-group-addon').addClass('bootstrap-timepicker-trigger').on('click.timepicker', $.proxy(this.showWidget, this));

    timepickerInit.call(this);
  };

  $.fn.timepicker.Constructor.prototype.place = function () {
    if (this.template !== 'dropdown') {
      return;
    }
    timepickerPlace.call(this);
  };

  $.fn.timepicker.Constructor.prototype.getTemplate = function () {
    var hourTemplate = void 0;
    var minuteTemplate = void 0;
    var secondTemplate = void 0;
    var meridianTemplate = void 0;

    if (this.showInputs) {
      hourTemplate = '<input type="text" name="hour" class="bootstrap-timepicker-hour form-control timepicker-input" maxlength="2"/>';
      minuteTemplate = '<input type="text" name="minute" class="bootstrap-timepicker-minute form-control timepicker-input" maxlength="2"/>';
      secondTemplate = '<input type="text" name="second" class="bootstrap-timepicker-second form-control timepicker-input" maxlength="2"/>';
      meridianTemplate = '<input type="text" name="meridian" class="bootstrap-timepicker-meridian form-control timepicker-input" maxlength="2"/>';
    } else {
      hourTemplate = '<span class="bootstrap-timepicker-hour timepicker-value"></span>';
      minuteTemplate = '<span class="bootstrap-timepicker-minute timepicker-value"></span>';
      secondTemplate = '<span class="bootstrap-timepicker-second timepicker-value"></span>';
      meridianTemplate = '<span class="bootstrap-timepicker-meridian timepicker-value"></span>';
    }

    var templateContent = '\n<table class="table">\n<tr>\n  <td><a href="#" data-action="incrementHour" class="timepicker-increment">+</a></td>\n  <td class="separator">&nbsp;</td>\n  <td><a href="#" data-action="incrementMinute" class="timepicker-increment">+</a></td>\n  ' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="incrementSecond" class="timepicker-increment">+</a></td>' : '') + '\n  ' + (this.showMeridian ? '<td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian" class="timepicker-increment">+</a></td>' : '') + '\n</tr>\n<tr>\n  <td>' + hourTemplate + '</td>\n  <td class="separator">:</td>\n  <td>' + minuteTemplate + '</td>\n  ' + (this.showSeconds ? '<td class="separator">:</td><td>' + secondTemplate + '</td>' : '') + '\n  ' + (this.showMeridian ? '<td class="separator">&nbsp;</td><td>' + meridianTemplate + '</td>' : '') + '\n</tr>\n<tr>\n  <td><a href="#" data-action="decrementHour" class="timepicker-decrement">-</a></td>\n  <td class="separator"></td>\n  <td><a href="#" data-action="decrementMinute" class="timepicker-decrement">-</a></td>\n  ' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="decrementSecond" class="timepicker-decrement">-</a></td>' : '') + '\n  ' + (this.showMeridian ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian" class="timepicker-decrement">-</a></td>' : '') + '\n</tr>\n</table>';

    if (this.template !== 'modal') {
      return '<div class="bootstrap-timepicker-widget dropdown-menu">' + templateContent + '</div>';
    }

    return '\n<div class="bootstrap-timepicker-widget modal fade" tabindex="-1" role="dialog">\n<div class="modal-dialog modal-sm" role="document">\n  <div class="modal-content">\n    <div class="modal-header">\n      <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n        <span aria-hidden="true">&times;</span>\n      </button>\n      <h4 class="modal-title">Pick a Time</h4>\n    </div>\n    <div class="modal-body">\n      ' + templateContent + '\n    </div>\n    <div class="modal-footer">\n      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\n    </div>\n  </div>\n</div>\n</div>';
  };
})(jQuery);
//# sourceMappingURL=bootstrap-timepicker.js.map
