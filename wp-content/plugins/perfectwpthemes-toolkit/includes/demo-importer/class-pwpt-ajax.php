<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PWPT_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		return;
		add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
		add_action( 'template_redirect', array( __CLASS__, 'do_pwpt_ajax' ), 0 );
		self::add_ajax_events();
	}

	/**
	 * Set PWPT AJAX constant and headers.
	 */
	public static function define_ajax() {
		if ( ! empty( $_GET['pwpt-ajax'] ) ) {
			tt_maybe_define_constant( 'DOING_AJAX', true );
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON
			}
			$GLOBALS['wpdb']->hide_errors();
		}
	}

	/**
	 * Send headers for PWPT Ajax Requests.
	 *
	 * @since 1.0.0
	 */
	private static function pwpt_ajax_headers() {
		send_origin_headers();
		@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		@header( 'X-Robots-Tag: noindex' );
		send_nosniff_header();
		status_header( 200 );
	}

	/**
	 * Check for PWPT Ajax request and fire action.
	 */
	public static function do_tt_ajax() {
		global $wp_query;

		if ( ! empty( $_GET['pwpt-ajax'] ) ) {
			$wp_query->set( 'pwpt-ajax', sanitize_text_field( $_GET['pwpt-ajax'] ) );
		}

		if ( $action = $wp_query->get( 'pwpt-ajax' ) ) {
			self::pwpt_ajax_headers();
			do_action( 'pwpt_ajax_' . sanitize_text_field( $action ) );
			wp_die();
		}
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		// perfectwpthemes_toolkit_EVENT => nopriv
		$ajax_events = array(
			'test' => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_perfectwpthemes_toolkit_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_perfectwpthemes_toolkit_' . $ajax_event, array( __CLASS__, $ajax_event ) );

				// PWPT AJAX can be used for frontend ajax requests.
				add_action( 'pwpt_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}


	/**
	 * AJAX test.
	 */
	public static function test() {
	}
}

PWPT_AJAX::init();
