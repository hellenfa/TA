

// Extensions / Knob
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.knob) {
    throw new Error('jquery.knob.js required.');
  }

  var fnKnob = $.fn.knob;

  $.fn.knob = function (options) {
    var knobs = fnKnob.call(this, options);
    var _isRtl = $('html').attr('dir') === 'rtl';

    if (!_isRtl) {
      return knobs;
    }

    return knobs.each(function () {
      var $input = $(this).find('input');

      $input.css({
        'margin-left': 0,
        'margin-right': $input.css('margin-left')
      });
    });
  };
})(jQuery);
//# sourceMappingURL=jquery.knob.js.map
