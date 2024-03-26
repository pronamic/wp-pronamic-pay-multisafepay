<?php
/**
 * Plugin Name: Pronamic Pay MultiSafepay Add-On
 * Plugin URI: https://www.pronamic.eu/plugins/pronamic-pay-multisafepay/
 * Description: Extend the Pronamic Pay plugin with the MultiSafepay gateway to receive payments through a variety of WordPress plugins.
 *
 * Version: 4.4.0
 * Requires at least: 5.9
 * Requires PHP: 7.4
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: pronamic-pay-multisafepay
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 * Depends: wp-pay/core
 *
 * GitHub URI: https://github.com/pronamic/wp-pronamic-pay-multisafepay
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Gateways\MultiSafepay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoload.
 */
require_once __DIR__ . '/vendor/autoload_packages.php';

/**
 * Bootstrap.
 */
\Pronamic\WordPress\Pay\Plugin::instance(
	[
		'file'             => __FILE__,
		'action_scheduler' => __DIR__ . '/vendor/woocommerce/action-scheduler/action-scheduler.php',
	]
);

add_filter(
	'pronamic_pay_gateways',
	function ( $gateways ) {
		$gateways[] = new \Pronamic\WordPress\Pay\Gateways\MultiSafepay\Integration(
			[
				'id'      => 'multisafepay-connect',
				'name'    => 'MultiSafepay - Connect',
				'mode'    => 'live',
				'api_url' => 'https://api.multisafepay.com/ewx/',
			]
		);

		$gateways[] = new \Pronamic\WordPress\Pay\Gateways\MultiSafepay\Integration(
			[
				'id'      => 'multisafepay-connect-test',
				'name'    => 'MultiSafepay - Connect - Test',
				'mode'    => 'test',
				'api_url' => 'https://testapi.multisafepay.com/ewx/',
			]
		);

		return $gateways;
	}
);
