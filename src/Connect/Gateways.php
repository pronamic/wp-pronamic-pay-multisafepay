<?php

/**
 * Title: MultiSafepay connect gateways
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @since 1.2.0
 * @version 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways {
	/**
	 * Gateway Alipay
	 *
	 * @var string
	 */
	const ALIPAY = 'ALIPAY';

	/**
	 * Gateway American Express
	 *
	 * @var string
	 */
	const AMEX = 'AMEX';

	/**
	 * Gateway Bank Transfer
	 *
	 * @var string
	 */
	const BANK_TRANSFER = 'BANKTRANS';

	/**
	 * Gateway Belfius
	 *
	 * @var string
	 */
	const BELFIUS = 'BELFIUS';

	/**
	 * Gateway Direct Debit
	 *
	 * @var string
	 */
	const DIRECT_DEBIT = 'DIRDEB';

	/**
	 * Gateway SOFORT Banking
	 *
	 * @var string
	 */
	const SOFORT = 'DIRECTBANK';

	/**
	 * Gateway DotPay
	 *
	 * @var string
	 */
	const DOTPAY = 'DOTPAY';

	/**
	 * Gateway Giropay
	 *
	 * @var string
	 */
	const GIROPAY = 'GIROPAY';

	/**
	 * Gateway iDEAL QR
	 *
	 * @var string
	 */
	const IDEALQR = 'IDEALQR';

	/**
	 * Gateway iDEAL
	 *
	 * @var string
	 */
	const IDEAL = 'IDEAL';

	/**
	 * Gateway ING
	 *
	 * @var string
	 */
	const ING = 'ING';

	/**
	 * Gateway KBC
	 *
	 * @var string
	 */
	const KBC = 'KBC';

	/**
	 * Gateway Maestro
	 *
	 * @var string
	 */
	const MAESTRO = 'MAESTRO';

	/**
	 * Gateway Mastercard
	 *
	 * @var string
	 */
	const MASTERCARD = 'MASTERCARD';

	/**
	 * Gateway Bancontact
	 *
	 * @var string
	 */
	const BANCONTACT = 'MISTERCASH';

	/**
	 * Gateway Pay after delivery
	 *
	 * @var string
	 */
	const PAYAFTER = 'PAYAFTER';

	/**
	 * Gateway PayPal
	 *
	 * @var string
	 */
	const PAYPAL = 'PAYPAL';

	/**
	 * Gateway Visa
	 *
	 * @var string
	 */
	const VISA = 'VISA';

	/**
	 * Payments methods map.
	 *
	 * @var array
	 */
	private static $map = array(
		Pronamic_WP_Pay_PaymentMethods::BANCONTACT    => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::BANCONTACT,
		Pronamic_WP_Pay_PaymentMethods::BANK_TRANSFER => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::BANK_TRANSFER,
		Pronamic_WP_Pay_PaymentMethods::BELFIUS       => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::BELFIUS,
		Pronamic_WP_Pay_PaymentMethods::DIRECT_DEBIT  => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::DIRECT_DEBIT,
		Pronamic_WP_Pay_PaymentMethods::GIROPAY       => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::GIROPAY,
		Pronamic_WP_Pay_PaymentMethods::IDEAL         => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::IDEAL,
		Pronamic_WP_Pay_PaymentMethods::IDEALQR       => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::IDEALQR,
		Pronamic_WP_Pay_PaymentMethods::KBC           => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::KBC,
		Pronamic_WP_Pay_PaymentMethods::PAYPAL        => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::PAYPAL,
		Pronamic_WP_Pay_PaymentMethods::SOFORT        => Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::SOFORT,
	);

	/**
	 * Transform WordPress payment method to MultiSafepay method.
	 *
	 * @since unreleased
	 * @param string $payment_method
	 * @return string
	 */
	public static function transform( $payment_method ) {
		if ( ! is_scalar( $payment_method ) ) {
			return null;
		}

		if ( isset( self::$map[ $payment_method ] ) ) {
			return self::$map[ $payment_method ];
		}

		return null;
	}
}
