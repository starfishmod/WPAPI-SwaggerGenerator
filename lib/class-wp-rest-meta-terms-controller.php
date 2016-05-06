<?php

class WP_REST_Meta_Terms_Controller extends WP_REST_Meta_Controller {
	/**
	 * Associated object type.
	 *
	 * @var string Type "term"
	 */
	protected $parent_type = 'term';

	/**
	 * Associated term controller class object.
	 *
	 * @var WP_REST_Terms_Controller
	 */
	protected $parent_controller;

	/**
	 * Base path for taxonomy endpoints.
	 *
	 * @var string
	 */
	protected $parent_base;

	/**
	 * Associated taxonomy.
	 *
	 * @var string
	 */
	protected $parent_taxonomy;

	public function __construct( $parent_taxonomy ) {
		$this->parent_taxonomy = $parent_taxonomy;
		$this->parent_controller = new WP_REST_Terms_Controller( $this->parent_taxonomy );
		$tax_obj = get_taxonomy( $this->parent_taxonomy );
		$this->parent_base = ! empty( $tax_obj->rest_base ) ? $tax_obj->rest_base : $tax_obj->name;
		$this->namespace = 'wp/v2';
		$this->rest_base = 'meta';
	}

	/**
	 * Check if a given request has access to get meta for a taxonomy.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_items_permissions_check( $request ) {
		$tax_obj = get_taxonomy( $this->parent_taxonomy );
		$parent = get_term( (int) $request['parent_id'], $this->parent_taxonomy );

		if ( empty( $parent ) || empty( $parent->term_id ) ) {
			return new WP_Error( 'rest_term_invalid_id', __( 'Invalid term id.' ), array( 'status' => 404 ) );
		}

		if ( ! current_user_can( $tax_obj->cap->edit_terms ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot view the meta for this taxonomy.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	/**
	 * Check if a given request has access to get a specific meta entry for a taxonomy.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to create a meta entry for a taxonomy.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function create_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to update a meta entry for a taxonomy.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function update_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete meta for a taxonomy.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function delete_item_permissions_check( $request ) {
		$tax_obj = get_taxonomy( $this->parent_taxonomy );
		$parent = get_term( (int) $request['parent_id'], $this->parent_taxonomy );

		if ( empty( $parent ) || empty( $parent->term_id ) ) {
			return new WP_Error( 'rest_term_invalid_id', __( 'Invalid term id.' ), array( 'status' => 404 ) );
		}

		if ( ! current_user_can( $tax_obj->cap->delete_terms ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot view the meta for this taxonomy.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}
}
