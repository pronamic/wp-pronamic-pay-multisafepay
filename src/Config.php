<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: MultiSafepay config
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 */
class Config extends GatewayConfig {
	/**
	 * API URL.
	 *
	 * @var string
	 */
	private $api_url;

	/**
	 * Account ID.
	 *
	 * @var string|null
	 */
	public $account_id;

	/**
	 * Site ID.
	 *
	 * @var string|null
	 */
	public $site_id;

	/**
	 * Site code.
	 *
	 * @var string|null
	 */
	public $site_code;

	/**
	 * Construct config.
	 */
	public function __construct() {
		$this->api_url = MultiSafepay::API_PRODUCTION_URL;
	}

	/**
	 * Get API URL.
	 *
	 * @return string
	 */
	public function get_api_url() {
		return $this->api_url;
	}

	/**
	 * Set API URL.
	 *
	 * @param string $api_url API URL.
	 * @return void
	 */
	public function set_api_url( $api_url ) {
		$this->api_url = $api_url;
	}
}
