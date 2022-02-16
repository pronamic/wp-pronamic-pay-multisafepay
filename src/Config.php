<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: MultiSafepay config
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 */
class Config extends GatewayConfig {
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
	 * API URL.
	 *
	 * @var string|null
	 */
	public $api_url;
}
