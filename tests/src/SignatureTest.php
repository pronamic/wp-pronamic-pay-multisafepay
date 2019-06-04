<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_UnitTestCase;

/**
 * Test signature
 *
 * @link http://pronamic.nl/wp-content/uploads/2013/04/BPE-3.0-Gateway-HTML.1.02.pdf
 * @author remco
 */
class SignatureTest extends WP_UnitTestCase {
	/**
	 * Test signature.
	 */
	public function test_signature() {
		$amount         = 5000;
		$currency       = 'EUR';
		$account        = 'Test';
		$site_id        = '1234';
		$transaction_id = '1234567890';

		$signature = Signature::generate( $amount, $currency, $account, $site_id, $transaction_id );

		$expected = 'af90311cf82cbf9bb4fcda5a54005b92';

		$this->assertEquals( $expected, $signature );
	}
}
