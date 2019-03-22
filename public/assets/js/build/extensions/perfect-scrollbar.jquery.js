

// Extensions / Bootstrap-datepicker
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.perfectScrollbar) {
    throw new Error('perfect-scrollbar.jquery.js required.');
  }

  var _isRtl = $('html').attr('dir') === 'rtl';
  var fnPerfectScrollbar = $.fn.perfectScrollbar;

  $.fn.perfectScrollbar = function (settingOrCommand) {
    return this.each(function () {
      var _this = this;

      var psId = $(this).attr('data-ps-id');

      fnPerfectScrollbar.call($(this), settingOrCommand);

      if (_isRtl && !psId) {
        psId = $(this).attr('data-ps-id');

        if (psId) {
          $(window).on('resize.ps.' + psId, function () {
            return $(_this).perfectScrollbar('update');
          });
        }
      } else if (_isRtl && psId && settingOrCommand === 'destroy') {
        $(window).off('resize.ps.' + psId);
      }
    });
  };
})(jQuery);
//# sourceMappingURL=perfect-scrollbar.jquery.js.map
