

// Extensions / Bootstrap-markdown
// --------------------------------------------------

(function ($) {
  'use strict';

  if (!$.fn.markdown) {
    throw new Error('bootstrap-markdown.js required.');
  }

  function fullscreenResizeHandler($header) {
    var height = $header.outerHeight();
    var $preview = this.$editor.find('.md-preview');

    this.$textarea[0].style.top = height + 'px';

    if ($preview.length) {
      $preview[0].style.top = height + 'px';
    }
  }

  var markdownBuildButtons = $.fn.markdown.Constructor.prototype.__buildButtons;
  var markdownSetFullscreen = $.fn.markdown.Constructor.prototype.setFullscreen;
  var markdownShowPreview = $.fn.markdown.Constructor.prototype.showPreview;

  $.fn.markdown.Constructor.prototype.__buildButtons = function (name, alter) {
    var $container = markdownBuildButtons.call(this, name, alter);

    $container.find('.btn-default').removeClass('btn-default').addClass('btn-secondary');

    return $container;
  };

  $.fn.markdown.Constructor.prototype.setFullscreen = function (mode) {
    markdownSetFullscreen.call(this, mode);

    // Enter fullscreen mode
    if (mode) {
      var $header = this.$editor.find('.md-header');

      fullscreenResizeHandler.call(this, $header);
      $(window).on('resize.md-editor', $.proxy(fullscreenResizeHandler, this, $header));

      // Exit fullscreen mode
    } else {
      this.$textarea[0].style.top = 'auto';
      this.$editor.find('.md-preview').css('top', 'auto');
      $(window).off('resize.md-editor');
    }
  };

  $.fn.markdown.Constructor.prototype.showPreview = function () {
    markdownShowPreview.call(this);

    if (this.$editor.hasClass('md-fullscreen-mode')) {
      var $header = this.$editor.find('.md-header');

      fullscreenResizeHandler.call(this, $header);
    }
  };
})(jQuery);
//# sourceMappingURL=bootstrap-markdown.js.map
