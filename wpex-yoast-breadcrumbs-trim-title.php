<?php
/*
Plugin Name: WPEX Yoast Breadcrumbs Trim Title
Description: This plugin adds a new setting to the customizer under "Yoast SEO Breadcrumbs" that will allow you to trim the breadcrumbs title. Useful when your site has very long titles and your theme places the breadcrumbs next to the main title.
Version: 1.0.0
Author: Aj Clarke
Author URI: http://wpexplorer.com
License: GPLv2
*/

// Make sure we have support for breadcrumbs
add_theme_support( 'yoast-seo-breadcrumbs' );

// Add customizer setting
function wpex_ybtt_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'wpex_ybtt_trim_title', array(
		'type' => 'theme_mod',
		'sanitize_callback' => false,
	) );
	$wp_customize->add_control( 'wpex_ybtt_trim_title', array(
		'label'       => __( 'Trim Title Length', 'wpex' ),
		'section'     => 'wpseo_breadcrumbs_customizer_section',
		'settings'    => 'wpex_ybtt_trim_title',
		'type'        => 'text',
		'description' => __( 'Number of WORDS to trim the title by.', 'wpex' ),
	) );
}
add_action( 'customize_register' , 'wpex_ybtt_customize_register', 40 );

// Alter title
function wpex_ybtt_alter_title( $title ) {
	if ( $number = get_theme_mod( 'wpex_ybtt_trim_title' ) ) {
		$title = wp_trim_words( $title, $number );
	}
	return $title;
}
add_filter( 'wp_seo_get_bc_title', 'wpex_ybtt_alter_title' );