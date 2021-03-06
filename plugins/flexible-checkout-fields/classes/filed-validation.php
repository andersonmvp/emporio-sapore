<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Flexible_Checkout_Fields_Field_Validation {

	protected $plugin;

	/**
	 * Flexible_Checkout_Fields_Field_Validation constructor.
	 *
	 * @param Flexible_Checkout_Fields_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	private function hooks() {
		add_action( 'woocommerce_after_checkout_validation', array( $this, 'woocommerce_after_checkout_validation' ) );
	}

	public function woocommerce_after_checkout_validation( $data ) {
		foreach ( $data as $field => $value ) {
			do_action( 'flexible_checkout_fields_validate_' . $field, $value );
		}
		$settings = $this->plugin->get_settings();
		$custom_validations = $this->get_custom_validations();
		foreach ( $settings as $section => $fields ) {
			foreach ( $fields as $field_key => $field ) {
				if ( isset( $_POST[$field_key] ) && !empty( $field['validation'] ) && array_key_exists( $field['validation'], $custom_validations ) ) {
					call_user_func( $custom_validations[$field['validation']]['callback'], $field['label'], $_POST[$field_key] );
				}
			}
		}
	}

	public function get_custom_validations() {
		return apply_filters( 'flexible_checkout_fields_custom_validation', array() );
	}

	public function get_validation_options() {
		$validation_options = array(
			''          => __( 'Default', 'flexible-checkout-fields' ),
			'none'      => __( 'None', 'flexible-checkout-fields' ),
			'email'     => __( 'Email', 'flexible-checkout-fields' ),
			'phone'     => __( 'Phone', 'flexible-checkout-fields' ),
			'postcode'  => __( 'Post code', 'flexible-checkout-fields' ),
		);
		$custom_validations = $this->get_custom_validations();
		foreach ( $custom_validations as $custom_validation_key => $custom_validation ) {
			$validation_options[$custom_validation_key] = $custom_validation['label'];
		}
		return $validation_options;
	}

}
