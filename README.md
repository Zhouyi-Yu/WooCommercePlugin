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

## How to Demo Locally
You can spin up a local WordPress environment with this plugin pre-installed using the included `docker-compose.yml`:

1.  **Run**: `docker-compose up -d`
2.  **Access**: Visit `http://localhost:8080` and finish the 1-minute WordPress setup.
3.  **Activate**: Go to Plugins -> Local Plugins and activate "WC Dynamic Shipping Validator".
4.  **Test Scenario 1 (Validation)**:
    - Go to checkout, select "Commercial" address type, and try to leave "Company Name" blank. It will trigger a custom error message.
5.  **Test Scenario 2 (Dynamic Logic)**:
    - Add items totalling > $1000 to your cart. Notice that "Flat Rate" shipping disappears, leaving only high-tier or free options.
