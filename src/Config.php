<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: MultiSafepay config
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class Config extends GatewayConfig {
	public $account_id;

	public $site_id;

	public $site_code;

	public $api_url;
}
