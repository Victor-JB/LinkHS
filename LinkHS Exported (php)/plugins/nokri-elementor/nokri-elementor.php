<?php
/**
Plugin Name: Nokri Elementor Widgets
Description: This plugin is essential for the proper theme funcationality.
Author: Scripts Bundle
Theme URI: https://jobs.nokriwp.com/
Author URI: http://scriptsbundle.com/
Version: 1.1.0
License: Themeforest Split Licence
License URI: https://themeforest.net/user/scriptsbundle/
Text Domain: nokri-elementor
Tags: translation-ready,theme-options, left-sidebar, right-sidebar, grid-layout, featured-images,sticky-post,  threaded-comments
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Nokri_Elementor {
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	public function i18n() {
            
             load_plugin_textdomain( 'nokri-elementor', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		
	}
	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'nokri-elementor' ),
			'<strong>' . esc_html__( 'Nokri Elementor widgets', 'nokri-elementor' ) . '</strong>',

			'<a href="https://wordpress.org/plugins/elementor/" target="_blank"><strong>'. esc_html__( 'Elementor ', 'nokri-elementor' ) .'</strong></a>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'nokri-elementor' ),
			'<strong>' . esc_html__( 'Nokri Elementor widgets ', 'nokri-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'nokri-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'nokri-elementor' ),
			'<strong>' . esc_html__( 'Nokri Elementor widgets ', 'nokri-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'nokri-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
new Nokri_Elementor();



