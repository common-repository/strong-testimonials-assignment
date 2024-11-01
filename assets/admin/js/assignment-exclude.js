/**
 * Exclude posts from testimonial assignment.
 */

(function ($) {

  /*
   * Quick Edit
   */

  // we create a copy of the WP inline edit post function
  var $wp_inline_edit = inlineEditPost.edit;

  // and then we overwrite the function with our own code
  inlineEditPost.edit = function (id) {

    // "call" the original WP edit function
    // we don't want to leave WordPress hanging
    $wp_inline_edit.apply(this, arguments);

    var $post_id = 0;
    if (typeof(id) === 'object') {
      $post_id = parseInt(this.getId(id));
    }

    if ($post_id > 0) {
      var $edit_row = $('#edit-' + $post_id);
      var $exclude = $('#assignment-exclude-' + $post_id).data('assignment_exclude');
      $edit_row.find('input[name="assignment_exclude[exclude]"]').prop('checked', $exclude);
    }
  };

  /*
   * Bulk Edit
   */

  var $bulk_row = $('#bulk-edit');
  $bulk_row.on('click', function () {
    // get the selected post ids that are being edited
    var post_ids = [];
    $bulk_row.find('#bulk-titles').children().each(function () {
      post_ids.push($(this).attr('id').replace(/^(ttle)/i, ''));
    });

    // get the exclude value
    var exclude = $bulk_row.find('select[name="assignment_exclude[exclude]"]').val();

    // save the data
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      cache: false,
      async: false,
      data: {
        action: 'assignment_exclude_save_bulk_edit',
        post_ids: post_ids,
        exclude: exclude
      }
    });
  });

})(jQuery);
