<?php
$assignment_count = isset( $_GET['assignment_count'] ) ? $_GET['assignment_count'] : '';
?>
<select name="assignment_count">
    <option value="" <?php selected( $assignment_count, '' ); ?>>
		<?php _e( 'Filter by testimonials', 'strong-testimonials-assignment' ); ?>
    </option>
    <option value="yes" <?php selected( $assignment_count, 'yes' ); ?>>
		<?php _e( 'Has testimonials', 'strong-testimonials-assignment' ); ?>
    </option>
    <option value="no" <?php selected( $assignment_count, 'no' ); ?>>
		<?php _e( 'Does not have testimonials', 'strong-testimonials-assignment' ); ?>
    </option>
</select>
