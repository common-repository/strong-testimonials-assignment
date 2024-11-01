<th>
    <label for="view-filter_assignment">
		<?php _e( 'Filter', 'strong-testimonials-assignment' ); ?>
    </label>
</th>
<!--<td style="width: 220px;">-->
<td style="width: 220px;">
    <div class="row">
        <div class="row-inner">
            <select class="if selectper" id="view-filter_assignment" name="view[data][filter][assignment]">
                <option value="none" <?php selected( 'none', $view['filter']['assignment'] ); ?>>
					<?php _e( 'none', 'strong-testimonials-assignment' ); ?>
                </option>
                <option value="type" <?php selected( 'type', $view['filter']['assignment'] ); ?>>
					<?php _e( 'assigned to a specific content type', 'strong-testimonials-assignment' ); ?>
                </option>
                <option value="current" <?php selected( 'current', $view['filter']['assignment'] ); ?>>
					<?php _e( 'assigned to the current object(s)', 'strong-testimonials-assignment' ); ?>
                </option>
                <option value="post" <?php selected( 'post', $view['filter']['assignment'] ); ?>>
					<?php _e( 'assigned to specific object(s)', 'strong-testimonials-assignment' ); ?>
                </option>
            </select>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="row-inner">

            <!-- specific assignee objects -->
            <div class="then fast then_not_none then_post then_not_current then_not_type strong-select2">
				<?php /* Passive input needed to submit value if no selection made. */ ?>
                <input type="hidden" name="view[data][filter][assignment_value]" value="0">
                <select class="wpmtst-assignment" id="strong-assignment"
                        name="view[data][filter][assignment_value][]"
					<?php echo esc_attr( $multiple ); ?>>

					<?php if ( ! $multiple ) : ?>
                        <option value="0" <?php selected( empty( $view['filter']['assignment_value'] ) ); ?>>
							<?php _e( 'Unassigned', 'strong-form-assignment' ); ?>
                        </option>
					<?php endif; ?>

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

            <!-- specific assignee types -->
            <div class="then fast then_not_none then_not_post then_not_current then_type">
				<?php /* Passive input needed to submit value if no selection made. */ ?>
                <select id="strong-assignment" name="view[data][filter][assignment_type]">

                    <option value="unassigned" <?php selected( empty( $view['filter']['assignment_type'] ) ); ?>>
                        <?php _e( 'Unassigned', 'strong-form-assignment' ); ?>
                    </option>

					<?php foreach ( $assignee_types as $post_type => $post_type_object ) : ?>
                        <option value="<?php esc_html_e( $post_type ); ?>" <?php selected( in_array( $post_type, (array) $view['filter']['assignment_type'] ) ); ?>>
                            <?php esc_html_e( $post_type_object->label ); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="inline then fast then_not_none then_not_post then_current then_not_type">
                <p class="description normal">
                    <?php _e( 'Only include testimonials assigned to the object(s) being displayed when this view is on:', 'strong-testimonials-assignment' ); ?>
                </p>
                <ul class="description normal">
                    <li><?php _e( 'a content type\'s <em>single</em> page', 'strong-testimonials-assignment' ); ?></li>
                    <li><?php _e( 'a content type\'s <em>archive</em> page', 'strong-testimonials-assignment' ); ?></li>
                    <li><?php _e( 'a content type\'s <em>taxonomy archive</em> page', 'strong-testimonials-assignment' ); ?></li>
                </ul>
            </div>

        </div>
    </div>
</td>
