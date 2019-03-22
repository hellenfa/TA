

// Extensions / Modal
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.modal) {
    throw new Error('modal.js required.');
  }

  var bsModalShow = $.fn.modal.Constructor.prototype.show;
  var bsModalHide = $.fn.modal.Constructor.prototype.hide;

  $.fn.modal.Constructor.prototype.show = function (_relatedTarget) {
    bsModalShow.call(this, _relatedTarget);

    if (this.isShown) {
      $('html').addClass('modal-open');
    }
  };

  $.fn.modal.Constructor.prototype.hide = function (e) {
    bsModalHide.call(this, e);

    if (!this.isShown) {
      $('html').removeClass('modal-open');
    }
  };
})(jQuery);
//# sourceMappingURL=modal.js.map
