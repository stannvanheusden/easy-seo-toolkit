<?php

// Add meta boxes

function est_add_event_metaboxes() {
    $post_types = get_post_types( array('public' => true) );

	add_meta_box(
		'est_metabox',
		'Easy SEO Toolkit',
		'est_metabox_loader',
		$post_types,
		'side',
		'high'
	);
}

add_action( 'add_meta_boxes', 'est_add_event_metaboxes' );

function est_metabox_loader() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'est_metabox_nonce' );
	// Get the location data if it's already been entered
	$seokd = get_post_meta( $post->ID, '_est_seo_kd', true );
	$seotitle = get_post_meta( $post->ID, '_est_seo_title', true );
	$seodesc = get_post_meta( $post->ID, '_est_seo_desc', true );
    // Output the field
    echo '<div class="est-metabox-wrapper">';
    echo '<div class="form-control">';
    echo '<label for="_est_seo_kd">'.__('Keywords', 'easy-seo-toolkit') .'</label>';
	echo '<input type="text" name="_est_seo_kd" id="_est_seo_kd" class="_est_seo_kd" value="' . esc_textarea( $seokd )  . '" placeholder="Keywords" class="widefat">';
    echo '</div>';
    echo '<div class="form-control">';
    echo '<label for="_est_seo_title">'.__('SEO Title', 'easy-seo-toolkit') .'</label>';
    echo '<input type="text" name="_est_seo_title" id="_est_seo_title" value="' . esc_textarea( $seotitle )  . '" placeholder="SEO Title" class="widefat">';
    echo '</div>';
    echo '<div class="form-control">';
    echo '<label for="_est_seo_desc">'.__('SEO Description', 'easy-seo-toolkit') .'</label>';
    echo '<textarea name="_est_seo_desc" id="_est_seo_desc" placeholder="SEO Description" class="widefat">'.esc_textarea( $seodesc ).'</textarea>';
    echo '</div>';
    echo '<div class="est_seo_status">';
    echo '<span class="kd"></span>';
    echo '</div>';
    echo '</div>';

}

// Save meta box data

/**
 * Save the metabox data
 */
function est_save_est_meta( $post_id, $post ) {
	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['_est_seo_kd'] ) || ! wp_verify_nonce( $_POST['est_metabox_nonce'], basename(__FILE__) ) ) {
		return $post_id;
	}
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $est_meta.
	$est_meta['_est_seo_kd'] = esc_textarea( $_POST['_est_seo_kd'] );
	$est_meta['_est_seo_title'] = esc_textarea( $_POST['_est_seo_title'] );
	$est_meta['_est_seo_desc'] = esc_textarea( $_POST['_est_seo_desc'] );
	// Cycle through the $est_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $est_meta as $key => $value ) :
		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}
		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}
	endforeach;
}
add_action( 'save_post', 'est_save_est_meta', 1, 2 );