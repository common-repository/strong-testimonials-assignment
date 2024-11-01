/**
 * Testimonial assignment.
 */
jQuery(document).ready(function ($) {

  var $filter = $('#view-filter_assignment');
  var $filterForm = $('#view-filter_form_assignment');

  // Show dependent elements which are intially hidden.
  var $mode = $('#view-mode');
  var currentMode = $mode.find('input:checked').val();
  switch (currentMode) {
    case 'display':
      $filter.change();
      break;
    case 'form':
      $filterForm.change();
      break;
    default:
  }

  /*
   * Select2
   */
  // Remove the useless tooltip
  var removeTooltip = function () {
    $('.select2-selection__choice, .select2-selection__rendered').removeAttr('title');
  }
  // Attach
  $('.wpmtst-assignment').select2({
    placeholder: 'Select',
    theme: 'wp-admin'
  })
  // Remove the ongoing useless tooltip
  .on('select2:select', removeTooltip);

  // Remove the initial useless tooltip
  setTimeout(removeTooltip, 1000);

  // Remove inline style when assignment option changes.
  // (Need to fork Select2.js to accomodate hidden elements.)
  $filterForm.on('change', function(e) {
    $('.select2.select2-container').removeAttr('style');
  });

});
