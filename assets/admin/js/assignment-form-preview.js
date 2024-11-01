/**
 * Testimonial assignment.
 */
jQuery(document).ready(function ($) {

  // Remove the useless tooltip
  var removeTooltip = function () {
    $('.select2-selection__choice, .select2-selection__rendered').removeAttr('title');
  }

  /*
   * Select2
   */
  var initSelect2 = function () {

    var $mySelect2 = $('.wpmtst-assignment');

    if (!$mySelect2.hasClass('select2-hidden-accessible')) {
      // Select2 has not been initialized
      $mySelect2.select2({
        placeholder: 'Select',
        theme: 'comfortable'
      })
      // Remove the ongoing useless tooltip
      .on('select2:select', removeTooltip);
    }

    // Remove the initial useless tooltip
    setTimeout(removeTooltip, 1000);

  };

  setInterval( initSelect2, 1000 );
});
