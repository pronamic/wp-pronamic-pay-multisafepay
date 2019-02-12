<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Gateways\MultiSafepay\AbstractIntegration;

/**
 * Title: MultiSafepay Connect integration
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.6
 */
class Integration extends AbstractIntegration {
	/**
	 * Integration constructor.
	 */
	public function __construct() {
		$this->id            = 'multisafepay-connect';
		$this->name          = 'MultiSafepay - Connect';
		$this->url           = 'http://www.multisafepay.com/';
		$this->product_url   = __( 'http://www.multisafepay.com/', 'pronamic_ideal' );
		$this->dashboard_url = 'https://merchant.multisafepay.com/';
		$this->provider      = 'multisafepay';
	}

	/**
	 * Get config factory class.
	 *
	 * @return string
	 */
	public function get_config_factory_class() {
		return __NAMESPACE__ . '\ConfigFactory';
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see   https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.0.4
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'multisafepay_connect';

		return $settings;
	}
}
