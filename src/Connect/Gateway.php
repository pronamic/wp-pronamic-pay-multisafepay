<?php

/**
 * Title: MultiSafepay Connect gateay
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.9
 * @since 1.0.1
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Gateway extends Pronamic_WP_Pay_Gateway {
	/**
	 * Slug of this gateway
	 *
	 * @var string
	 */
	const SLUG = 'multisafepay-connect';

	/////////////////////////////////////////////////

	/**
	 * Constructs and initializes an MultiSafepay Connect gateway
	 *
	 * @param Pronamic_WP_Pay_Gateways_MultiSafepay_Config $config
	 */
	public function __construct( Pronamic_WP_Pay_Gateways_MultiSafepay_Config $config ) {
		parent::__construct( $config );

		$this->set_method( Pronamic_WP_Pay_Gateway::METHOD_HTTP_REDIRECT );
		$this->set_has_feedback( true );
		$this->set_amount_minimum( 0 );
		$this->set_slug( self::SLUG );

		$this->client = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Client();
		$this->client->api_url = $config->api_url;
	}

	/////////////////////////////////////////////////

	/**
	 * Get issuers
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_issuers()
	 * @since 1.2.0
	 */
	public function get_issuers() {
		$groups = array();

		// Merchant
		$merchant = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Merchant();
		$merchant->account = $this->config->account_id;
		$merchant->site_id = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$result = $this->client->get_ideal_issuers( $merchant );

		if ( $result ) {
			$groups[] = array(
				'options' => $result,
			);
		}

		return $groups;
	}

	/////////////////////////////////////////////////

	/**
	 * Get issuer field
	 *
	 * @since 1.2.0
	 */
	public function get_issuer_field() {
		if ( Pronamic_WP_Pay_PaymentMethods::IDEAL === $this->get_payment_method() ) {
			return array(
				'id'       => 'pronamic_ideal_issuer_id',
				'name'     => 'pronamic_ideal_issuer_id',
				'label'    => __( 'Choose your bank', 'pronamic_ideal' ),
				'required' => true,
				'type'     => 'select',
				'choices'  => $this->get_transient_issuers(),
			);
		}
	}

	/////////////////////////////////////////////////

	/**
	 * Get payment methods
	 *
	 * @return mixed an array or null
	 */
	public function get_payment_methods() {
		$payment_methods = new ReflectionClass( 'Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways' );

		return array( array( 'options' => $payment_methods->getConstants() ) );
	}

	/////////////////////////////////////////////////

	/**
	 * Get supported payment methods
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
	 */
	public function get_supported_payment_methods() {
		return array(
			Pronamic_WP_Pay_PaymentMethods::IDEAL,
			Pronamic_WP_Pay_PaymentMethods::BANK_TRANSFER,
		);
	}

	/////////////////////////////////////////////////

	/**
	 * Start payment.
	 *
	 * @param Pronamic_Pay_Payment $payment payment object
	 */
	public function start( Pronamic_Pay_Payment $payment ) {
		$transaction_description = $payment->get_description();

		if ( empty( $transaction_description ) ) {
			$transaction_description = $payment->get_id();
		}

		$merchant = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Merchant();
		$merchant->account          = $this->config->account_id;
		$merchant->site_id          = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;
		$merchant->notification_url = $payment->get_return_url();
		$merchant->redirect_url     = $payment->get_return_url();
		$merchant->cancel_url       = $payment->get_return_url();
		$merchant->close_window     = 'false';

		$customer = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Customer();
		$customer->locale       = $payment->get_locale();
		$customer->ip_address   = Pronamic_WP_Pay_Server::get( 'REMOTE_ADDR', FILTER_VALIDATE_IP );
		$customer->forwarded_ip = Pronamic_WP_Pay_Server::get( 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP );
		$customer->first_name   = $payment->get_customer_name();
		$customer->email        = $payment->get_email();

		$transaction = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Transaction();
		$transaction->id          = uniqid();
		$transaction->currency    = $payment->get_currency();
		$transaction->amount      = $payment->get_amount();
		$transaction->description = $transaction_description;

		switch ( $payment->get_method() ) {
			case Pronamic_WP_Pay_PaymentMethods::IDEAL :
				$gateway_info = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_GatewayInfo();
				$gateway_info->issuer_id = $payment->get_issuer();

				$transaction->gateway = Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::IDEAL;

				$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_DirectTransactionRequestMessage( $merchant, $customer, $transaction, $gateway_info );

				break;

			case Pronamic_WP_Pay_PaymentMethods::BANK_TRANSFER :
				$transaction->gateway = Pronamic_WP_Pay_Gateways_MultiSafepay_Gateways::BANK_TRANSFER;

				$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionRequestMessage( $merchant, $customer, $transaction );

				break;

			default:
				$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_RedirectTransactionRequestMessage( $merchant, $customer, $transaction );
		}

		$signature = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Signature::generate( $transaction->amount, $transaction->currency, $merchant->account, $merchant->site_id, $transaction->id );

		$message->signature = $signature;

		$response = $this->client->start_transaction( $message );

		if ( $response ) {
			$transaction = $response->transaction;

			$payment->set_transaction_id( $transaction->id );

			if ( $transaction->payment_url ) {
				$payment->set_action_url( $transaction->payment_url );
			}

			if ( $response->gateway_info && $response->gateway_info->redirect_url ) {
				$payment->set_action_url( $response->gateway_info->redirect_url );
			}
		} else {
			$this->error = $this->client->get_error();
		}
	}

	public function update_status( Pronamic_Pay_Payment $payment ) {
		$merchant = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Merchant();
		$merchant->account = $this->config->account_id;
		$merchant->site_id = $this->config->site_id;
		$merchant->site_secure_code = $this->config->site_code;

		$message = new Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_XML_StatusRequestMessage( $merchant, $payment->get_transaction_id() );

		$result = $this->client->get_status( $message );

		if ( $result ) {
			$status = Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_Statuses::transform( $result->ewallet->status );

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
