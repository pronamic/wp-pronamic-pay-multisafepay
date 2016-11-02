<?php

/**
 * Title: MultiSafepay Connect integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.7
 * @since 1.2.6
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Integration extends Pronamic_WP_Pay_Gateways_MultiSafepay_AbstractIntegration {
	public function __construct() {
		$this->id            = 'multisafepay-connect';
		$this->name          = 'MultiSafepay - Connect';
		$this->url           = 'http://www.multisafepay.com/';
		$this->product_url   = __( 'http://www.multisafepay.com/', 'pronamic_ideal' );
		$this->dashboard_url = 'https://merchant.multisafepay.com/';
		$this->provider      = 'multisafepay';
	}

	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_ConfigFactory';
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.0.4
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'multisafepay_connect';

		return $settings;
	}
}
