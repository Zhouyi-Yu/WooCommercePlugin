<?php
/**
 * Plugin Name: WC Dynamic Shipping Validator
 * Plugin URI: https://github.com/Zhouyi-Yu/wc-dynamic-connector
 * Description: Custom WooCommerce extension for B2B validation logic and dynamic shipping rule injection using core hooks.
 * Version: 1.0.0
 * Author: Zhouyi Yu
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class WC_Dynamic_Validator
 * Implements custom checkout logic and order meta handling.
 */
class WC_Dynamic_Validator {

    public function __construct() {
        // Hook into checkout process for validation
        add_action( 'woocommerce_checkout_process', array( $this, 'validate_b2b_fields' ) );
        
        // Hook to modify order meta after successful checkout
        add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_custom_shipping_meta' ) );
        
        // Filter available shipping methods based on cart criteria
        add_filter( 'woocommerce_package_rates', array( $this, 'filter_shipping_rates' ), 10, 2 );
    }

    /**
     * Validates that "Company Name" is present if the user selects "Commercial" address type.
     * Demonstrates knowledge of $_POST handling and wc_add_notice.
     */
    public function validate_b2b_fields() {
        // Check if custom checkout field 'billing_address_type' is set to 'commercial'
        if ( isset( $_POST['billing_address_type'] ) && 'commercial' === $_POST['billing_address_type'] ) {
            if ( empty( $_POST['billing_company'] ) ) {
                wc_add_notice( __( 'Company Name is required for Commercial addresses.', 'wc-dynamic-validator' ), 'error' );
            }
        }
    }

    /**
     * Saves custom calculated metrics to the order metadata for ERP integration.
     * Demonstrates knowledge of CRUD operations on Order objects.
     * 
     * @param int $order_id
     */
    public function save_custom_shipping_meta( $order_id ) {
        if ( ! empty( $_POST['shipping_notes'] ) ) {
            update_post_meta( $order_id, '_custom_shipping_instructions', sanitize_text_field( $_POST['shipping_notes'] ) );
        }
        
        // Stamp order with a high-priority flag for logic downstream
        $order = wc_get_order( $order_id );
        if ( $order->get_total() > 500 ) {
            $order->update_meta_data( '_priority_handling', 'yes' );
            $order->save();
        }
    }

    /**
     * Dynamically hides "Flat Rate" if cart total > $1000 (Force Free Shipping).
     * Demonstrates manipulation of the $rates array.
     */
    public function filter_shipping_rates( $rates, $package ) {
        if ( WC()->cart->cart_contents_total > 1000 ) {
            foreach ( $rates as $rate_key => $rate ) {
                // Remove flat rate if free shipping is available/logic met
                if ( 'flat_rate' === $rate->method_id ) {
                    unset( $rates[ $rate_key ] );
                }
            }
        }
        return $rates;
    }
}

// Initialize the plugin
new WC_Dynamic_Validator();
