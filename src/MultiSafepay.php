<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

/**
 * Title: MultiSafepay
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
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
