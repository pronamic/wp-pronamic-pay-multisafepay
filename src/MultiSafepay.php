<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

/**
 * Title: MultiSafepay
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class MultiSafepay {
	/**
	 * MultiSafepay test API endpoint URL
	 *
	 * @var string
	 */
	const API_TEST_URL = 'https://testapi.multisafepay.com/ewx/';

	/**
	 * MultiSafepay production API endpoint URL
	 *
	 * @var string
	 */
	const API_PRODUCTION_URL = 'https://api.multisafepay.com/ewx/';
}
