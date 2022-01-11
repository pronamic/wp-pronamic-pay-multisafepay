<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Core\PaymentMethods;

/**
 * Title: MultiSafepay connect payment methods
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.2
 * @since   1.2.0
 */
class Methods {
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
	 * Gateway IN3
	 *
	 * @var string
	 */
	const IN3 = 'IN3';

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
	 * Gateway Credit card
	 *
	 * @var string
	 */
	const CREDITCARD = 'CREDITCARD';

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
	 * Gateway Santander
	 *
	 * @var string
	 */
	const SANTANDER = 'SANTANDER';

	/**
	 * Payments methods map.
	 *
	 * @var array<string, string>
	 */
	private static $map = array(
		PaymentMethods::ALIPAY        => self::ALIPAY,
		PaymentMethods::BANCONTACT    => self::BANCONTACT,
		PaymentMethods::BANK_TRANSFER => self::BANK_TRANSFER,
		PaymentMethods::BELFIUS       => self::BELFIUS,
		PaymentMethods::CREDIT_CARD   => self::CREDITCARD,
		PaymentMethods::DIRECT_DEBIT  => self::DIRECT_DEBIT,
		PaymentMethods::GIROPAY       => self::GIROPAY,
		PaymentMethods::IDEAL         => self::IDEAL,
		PaymentMethods::IDEALQR       => self::IDEALQR,
		PaymentMethods::IN3           => self::IN3,
		PaymentMethods::KBC           => self::KBC,
		PaymentMethods::PAYPAL        => self::PAYPAL,
		PaymentMethods::SANTANDER     => self::SANTANDER,
		PaymentMethods::SOFORT        => self::SOFORT,
	);

	/**
	 * Transform WordPress payment method to MultiSafepay method.
	 *
	 * @param string|null $payment_method Payment method.
	 * @param string|null $default        Default payment method.
	 * @return string|null
	 */
	public static function transform( $payment_method, $default = null ) {
		if ( ! \is_scalar( $payment_method ) ) {
			return null;
		}

		if ( isset( self::$map[ $payment_method ] ) ) {
			return self::$map[ $payment_method ];
		}

		return $default;
	}

	/**
	 * Transform MultiSafepay method to WordPress payment method.
	 *
	 * @param string $method MultiSafepay method.
	 * @return string|null
	 */
	public static function transform_gateway_method( $method ) {
		if ( ! \is_scalar( $method ) ) {
			return null;
		}

		$payment_method = \array_search( $method, self::$map, true );

		if ( ! \is_string( $payment_method ) ) {
			return null;
		}

		return $payment_method;
	}

	/**
	 * Get cards.
	 *
	 * @return array<string, string>
	 */
	public static function get_cards() {
		return array(
			self::AMEX       => _x( 'American Express', 'Payment method name', 'pronamic_ideal' ),
			self::MAESTRO    => _x( 'Maestro', 'Payment method name', 'pronamic_ideal' ),
			self::MASTERCARD => _x( 'Mastercard', 'Payment method name', 'pronamic_ideal' ),
			self::VISA       => _x( 'Visa', 'Payment method name', 'pronamic_ideal' ),
		);
	}
}
