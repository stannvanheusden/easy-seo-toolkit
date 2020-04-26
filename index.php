<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/**
 * Plugin Name: Easy SEO toolkit
 * Plugin URI:  https://wordpress.org/plugins/elementor-seo/
 * Description: Add keywords, Meta Titles and Meta Descriptions right from your Elementor Page Settings panel.
 * Version:     0.6.0
 * Author:      Stanley van Heusden
 * Author URI:  https://easyseotoolkit.com/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 4.7.5
 * Tested up to: 5.3.2
 * Text Domain: easy-seo-toolkit
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}


if (is_plugin_active( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    include_once dirname(__FILE__) . '/inc/est-seo-settings.php';
    include_once dirname(__FILE__) . '/inc/est-elementor-seo-settings.php';
    include_once dirname(__FILE__) . '/inc/est-seo-head.php';
    include_once dirname(__FILE__) . '/inc/est-sitemap.php';
} else {
    include_once dirname(__FILE__) . '/inc/est-seo-settings.php';
    include_once dirname(__FILE__) . '/inc/est-seo-head.php';
    include_once dirname(__FILE__) . '/inc/est-sitemap.php';
}


define('EST_PLUGIN_URL', plugin_dir_url(__FILE__));

// Non Elementor meta fields styling

add_action( 'admin_print_styles-post-new.php', 'est_admin_style', 11 );
add_action( 'admin_print_styles-post.php', 'est_admin_style', 11 );

function est_admin_style() {
    wp_enqueue_style( 'est-admin-style', EST_PLUGIN_URL.'assets/admin.css' );
}

function est_admin_js() {
    // wp_enqueue_script('est-kd-check', EST_PLUGIN_URL.'assets/kd-editor.js');
}
add_action( 'admin_enqueue_scripts', 'est_admin_js' );