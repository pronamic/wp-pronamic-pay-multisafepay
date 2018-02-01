<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

/**
 * Title: MutliSafepay Connect merchant
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @since  1.0.0
 */
class Merchant {
	public $account;

	public $site_id;

	public $site_secure_code;

	public $notification_url;

	public $redirect_url;

	public $cancel_url;

	public $close_window;
}
