<?php
$current_v = isset( $_GET['assignment'] ) ? $_GET['assignment'] : '';
$assignees = $this->get_assignees();
?>
<div class="strong-select2">
    <select class="wpmtst-assignment" id="strong-assignment" name="assignment">
        <option value="all" <?php selected( 0, $current_v ); ?>>
			<?php _e( 'All assignments', 'strong-testimonials-assignment' ); ?>
        </option>
        <option value="0" <?php selected( 0, $current_v ); ?>>
			<?php _e( 'Unassigned', 'strong-testimonials-assignment' ); ?>
        </option>

		<?php foreach ( $assignees as $post_type => $assignee ) : ?>
            <optgroup label="<?php echo $assignee['name']; ?>">

				<?php foreach ( $assignee['posts'] as $post2 ) : ?>
                    <option value="<?php echo $post2->ID; ?>" <?php selected( $post2->ID, $current_v ); ?>>
						<?php echo $post2->post_title; ?>
                    </option>
				<?php endforeach; ?>

            </optgroup>
		<?php endforeach; ?>
    </select>
</div>
