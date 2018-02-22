(function ($) {

  Drupal.behaviors.textareaAutogrow = {
    attach: function (context, settings) {

      // Toggles inline display of profile dropdown menu items.
      var autosizeResizeUpdate = function () {
        var viewportWidth = window.innerWidth;
        var mobileUpBreakpoint = 600;

        if (viewportWidth >= mobileUpBreakpoint) {
          // Attach autosize listener.
          autosize($('.form-control--autogrow'));
        }

      };

      // Executed on document load and window resize.
      autosizeResizeUpdate();
      $(window).resize(_.debounce(function(){
        autosizeResizeUpdate()
      }, 500));

    }
  }

})(jQuery);
