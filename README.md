# WooCommerce Dynamic Shipping Validator

A custom WooCommerce plugin providing dynamic checkout validation logic and shipping rate manipulation.

## Features
- **B2B Validation**: Enforces "Company Name" requirements based on address type selection.
- **Custom Meta Handling**: Automatically stamps orders with priority flags and custom shipping instructions.
- **Dynamic Shipping Logic**: Conditionally removes flat rate shipping for high-value orders to force free shipping.

## Technical Details
- **Architecture**: Modular PHP Class structure.
- **Hooks**: Utilizes `woocommerce_checkout_process`, `woocommerce_checkout_update_order_meta`, and `woocommerce_package_rates`.
- **Standards**: Follows WordPress/WooCommerce core development standards for sanitization and security.
