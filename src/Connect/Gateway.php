<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Core\Server;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\DirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\RedirectTransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\XML\StatusRequestMessage;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: MultiSafepay Connect gateay
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.2.9
 * @since   1.0.1
 */
class Gateway extends Core_Gateway {
	/**
	 * Slug of this gateway
	 *
	 * @var string
	 */
	const SLUG = 'multisafepay-connect';

	/**
	 * Config
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Constructs and initializes an MultiSafepay Connect gateway
	 *
	 * @param Config $config
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->supports = array(
			'payment_status_request',
		);

		$this->set_method( Gateway::METHOD_HTTP_REDIRECT );
		$this->set_has_feedback( true );
		$this->set_amount_minimum( 0 );
		$this->set_slug( self::SLUG );

		$this->client = new Client();

		$this->client->api_url = $config->api_url;
	}

	/**
	 * Get iDEAL issuers
	 *
	 * @see Core_Gateway::get_issuers()
	 * @since 1.2.0
	 */
	public function get_issuers() {
		$groups = array();

		// Merchant
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
	 */
	public function get_credit_card_issuers() {
		$groups[] = array(
			'options' => array(
				Methods::AMEX       => _x( 'AMEX', 'Payment method name', 'pronamic_ideal' ),
				Methods::MAESTRO    => _x( 'Maestro', 'Payment method name', 'pronamic_ideal' ),
				Methods::MASTERCARD => _x( 'MASTER', 'Payment method name', 'pronamic_ideal' ),
				Methods::VISA       => _x( 'VISA', 'Payment method name', 'pronamic_ideal' ),
			),
		);

		return $groups;
	}

	/**
	 * Get issuer field
	 *
	 * @since 1.2.0
	 */
	public function get_issuer_field() {
		switch ( $this->get_payment_method() ) {
			case PaymentMethods::IDEAL:
				return array(
					'id'       => 'pronamic_ideal_issuer_id',
					'name'     => 'pronamic_ideal_issuer_id',
					'label'    => __( 'Choose your bank', 'pronamic_ideal' ),
					'required' => true,
					'type'     => 'select',
					'choices'  => $this->get_transient_issuers(),
				);

			case PaymentMethods::CREDIT_CARD:
				return array(
					'id'       => 'pronamic_credit_card_issuer_id',
					'name'     => 'pronamic_credit_card_issuer_id',
					'label'    => __( 'Choose your credit card issuer', 'pronamic_ideal' ),
					'required' => true,
					'type'     => 'select',
					'choices'  => $this->get_transient_credit_card_issuers(),
				);
		}
	}

	/**
	 * Get payment methods
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_payment_methods()
	 */
	public function get_payment_methods() {
		$groups = array();

		// Merchant
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		// Customer
		$customer = new Customer();

		$result = $this->client->get_gateways( $merchant, $customer );

		if ( ! $result ) {
			$this->error = $this->client->get_error();

			return $groups;
		}

		$groups[] = array(
			'options' => $result,
		);

		return $groups;
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
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
			PaymentMethods::GIROPAY,
			PaymentMethods::KBC,
			PaymentMethods::PAYPAL,
			PaymentMethods::SOFORT,
		);
	}

	/**
	 * Start payment.
	 *
	 * @param Payment $payment payment object
	 */
	public function start( Payment $payment ) {
		$payment_method = $payment->get_method();

		$transaction_description = $payment->get_description();

		if ( empty( $transaction_description ) ) {
			$transaction_description = $payment->get_id();
		}

		// Merchant
		$merchant                   = new Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;
		$merchant->notification_url = $payment->get_return_url();
		$merchant->redirect_url     = $payment->get_return_url();
		$merchant->cancel_url       = $payment->get_return_url();
		$merchant->close_window     = 'false';

		// Customer
		$customer               = new Customer();
		$customer->locale       = $payment->get_locale();
		$customer->ip_address   = Server::get( 'REMOTE_ADDR', FILTER_VALIDATE_IP );
		$customer->forwarded_ip = Server::get( 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP );
		$customer->first_name   = $payment->get_first_name();
		$customer->last_name    = $payment->get_last_name();
		$customer->email        = $payment->get_email();

		// Transaction
		$transaction              = new Transaction();
		$transaction->id          = uniqid();
		$transaction->currency    = $payment->get_currency();
		$transaction->amount      = $payment->get_amount();
		$transaction->description = $transaction_description;

		switch ( $payment_method ) {
			case PaymentMethods::IDEAL:
				$transaction->gateway = Methods::IDEAL;

				$issuer = $payment->get_issuer();

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

				$issuer = $payment->get_issuer();

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

		if ( $response ) {
			$transaction = $response->transaction;

			$payment->set_transaction_id( $transaction->id );

			if ( isset( $transaction->payment_url ) ) {
				$payment->set_action_url( $transaction->payment_url );
			}

			if ( isset( $response->gateway_info->redirect_url ) ) {
				$payment->set_action_url( $response->gateway_info->redirect_url );
			}
		} else {
			$this->error = $this->client->get_error();
		}
	}

	public function update_status( Payment $payment ) {
		$merchant = new Merchant();

		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$message = new StatusRequestMessage( $merchant, $payment->get_transaction_id() );

		$result = $this->client->get_status( $message );

		if ( $result ) {
			$status = Statuses::transform( $result->ewallet->status );

			$payment->set_status( $status );
			$payment->set_consumer_name( $result->payment_details->account_holder_name );
			$payment->set_consumer_iban( $result->payment_details->account_iban );
			$payment->set_consumer_bic( $result->payment_details->account_bic );
			$payment->set_consumer_account_number( $result->payment_details->account_id );
		} else {
			$this->error = $this->client->get_error();
		}
	}
}
