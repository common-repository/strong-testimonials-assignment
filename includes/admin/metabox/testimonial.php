<?php
// array
$assignment = get_post_meta( get_the_ID(), 'strong_assignment' );
$assignees  = $this->get_assignees();
$multiple   = $this->allow_multiple() ? 'multiple="multiple"' : '';
?>
<select class="wpmtst-assignment" id="strong-assignment"
        name="strong_assignment[]" <?php echo esc_attr( $multiple ); ?>>

	<?php if ( ! $multiple ) : ?>
        <option value="0" <?php selected( empty( $assignment ) ); ?>>
			<?php _e( 'Unassigned', 'strong-form-assignment' ); ?>
        </option>
	<?php endif; ?>

	<?php foreach ( $assignees as $post_type => $assignee ) : ?>
        <optgroup label="<?php esc_attr_e( $assignee['name'] ); ?>">

			<?php foreach ( $assignee['posts'] as $post2 ) : ?>
                <option value="<?php esc_attr_e( $post2->ID ); ?>" <?php selected( in_array( $post2->ID, $assignment ) ); ?>>
					<?php esc_html_e( $post2->post_title ); ?>
                </option>
			<?php endforeach; ?>

        </optgroup>
	<?php endforeach; ?>

</select>
