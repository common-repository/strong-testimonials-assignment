<th>
    <label for="view-filter_assignment">
		<?php _e( 'Action', 'strong-testimonials' ); ?>
    </label>
</th>
<td style="width: 220px;">
    <div class="row">
        <div class="row-inner">
            <select class="if selectper" id="view-filter_form_assignment" name="view[data][filter][form_assignment]">
                <option value="none" <?php selected( 'none', $view['filter']['assignment'] ); ?>>
					<?php _e( 'no assignment', 'strong-testimonials-assignment' ); ?>
                </option>
                <option value="post" <?php selected( 'post', $view['filter']['assignment'] ); ?>>
					<?php _e( 'assign it to specific object(s)', 'strong-testimonials-assignment' ); ?>
                </option>
                <option value="current" <?php selected( 'current', $view['filter']['assignment'] ); ?>>
					<?php _e( 'assign it to the current object', 'strong-testimonials-assignment' ); ?>
                </option>
            </select>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="row-inner">
            <div class="then fast then_not_none then_post then_not_current strong-select2">
				<?php /* Passive input needed to submit value if no selection made. */ ?>
                <input type="hidden" name="view[data][filter][form_assignment_value]" value="0">
                <select class="wpmtst-assignment" id="strong-form-assignment"
                        name="view[data][filter][form_assignment_value][]"
					<?php echo esc_attr( $multiple ); ?>>

					<?php foreach ( $assignees as $post_type => $assignee ) : ?>
                        <optgroup label="<?php esc_attr_e( $assignee['name'] ); ?>">

							<?php foreach ( $assignee['posts'] as $post2 ) : ?>
                                <option value="<?php esc_html_e( $post2->ID ); ?>" <?php selected( in_array( $post2->ID, (array) $view['filter']['assignment_value'] ) ); ?>>
									<?php esc_html_e( $post2->post_title ); ?>
                                </option>
							<?php endforeach; ?>

                        </optgroup>
					<?php endforeach; ?>

                </select>
            </div>
            <div class="inline then fast then_not_none then_not_post then_current">
                <p class="description normal">
                    <?php _e( 'Assign testimonials to the object being displayed when this view is on a content type\'s <em>single</em> page.', 'strong-testimonials-assignment' ); ?>
                </p>
            </div>
        </div>
    </div>
</td>
