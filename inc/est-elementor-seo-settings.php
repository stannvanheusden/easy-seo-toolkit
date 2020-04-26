<?php
/* Settings */

function est_add_elementor_page_settings_controls( $page ) {
	
	$page->start_controls_section(
			'seo_section',
			[
				'label' => __( 'SEO', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);
	$page->add_control(
		'_est_seo_focuskw',
		[
			'label' => __( 'Keywords', 'elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'classes' => 'est-keywords',
		]
	);
	$page->add_control(
		'_est_seo_title',
		[
			'label' => __( 'SEO Title', 'elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
		]
	);
	$page->add_control(
		'_est_seo_metadesc',
		[
			'label' => __( 'Meta description', 'elementor' ),
			'type' => \Elementor\Controls_Manager::TEXTAREA,
		]
	);

	// $page->add_control(
	//	'_est_seo_kd',
	//	[
	//		'label' => __( 'Keyword Density', 'elementor' ),
	//		'type' => \Elementor\Controls_Manager::RAW_HTML,
	//		'raw' => '<hr/><span class="kd">Loading...</span>',
	//		'content_classes' => 'kd',
	//	]
	// );
	$page->end_controls_section();
}

add_action( 'elementor/element/post/document_settings/after_section_end', 'est_add_elementor_page_settings_controls' );

/* Add Scripts for Keyword Density check */

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	wp_enqueue_script(
		'est-kd-editor',
		EST_PLUGIN_URL.'/assets/kd-elementor-editor.js',
		[
			'elementor-editor', // dependency
		],
		'0.5.3',
		true // in_footer
	);
 } );

?>
