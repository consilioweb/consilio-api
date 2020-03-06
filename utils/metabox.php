<?php
/*
class about_metabox {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'about',
			__( 'Seller Inforormation', 'text_domain' ),
			array( $this, 'render_metabox' ),
			'page',
			'advanced',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'car_nonce_action', 'car_nonce' );

		// Retrieve an existing value from the database.
		$car_name = get_post_meta( $post->ID, 'car_name', true );
		$car_phone = get_post_meta( $post->ID, 'car_phone', true );
		$car_address = get_post_meta( $post->ID, 'car_address', true );
		$car_private = get_post_meta( $post->ID, 'car_private', true );

		// Set default values.
		if( empty( $car_name ) ) $car_name = '';
		if( empty( $car_phone ) ) $car_phone = '';
		if( empty( $car_address ) ) $car_address = '';
		if( empty( $car_private ) ) $car_private = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="car_name" class="car_name_label">' . __( 'Name', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="car_name" name="car_name" class="car_name_field" placeholder="' . esc_attr__( '', 'text_domain' ) . '" value="' . esc_attr__( $car_name ) . '">';
		echo '			<p class="description">' . __( 'Seller full name.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="car_phone" class="car_phone_label">' . __( 'Phone', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="car_phone" name="car_phone" class="car_phone_field" placeholder="' . esc_attr__( '', 'text_domain' ) . '" value="' . esc_attr__( $car_phone ) . '">';
		echo '			<p class="description">' . __( 'Phone number.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="car_address" class="car_address_label">' . __( 'Address', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="car_address" name="car_address" class="car_address_field" placeholder="' . esc_attr__( '', 'text_domain' ) . '" value="' . esc_attr__( $car_address ) . '">';
		echo '			<p class="description">' . __( 'Seller address.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="car_private" class="car_private_label">' . __( 'Private or Dealer', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="car_private" name="car_private" class="car_private_field">';
		echo '			<option value="car_private" ' . selected( $car_private, 'car_private', false ) . '> ' . __( 'Private', 'text_domain' );
		echo '			<option value="car_dealer" ' . selected( $car_private, 'car_dealer', false ) . '> ' . __( 'Dealer', 'text_domain' );
		echo '			</select>';
		echo '			<p class="description">' . __( 'Private seller or a dealer.', 'text_domain' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = $_POST['car_nonce'];
		$nonce_action = 'car_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$car_new_name = isset( $_POST[ 'car_name' ] ) ? sanitize_text_field( $_POST[ 'car_name' ] ) : '';
		$car_new_phone = isset( $_POST[ 'car_phone' ] ) ? sanitize_text_field( $_POST[ 'car_phone' ] ) : '';
		$car_new_address = isset( $_POST[ 'car_address' ] ) ? sanitize_text_field( $_POST[ 'car_address' ] ) : '';
		$car_new_private = isset( $_POST[ 'car_private' ] ) ? $_POST[ 'car_private' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'car_name', $car_new_name );
		update_post_meta( $post_id, 'car_phone', $car_new_phone );
		update_post_meta( $post_id, 'car_address', $car_new_address );
		update_post_meta( $post_id, 'car_private', $car_new_private );

	}

}


new about_metabox;

*/