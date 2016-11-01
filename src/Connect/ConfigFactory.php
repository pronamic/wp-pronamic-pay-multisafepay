<?php

/**
 * Title: MultiSafepay config factory
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.7
 * @since 1.2.6
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_ConfigFactory extends Pronamic_WP_Pay_GatewayConfigFactory {
	public function get_config( $post_id ) {
		$config = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Config();

		$config->mode       = get_post_meta( $post_id, '_pronamic_gateway_mode', true );
		$config->account_id = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_account_id', true );
		$config->site_id    = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_id', true );
		$config->site_code  = get_post_meta( $post_id, '_pronamic_gateway_multisafepay_site_code', true );

		if ( Pronamic_IDeal_IDeal::MODE_TEST === $config->mode ) {
			$config->api_url = Pronamic_WP_Pay_Gateways_MultiSafepay_MultiSafepay::API_TEST_URL;
		} else {
			$config->api_url = Pronamic_WP_Pay_Gateways_MultiSafepay_MultiSafepay::API_PRODUCTION_URL;
		}

		return $config;
	}
}
