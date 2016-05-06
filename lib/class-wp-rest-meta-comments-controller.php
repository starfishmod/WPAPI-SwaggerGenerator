<?php

class WP_REST_Meta_Comments_Controller extends WP_REST_Meta_Controller {
	/**
	 * Associated object type.
	 *
	 * @var string Type "comment"
	 */
	protected $parent_type = 'comment';

	/**
	 * Associated comment controller class object.
	 *
	 * @var WP_REST_Comments_Controller
	 */
	protected $parent_controller;

	/**
	 * Base path for parent meta type endpoints.
	 *
	 * @var string "comments"
	 */
	protected $parent_base = 'comments';

	public function __construct() {
		$this->parent_controller = new WP_REST_Comments_Controller();
		$this->namespace = 'wp/v2';
		$this->rest_base = 'meta';
	}

	/**
	 * Check if a given request has access to get meta for a comment.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_items_permissions_check( $request ) {
		$comment_id = (int) $request['parent_id'];
		$comment = get_comment( $comment_id );

		if ( empty( $comment ) || empty( $comment->comment_ID ) ) {
			return new WP_Error( 'rest_comment_invalid_id', __( 'Invalid comment id.' ), array( 'status' => 404 ) );
		}

		if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot view the meta for this comment.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	/**
	 * Check if a given request has access to get a specific meta entry for a comment.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to create a meta entry for a comment.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function create_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to update a meta entry for a comment.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|boolean
	 */
	public function update_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete meta for a comment.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function delete_item_permissions_check( $request ) {
		$comment_id = (int) $request['parent_id'];
		$comment = get_comment( $comment_id );

		if ( empty( $comment ) || empty( $comment->comment_ID ) ) {
			return new WP_Error( 'rest_comment_invalid_id', __( 'Invalid comment id.' ), array( 'status' => 404 ) );
		}

		if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Sorry, you cannot delete the meta for this comment.' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}
}
