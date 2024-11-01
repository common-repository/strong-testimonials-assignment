<?php
global $post;
$count = get_post_meta( $post->ID, 'strong_assignment_count', true );
?>
    <span class="assigned-count"><?php echo $count; ?></span>
<?php if ( $count ) : ?>
    <span class="assigned-link">
		<?php printf( '<a href="%s" title="%s"><span class="dashicons dashicons-testimonial"></span></a>',
			esc_url( admin_url( 'edit.php?s&post_status=all&post_type=' . $this->post_type . '&assignment=' . $post->ID . '&filter_action=Filter' ) ),
			sprintf( __( 'go to these %s', 'strong-testimonials-assignment' ), esc_attr( $this->assigned_label ) ) ); ?>
	</span>
<?php endif;
