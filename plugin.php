<?php
/**
 * Plugin Name: WP REST API - Swagger generate
 * Description: Swagger for the WP REST API
 * Author: Andrew Mee
 * Author URI: 
 * Version: 0.0.1
 * Plugin URI:
 * License: GPL2+
 */

function swagger_rest_api_init() {

	if ( class_exists( 'WP_REST_Controller' )
		&& ! class_exists( 'WP_REST_Swagger_Controller' ) ) {
		require_once dirname( __FILE__ ) . '/lib/class-wp-rest-swagger-controller.php';
	}


	$swagger_controller = new WP_REST_Swagger_Controller();
	$swagger_controller->register_routes();

	

}

add_action( 'rest_api_init', 'swagger_rest_api_init', 11 );
