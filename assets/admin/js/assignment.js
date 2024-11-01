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
  $('#strong-assignment').select2({
    placeholder: 'Select',
    theme: 'wp-admin'
  })
  // Remove the ongoing useless tooltip
  .on('select2:select', removeTooltip);

  // Remove the initial useless tooltip
  setTimeout(removeTooltip, 1000);

});
