<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Core\Gateway;
use Pronamic\WordPress\Pay\Core\GatewayConfigFactory;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\MultiSafepay;

/**
 * Title: MultiSafepay config factory
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.6
 */
class ConfigFactory extends GatewayConfigFactory {
	/**
	 * Get config.
	 *
	 * @param $post_id
	 *
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->mode       = get_post_meta( $post_id, '_pronamic_gateway_mode', true );
		$config->account_id = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_account_id', true );
		$config->site_id    = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_id', true );
		$config->site_code  = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_code', true );

		if ( Gateway::MODE_TEST === $config->mode ) {
			$config->api_url = MultiSafepay::API_TEST_URL;
		} else {
			$config->api_url = MultiSafepay::API_PRODUCTION_URL;
		}

		return $config;
	}
}
