/**
 * @file
 * Attaches behaviors for the Tour module's toolbar tab.
 */

(function ($, Backbone, Drupal, document) {

    'use strict';

    /**
     * Attaches the tour's toolbar tab behavior on document load, heavily relies on tour.js
     *
     * @type {Drupal~behavior}
     *
     * @prop {Drupal~behaviorAttach} attach
     *   Attach tour functionality on `tour` events.
     */
    Drupal.behaviors.social_tour = {
        attach: function (context) {
            $('body').once('social_tour').each(function () {

                var tourData = $(context).find('ol#tour');

                console.log(tourData);

                // Instance the tour
                var tour = new Tour({
                  steps: [
                  {
                    element: "#main-navigation",
                    title: "Explore this platform",
                    content: "And interact with all the beautiful people and pieces of content in it.",
                    placement: "bottom",
                    onShow: function (tour) {
                      // Open the dropdown before attaching to the element (not working correctly yet...)
                      $('#block-socialblue-sitebranding .navbar-toggle').click();
                      return
                    },
                    onPrev: function (tour) {
                      // Open the dropdown before attaching to the element (not working correctly yet...)
                      $('#block-socialblue-sitebranding .navbar-toggle').click();
                      return
                    },
                    onNext: function (tour) {
                      // Open the dropdown before attaching to the element (not working correctly yet...)
                      $('#block-socialblue-sitebranding .navbar-toggle').click();
                      return
                    }
                  },
                  {
                    element: "#block-socialblue-accountheaderblock .notification-bell",
                    title: "The notification panel",
                    content: "You will find all sorts of notifications here.",
                    placement: "bottom",
                    smartPlacement: true
                  },
                  {
                    element: "#edit-field-post-wrapper",
                    title: "Write your first post",
                    content: "To tell the world about how awesome you are!",
                    placement: "left",
                    smartPlacement: true,
                    backdrop: true
                  },
                  {
                    element: "#edit-submit--2",
                    title: "Write a comment",
                    content: "To start discussing shit!",
                    placement: "right",
                    smartPlacement: true
                  }
                ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.start();


                // var model = new Drupal.tour.models.StateModel();
                // new Drupal.tour.views.ToggleTourView({
                //     el: $(context).find('#toolbar-tab-tour'),
                //     model: model
                // });
                //
                // model
                //     // Allow other scripts to respond to tour events.
                //     .on('change:isActive', function (model, isActive) {
                //         $(document).trigger((isActive) ? 'drupalTourStarted' : 'drupalTourStopped');
                //     })
                //     // Initialization: check whether a tour is available on the current
                //     // page.
                //     .set('tour', $(context).find('ol#tour'));
                //
                // // Start the tour immediately if it's available.
                // if ($(context).find('ol#tour').length > 0 && model.isActive !== true) {
                //     model.set('isActive', true);
                //
                //     // Alter the tour button templates.
                //     $('.tip-module-social-tour').each(function(){
                //         $(this).find('.button.button--primary').removeClass('button').addClass('btn').removeClass('button--primary').addClass('btn-primary').addClass('waves-effect');;
                //     })
                //
                //     // For our social tour, we only want to show the next button if there is more than 1 tool tip.
                //     if ($(context).find('.joyride-tip-guide.tip-module-social-tour').length <= 1) {
                //         $('.joyride-tip-guide.tip-module-social-tour .joyride-content-wrapper a.joyride-next-tip').hide();
                //     }
                //
                //     // Add another button
                //     var closetips = Drupal.t("Don't show tips like this anymore");
                //     var destination = $(location).attr('pathname');
                //     $('.joyride-content-wrapper').append('<a class="joyride-tip-remove" href="/user/tour/disable?destination=' + destination + '">'+closetips+'</a>');
                // }
            });

            // If we click somewhere in our document window, if it's not the jQuery modal container.
            // Or one of it's descendants. We hide the modal background and the tour tip.
            // $(document).click(function(e) {
            //     var container = $(".joyride-tip-guide.tip-module-social-tour");
            //
            //     if (!container.is(e.target) && container.has(e.target).length === 0) {
            //         $(".joyride-tip-guide.tip-module-social-tour").fadeOut("fast");
            //         if ($(".joyride-modal-bg").length > 0) {
            //             $(".joyride-modal-bg").remove();
            //         }
            //     }
            // })
        }
    };

})(jQuery, Backbone, Drupal, document);
