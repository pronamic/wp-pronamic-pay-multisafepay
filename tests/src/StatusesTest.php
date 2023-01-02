<?php

namespace Pronamic\WordPress\Pay\Gateways\MultiSafepay;

use WP_UnitTestCase;
use Pronamic\WordPress\Pay\Payments\PaymentStatus as Core_Statuses;

/**
 * Title: MultiSafepay statuses test
 * Description:
 * Copyright: 2005-2023 Pronamic
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
		return [
			[ Statuses::COMPLETED, Core_Statuses::SUCCESS ],
			[ Statuses::INITIALIZED, Core_Statuses::OPEN ],
			[ Statuses::UNCLEARED, Core_Statuses::OPEN ],
			[ Statuses::VOID, Core_Statuses::CANCELLED ],
			[ Statuses::DECLINED, Core_Statuses::FAILURE ],
			[ Statuses::REFUNDED, Core_Statuses::CANCELLED ],
			[ Statuses::EXPIRED, Core_Statuses::EXPIRED ],
			[ 'not existing response code', null ],
		];
	}
}
