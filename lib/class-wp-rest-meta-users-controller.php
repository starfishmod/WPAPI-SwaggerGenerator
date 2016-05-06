<?php

class WP_REST_Meta_Users_Controller extends WP_REST_Meta_Controller {

	/**
	 * Associated object type.
	 *
	 * @var string "user"
	 */
	protected $parent_type = 'user';

	/**
	 * Base path for parent meta type endpoints.
	 *
	 * @var string "users"
	 */
	protected $parent_base = 'users';

	/**
	 * User controller class object.
	 *
	 * @var WP_REST_Users_Controller
	 */
	protected $parent_controller;

	public function __construct() {
		$this->parent_controller = new WP_REST_Users_Controller();
		$this->namespace = 'wp/v2';
		$this->rest_base = 'meta';
	}

	/**
	 * Check if a given request has access to get meta for a user.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_items_permissions_check( $request ) {
		$user = get_user_by( 'id', (int) $request['parent_id'] );

		if ( empty( $user ) || empty( $user->ID ) ) {
			return new WP_Error( 'rest_user_invalid_id', __( 'Invalid user id.' ), array( 'status' => 404 ) );
		}
		global $current_user;
		$current_user = null;
		if ( ! current_user_can( 'edit_user', $user->ID ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot view the meta for this user.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	/**
	 * Check if a given request has access to get a specific meta entry for a user.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to create a meta entry for a user.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function create_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to update a meta entry for a user.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function update_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete meta for a user.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function delete_item_permissions_check( $request ) {
		$user = get_user_by( 'id', (int) $request['parent_id'] );

		if ( empty( $user ) || empty( $user->ID ) ) {
			return new WP_Error( 'rest_user_invalid_id', __( 'Invalid user id.' ), array( 'status' => 404 ) );
		}

		if ( ! current_user_can( 'delete_user', $user->ID ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot delete the meta for this user.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}
}
