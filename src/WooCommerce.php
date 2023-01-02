<?php
/**
 * WooCommerce.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Money\Money;

/**
 * WooCommerce.
 *
 * @author  Reüel van der Steege
 * @since   2.2.0
 * @version 2.2.0
 */
class WooCommerce {
	/**
	 * Filter WooCommerce available payment gateways.
	 *
	 * @param array $gateways Available gateways.
	 * @return array
	 */
	public static function woocommerce_available_payment_gateways( $gateways ) {
		// Do not filter gateways in admin.
		if ( \is_admin() ) {
			return $gateways;
		}

		// Check Santander gateway.
		$santander_id = 'pronamic_pay_santander';

		if ( \array_key_exists( $santander_id, $gateways ) ) {
			// Check MultiSafepay gateway.
			$gateway = $gateways[ $santander_id ];

			$gateway_id = \get_post_meta( (int) $gateway->settings['config_id'], '_pronamic_gateway_id', true );

			if ( 'multisafepay-connect' !== $gateway_id ) {
				return $gateways;
			}

			$cart = \WC()->cart;

			if ( ! ( $cart instanceof \WC_Cart ) ) {
				return $gateways;
			}

			$total = new Money( $cart->get_total( 'raw' ) );

			// Unset gateway if cart amount minimum not met.
			if ( $total->get_value() < 250 ) {
				unset( $gateways[ $santander_id ] );
			}
		}

		return $gateways;
	}
}
