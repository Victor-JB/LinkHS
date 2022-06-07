<?php
/**
 * Secure Passwords module bootstrap.
 *
 * This module requires users to use more secure passwords by preventing the use of
 * any passwords exposed in data breaches.
 *
 * @package Newfold\WP\Module\Secure_Passwords
 */

if ( function_exists( 'add_action' ) ) {
	add_action( 'plugins_loaded', 'newfold_module_register_secure_passwords' );
}

/**
 * Registers the secure passwords module.
 */
function newfold_module_register_secure_passwords() {
	eig_register_module(
		array(
			'name'     => 'secure-passwords',
			'label'    => __( 'Secure Passwords', 'endurance' ),
			'callback' => 'newfold_module_load_secure_passwords',
			'isActive' => true,
			'isHidden' => false,
		)
	);
}

/**
 * Loads the secure passwords module.
 */
function newfold_module_load_secure_passwords() {
	require dirname( __FILE__ ) . '/secure-passwords.php';
}
