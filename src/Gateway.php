<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use Pronamic\WordPress\Pay\Banks\BankAccountDetails;
use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Core\Server;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\DirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\RedirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\XML\StatusRequestMessage;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: MultiSafepay Connect gateway
 * Description:
 * Copyright: 2005-2022 Pronamic
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
	protected $client;

	/**
	 * Config
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Constructs and initializes an MultiSafepay Connect gateway
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		$this->config = $config;

		// Supported features.
		$this->supports = array(
			'payment_status_request',
		);

		// Client.
		$this->client = new Client();

		$this->client->api_url = $config->get_api_url();
	}

	/**
	 * Get iDEAL issuers
	 *
	 * @see Core_Gateway::get_issuers()
	 * @return array<array<string,array>>
	 * @since 1.2.0
	 */
	public function get_issuers() {
		$groups = array();

		// Merchant.
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$result = $this->client->get_ideal_issuers( $merchant );

		if ( $result ) {
			$groups[] = array(
				'options' => $result,
			);
		}

		return $groups;
	}

	/**
	 * Get credit card issuers
	 *
	 * @see Core_Gateway::get_credit_card_issuers()
	 * @return array<array<string,array>>
	 */
	public function get_credit_card_issuers() {
		// Get active card issuers.
		$issuers = \array_intersect_key( $this->get_gateways(), Methods::get_cards() );

		sort( $issuers );

		$groups = array(
			array(
				'options' => $issuers,
			),
		);

		return $groups;
	}

	/**
	 * Get payment methods
	 *
	 * @see Core_Gateway::get_payment_methods()
	 * @return array<string>
	 */
	public function get_available_payment_methods() {
		$payment_methods = array();

		$gateways = $this->get_gateways();

		foreach ( $gateways as $method => $title ) {
			$payment_method = Methods::transform_gateway_method( $method );

			// Handle cards, as no general method for credit cards is returned by gateway.
			if ( null === $payment_method && \array_key_exists( $method, Methods::get_cards() ) ) {
				$payment_method = PaymentMethods::CREDIT_CARD;
			}

			// Check valid payment method.
			if ( null === $payment_method ) {
				continue;
			}

			// Add available payment method.
			$payment_methods[] = $payment_method;
		}

		return $payment_methods;
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Core_Gateway::get_supported_payment_methods()
	 * @return array<string>
	 */
	public function get_supported_payment_methods() {
		return array(
			PaymentMethods::ALIPAY,
			PaymentMethods::BANCONTACT,
			PaymentMethods::BANK_TRANSFER,
			PaymentMethods::BELFIUS,
			PaymentMethods::CREDIT_CARD,
			PaymentMethods::DIRECT_DEBIT,
			PaymentMethods::IDEAL,
			PaymentMethods::IDEALQR,
			PaymentMethods::IN3,
			PaymentMethods::GIROPAY,
			PaymentMethods::KBC,
			PaymentMethods::PAYPAL,
			PaymentMethods::SANTANDER,
			PaymentMethods::SOFORT,
		);
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
		$customer               = new Customer();
		$customer->ip_address   = Server::get( 'REMOTE_ADDR', FILTER_VALIDATE_IP );
		$customer->forwarded_ip = Server::get( 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP );

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

		switch ( $payment_method ) {
			case PaymentMethods::IDEAL:
				$transaction->gateway = Methods::IDEAL;

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
				$gateway = Methods::transform( $payment_method );

				$issuer = $payment->get_meta( 'issuer' );

				if ( empty( $issuer ) ) {
					if ( $gateway ) {
						$transaction->gateway = $gateway;
					}
				} else {
					$transaction->gateway = $issuer;
				}

				$message = new RedirectTransactionRequestMessage( $merchant, $customer, $transaction );

				break;
			default:
				$gateway = Methods::transform( $payment_method );

				if ( $gateway ) {
					$transaction->gateway = $gateway;
				}

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
	private function get_gateways() {
		// Merchant.
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		// Customer.
		$customer = new Customer();

		// Get gateways.
		$gateways = array();

		$result = $this->client->get_gateways( $merchant, $customer );

		if ( false !== $result ) {
			$gateways = $result;
		}

		return $gateways;
	}
}
