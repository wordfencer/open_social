(function ($) {

  Drupal.behaviors.textareaAutogrow = {
    attach: function (context, settings) {


      var ta = $('.form-control--autogrow');
      ta.focus(function() {
        autosize(ta);
      });



    }
  }

})(jQuery);
