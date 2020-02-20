<?php

$defaults = perfectwpthemes_toolkit_get_default_theme_options();

if( ! function_exists( 'perfectwpthemes_toolkit_panel_declaration' ) ) {

	function perfectwpthemes_toolkit_panel_declaration() {

		$panels = array();

		if( !empty( $panels ) ) {

			foreach( $panels as $panel ) {

				perfectwpthemes_toolkit_add_panel( $panel['id'], $panel['title'], $panel['description'], $panel['priority'] );
			}
		}
	}
}
perfectwpthemes_toolkit_panel_declaration();


if( ! function_exists( 'perfectwpthemes_toolkit_section_declaration' ) ) {

	function perfectwpthemes_toolkit_section_declaration() {

		$sections = array(
			array(
				'id' => 'social_share',
				'title' => esc_html__( 'Social Share', 'perfectwpthemes-toolkit' ),
				'description' => '',
				'panel' => '',
				'priority' => 4,
			),
		);

		if( !empty( $sections ) ) {

			foreach( $sections as $section ) {

				perfectwpthemes_toolkit_add_section( $section['id'], $section['title'], $section['description'], $section['panel'], $section['priority'] );
			}
		}
	}
}
perfectwpthemes_toolkit_section_declaration();




/*******************************************************************************************************
************************************ Social Share Control Fields Declaration ***************************
*******************************************************************************************************/
perfectwpthemes_toolkit_add_toggle_field( 'display_social_share_global', esc_html__( 'Display Social Share', 'perfectwpthemes-toolkit' ), esc_html__( 'Global control for social share.', 'perfectwpthemes-toolkit' ), '', 'social_share' );

perfectwpthemes_toolkit_add_toggle_field( 'display_blog_social_share', esc_html__( 'Blog Page', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'display_archive_social_share', esc_html__( 'Archive Page', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'display_search_social_share', esc_html__( 'Search Page', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'display_post_single_social_share', esc_html__( 'Post Single', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'display_page_single_social_share', esc_html__( 'Page Single', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );

perfectwpthemes_toolkit_add_toggle_field( 'share_on_facebook', esc_html__( 'Facebook', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_twitter', esc_html__( 'Twitter', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_pinterest', esc_html__( 'Pinterest', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_linkedin', esc_html__( 'Linkedin', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_reddit', esc_html__( 'Reddit', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_tumblr', esc_html__( 'Tumblr', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_digg', esc_html__( 'Digg', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );
perfectwpthemes_toolkit_add_toggle_field( 'share_on_vk', esc_html__( 'VK', 'perfectwpthemes-toolkit' ), '', 'perfectwptheme_toolkit_active_global_share', 'social_share' );