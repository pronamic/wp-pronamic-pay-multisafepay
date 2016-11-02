<?php

/**
 * Title: MultiSafepay connect gateways
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @since 1.2.0
 * @version 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways {
	/**
	 * Gateway iDEAL
	 *
	 * @var string
	 */
	const IDEAL = 'IDEAL';

	/**
	 * Gateway Visa via Multipay
	 *
	 * @var string
	 */
	const MASTERCARD = 'MASTERCARD';

	/**
	 * Gateway Bank Transfer
	 *
	 * @var string
	 */
	const BANK_TRANSFER = 'BANKTRANS';

	/**
	 * Gateway Visa CreditCards
	 *
	 * @var string
	 */
	const VISA = 'VISA';
}
