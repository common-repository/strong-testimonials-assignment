<?php
$testimonial_object = get_post_type_object( $this->post_type );

$testimonials = get_posts( array(
	'posts_per_page' => - 1,
	'post_type'      => $this->post_type,
	'meta_key'       => 'strong_assignment',
	'meta_value'     => get_the_ID(),
) );

$excluded = in_array( get_the_ID(), get_option( 'wpmtst_assignment_excluded', array() ) );
?>
    <div class="has-input">
        <input type="hidden" name="assignment_exclude[include]">
        <label>
            <input type="checkbox" name="assignment_exclude[exclude]" value="" <?php checked( $excluded ); ?>>
			<?php _e( 'Exclude from testimonials', 'strong-testimonials-assignment' ); ?>
        </label>
    </div>
<?php if ( $testimonials ) : ?>
    <div class="meta_box_columned">
        <ol>
			<?php foreach ( $testimonials as $testimonial ) : ?>
                <li>
                    <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $testimonial->ID . '&action=edit' ) ); ?>"
                       title="<?php esc_attr_e( __( 'edit this %s', $testimonial_object->labels->singular_name ) ); ?>"><?php esc_html_e( $testimonial->post_title ); ?></a>
                    &nbsp;<span class="post-id">ID: <?php esc_html_e( $testimonial->ID ); ?></span>
                </li>
			<?php endforeach; ?>
        </ol>
    </div>
<?php endif; ?>