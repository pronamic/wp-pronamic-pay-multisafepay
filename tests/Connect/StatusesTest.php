<?php

use Pronamic\WordPress\Pay\Core\Statuses as Core_Statuses;
use Pronamic\WordPress\Pay\Gateways\MultiSafepay\Connect\Statuses;

/**
 * Title: MultiSafepay statuses test
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.2.0
 * @since 1.2.0
 */
class Pronamic_WP_Pay_Gateways_MultiSafepay_Connect_StatusesTest extends WP_UnitTestCase {
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
