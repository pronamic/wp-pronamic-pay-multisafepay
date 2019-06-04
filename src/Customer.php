<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

/**
 * Title: MutliSafepay Connect customer
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.0.0
 */
class Customer {
	public $locale;

	public $ip_address;

	public $forwarded_ip;

	public $first_name;

	public $last_name;

	public $address_1;

	public $address_2;

	public $house_number;

	public $zip_code;

	public $city;

	public $country;

	public $phone;

	public $email;

	/**
	 * Constructs and initialize an MultiSafepay Connect customer object
	 */
	public function __construct() {

	}
}
