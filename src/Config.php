<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: MultiSafepay config
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 */
class Config extends GatewayConfig {
	public $account_id;

	public $site_id;

	public $site_code;

	public $api_url;
}
