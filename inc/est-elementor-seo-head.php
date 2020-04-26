<?php
/* Add SEO data to head */

function est_seo_data() {
	global $post;

	// // Get the current post id
	$post_id = $post->ID;

	// Get the page settings manager
	$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

	// Get the settings model for current post
	$page_settings_model = $page_settings_manager->get_model( $post_id );

	// Retrieve the color we added before
	$focuskw = $page_settings_model->get_settings( '_est_seo_focuskw' );
	$seotitle = $page_settings_model->get_settings( '_est_seo_title' );
	$seodesc = $page_settings_model->get_settings( '_est_seo_metadesc' );
	
	$seofields = '<!-- Generated by Easy SEO Toolkit - https://easyseotoolkit.com/ -->';
	if(!empty(	$seotitle )) {
		$seofields .= '<meta name="title" content="'.$seotitle.'">';
	}
	if(!empty(	$focuskw )) {
		$seofields .= '<meta name="keywords" content="'.$focuskw.'">';
	}
	if(!empty(	$seodesc )) {
		$seofields .= '<meta name="description" content="'.$seodesc.'">';
	}
	
	echo $seofields;
	
}
add_action('wp_head', 'est_seo_data');

/* Fix <title></title> tag */

function est_filter_wp_title( $title_parts ) {
	global $post;
	// // Get the current post id
	$post_id = $post->ID;

	// Get the page settings manager
	$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

	// Get the settings model for current post
	$page_settings_model = $page_settings_manager->get_model( $post_id );
		
	$seotitle = $page_settings_model->get_settings( '_est_seo_title' );	
	
	if( is_page( $post_id ) && !empty( $seotitle ) ) {
		$title_parts['title'] = $seotitle;
	
		return $title_parts;
	} else {
		$title_parts['title'] = get_the_title();
	
		return $title_parts;
	}
}
add_filter( 'document_title_parts', 'est_filter_wp_title', 10, 999 );