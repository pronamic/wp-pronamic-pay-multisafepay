<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Banks\BankAccountDetails;
use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethod;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Core\PaymentMethodsCollection;
use Pronamic\WordPress\Pay\Core\Server;
use Pronamic\WordPress\Pay\Fields\CachedCallbackOptions;
use Pronamic\WordPress\Pay\Fields\IDealIssuerSelectField;
use Pronamic\WordPress\Pay\Fields\SelectField;
use Pronamic\WordPress\Pay\Fields\SelectFieldOption;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\DirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\RedirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\StatusRequestMessage;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: MultiSafepay Connect gateway
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.1.1
 * @since   1.0.1
 */
class Gateway extends Core_Gateway {
	/**
	 * Client.
	 *
	 * @var Client
	 */
	protected Client $client;

	/**
	 * Config
	 *
	 * @var Config
	 */
	protected Config $config;

	/**
	 * Constructs and initializes an MultiSafepay Connect gateway
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct();

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		$this->config = $config;

		// Supported features.
		$this->supports = [
			'payment_status_request',
		];

		// Payment method iDEAL.
		$ideal_payment_method = new PaymentMethod( PaymentMethods::IDEAL );

		$ideal_issuer_field = new IDealIssuerSelectField( 'pronamic_pay_multisafepay_ideal_issuer' );

		$ideal_issuer_field->set_options(
			new CachedCallbackOptions(
				function () {
					return $this->get_ideal_issuers();
				},
				'pronamic_pay_ideal_issuers_' . \md5( \wp_json_encode( $config ) )
			)
		);

		$ideal_payment_method->add_field( $ideal_issuer_field );

		// Payment method credit card.
		$credit_card_payment_method = new PaymentMethod( PaymentMethods::CREDIT_CARD );

		$credit_card_issuer_field = new SelectField( 'pronamic_pay_multisafepay_credit_card_issuer' );

		$credit_card_issuer_field->set_label( __( 'Card Brand', 'pronamic_ideal' ) );

		$credit_card_issuer_field->meta_key = 'issuer';

		$credit_card_issuer_field->set_options(
			new CachedCallbackOptions(
				function () {
					return $this->get_credit_card_issuers();
				},
				'pronamic_pay_credit_card_issuers_' . \md5( \wp_json_encode( $config ) )
			)
		);

		$credit_card_payment_method->add_field( $credit_card_issuer_field );

		// Payment methods.
		$this->register_payment_method( new PaymentMethod( PaymentMethods::ALIPAY ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::BANCONTACT ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::BANK_TRANSFER ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::BELFIUS ) );
		$this->register_payment_method( $credit_card_payment_method );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::DIRECT_DEBIT ) );
		$this->register_payment_method( $ideal_payment_method );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::IDEALQR ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::IN3 ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::GIROPAY ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::KBC ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::PAYPAL ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::SANTANDER ) );
		$this->register_payment_method( new PaymentMethod( PaymentMethods::SOFORT ) );

		// Client.
		$this->client = new Client();

		$this->client->api_url = $config->get_api_url();
	}

	/**
	 * Get iDEAL issuers.
	 *
	 * @return array<array<string,array>>
	 * @since 1.2.0
	 */
	private function get_ideal_issuers(): array {
		$merchant = new Merchant();

		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$result = $this->client->get_ideal_issuers( $merchant );

		if ( false === $result ) {
			return [];
		}

		$options = [];

		foreach ( $result as $key => $value ) {
			$options[] = new SelectFieldOption( $key, $value );
		}

		return $options;
	}

	/**
	 * Get credit card issuers
	 *
	 * @return array<array<string,array>>
	 */
	private function get_credit_card_issuers(): array {
		// Get active card issuers.
		$issuers = \array_intersect_key( $this->get_gateways(), Methods::get_cards() );

		asort( $issuers );

		$options = [];

		foreach ( $issuers as $key => $value ) {
			$options[] = new SelectFieldOption( $key, $value );
		}

		return $options;
	}

	/**
	 * Get payment methods.
	 *
	 * @param array $args Query arguments.
	 * @return PaymentMethodsCollection
	 */
	public function get_payment_methods( array $args = [] ): PaymentMethodsCollection {
		try {
			$this->maybe_enrich_payment_methods();
		} catch ( \Exception $e ) {
			// No problem.
		}

		return parent::get_payment_methods( $args );
	}

	/**
	 * Maybe enrich payment methods.
	 *
	 * @return void
	 */
	private function maybe_enrich_payment_methods() {
		$cache_key = 'pronamic_pay_multisafepay_payment_methods_' . \md5( \wp_json_encode( $this->config ) );

		$multisafepay_payment_methods = \get_transient( $cache_key );

		if ( false === $multisafepay_payment_methods ) {
			$multisafepay_payment_methods = $this->get_gateways();

			\set_transient( $cache_key, $multisafepay_payment_methods, \DAY_IN_SECONDS );
		}

		foreach ( $multisafepay_payment_methods as $method => $title ) {
			$core_payment_method_id = Methods::transform_gateway_method( $method );

			// Handle cards, as no general method for credit cards is returned by gateway.
			if ( null === $core_payment_method_id && \array_key_exists( $method, Methods::get_cards() ) ) {
				$core_payment_method_id = PaymentMethods::CREDIT_CARD;
			}

			$core_payment_method = $this->get_payment_method( $core_payment_method_id );

			if ( null !== $core_payment_method ) {
				$core_payment_method->set_status( 'active' );
			}
		}

		foreach ( $this->payment_methods as $payment_method ) {
			if ( '' === $payment_method->get_status() ) {
				$payment_method->set_status( 'inactive' );
			}
		}
	}

	/**
	 * Start payment.
	 *
	 * @param Payment $payment Payment object.
	 */
	public function start( Payment $payment ) {
		$payment_method = $payment->get_payment_method();

		$transaction_description = $payment->get_description();

		if ( empty( $transaction_description ) ) {
			$transaction_description = $payment->get_id();
		}

		// Merchant.
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;
		$merchant->notification_url = $payment->get_return_url();
		$merchant->redirect_url     = $payment->get_return_url();
		$merchant->cancel_url       = $payment->get_return_url();
		$merchant->close_window     = 'false';

		// Customer.
		$customer = new Customer();

		// phpcs:disable WordPressVIPMinimum.Variables.ServerVariables.UserControlledHeaders -- No problem, this is up to MultiSafepay.

		if ( \array_key_exists( 'REMOTE_ADDR', $_SERVER ) ) {
			// phpcs:ignore WordPressVIPMinimum.Variables.RestrictedVariables.cache_constraints___SERVER__REMOTE_ADDR__
			$customer->ip_address = \sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
		}

		if ( \array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER ) ) {
			$customer->forwarded_ip = \sanitize_text_field( $_SERVER['HTTP_X_FORWARDED_FOR'] );
		}

		// phpcs:enable WordPressVIPMinimum.Variables.ServerVariables.UserControlledHeaders

		if ( null !== $payment->get_customer() ) {
			$name = $payment->get_customer()->get_name();

			if ( null !== $name ) {
				$customer->first_name = $name->get_first_name();
				$customer->last_name  = $name->get_last_name();
			}

			$customer->locale = $payment->get_customer()->get_locale();
			$customer->email  = $payment->get_customer()->get_email();
		}

		// Transaction.
		$transaction              = new Transaction();
		$transaction->id          = uniqid();
		$transaction->currency    = $payment->get_total_amount()->get_currency()->get_alphabetic_code();
		$transaction->amount      = $payment->get_total_amount()->get_minor_units()->format( 0, '', '' );
		$transaction->description = $transaction_description;
		$transaction->gateway     = Methods::transform( $payment_method );

		switch ( $payment_method ) {
			case PaymentMethods::IDEAL:
				$issuer = $payment->get_meta( 'issuer' );

				if ( empty( $issuer ) ) {
					$message = new RedirectTransactionRequestMessage( $merchant, $customer, $transaction );
				} else {
					$gateway_info = new GatewayInfo();

					$gateway_info->issuer_id = $issuer;

					$message = new DirectTransactionRequestMessage( $merchant, $customer, $transaction, $gateway_info );
				}

				break;
			case PaymentMethods::CREDIT_CARD:
				$issuer = $payment->get_meta( 'issuer' );

				if ( ! empty( $issuer ) ) {
					$transaction->gateway = $issuer;
				}

				$message = new RedirectTransactionRequestMessage( $merchant, $customer, $transaction );

				break;
			default:
				if ( ! isset( $transaction->gateway ) && ! empty( $payment_method ) ) {
					// Leap of faith if the WordPress payment method could not transform to a Mollie method?
					$transaction->gateway = $payment_method;
				}

				$message = new RedirectTransactionRequestMessage( $merchant, $customer, $transaction );
		}

		$signature = Signature::generate( $transaction->amount, $transaction->currency, $merchant->account, $merchant->site_id, $transaction->id );

		$message->signature = $signature;

		$response = $this->client->start_transaction( $message );

		if ( false !== $response ) {
			$transaction = $response->transaction;

			$payment->set_transaction_id( $transaction->id );

			if ( isset( $transaction->payment_url ) ) {
				$payment->set_action_url( $transaction->payment_url );
			}

			if ( isset( $response->gateway_info->redirect_url ) ) {
				$payment->set_action_url( $response->gateway_info->redirect_url );
			}
		}
	}

	/**
	 * Update status.
	 *
	 * @param Payment $payment Payment.
	 */
	public function update_status( Payment $payment ) {
		$merchant = new Merchant();

		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$message = new StatusRequestMessage( $merchant, $payment->get_transaction_id() );

		$result = $this->client->get_status( $message );

		if ( false === $result ) {
			return;
		}

		// Status.
		$status = Statuses::transform( $result->ewallet->status );

		$payment->set_status( $status );

		// Consumer bank details.
		$consumer_bank_details = $payment->get_consumer_bank_details();

		if ( null === $consumer_bank_details ) {
			$consumer_bank_details = new BankAccountDetails();

			$payment->set_consumer_bank_details( $consumer_bank_details );
		}

		$consumer_bank_details->set_name( $result->payment_details->account_holder_name );
		$consumer_bank_details->set_iban( $result->payment_details->account_iban );
		$consumer_bank_details->set_bic( $result->payment_details->account_bic );

		if ( 'http' !== \substr( $result->payment_details->account_id, 0, 4 ) ) {
			$consumer_bank_details->set_account_number( $result->payment_details->account_id );
		}
	}

	/**
	 * Get gateways.
	 *
	 * @return array<string, string>
	 */
	private function get_gateways(): array {
		// Merchant.
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		// Customer.
		$customer = new Customer();

		// Get gateways.
		$gateways = [];

		$result = $this->client->get_gateways( $merchant, $customer );

		if ( false !== $result ) {
			$gateways = $result;
		}

		return $gateways;
	}
}
