<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Payments\PaymentStatus as Core_Statuses;

/**
 * Title: MultiSafepay statuses test
 * Description:
 * Copyright: 2005-2021 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.2.0
 */
class StatusesTest extends WP_UnitTestCase {
	/**
	 * Test transform
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $status, $expected ) {
		$status = Statuses::transform( $status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return array(
			array( Statuses::COMPLETED, Core_Statuses::SUCCESS ),
			array( Statuses::INITIALIZED, Core_Statuses::OPEN ),
			array( Statuses::UNCLEARED, Core_Statuses::OPEN ),
			array( Statuses::VOID, Core_Statuses::CANCELLED ),
			array( Statuses::DECLINED, Core_Statuses::FAILURE ),
			array( Statuses::REFUNDED, Core_Statuses::CANCELLED ),
			array( Statuses::EXPIRED, Core_Statuses::EXPIRED ),
			array( 'not existing response code', null ),
		);
	}
}
