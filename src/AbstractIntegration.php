<?php

abstract class Pronamic_WP_Pay_Gateways_MultiSafepay_AbstractIntegration extends Pronamic_WP_Pay_Gateways_AbstractIntegration {
	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_MultiSafepay_ConfigFactory';
	}

	public function get_config_class() {
		return 'Pronamic_WP_Pay_Gateways_MultiSafepay_Config';
	}

	public function get_settings_class() {
		return 'Pronamic_WP_Pay_Gateways_MultiSafepay_Settings';
	}
}
