# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [4.4.0] - 2024-03-26

### Added

- Added `<plugin>` information to direct transaction request message. ([880676c](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/880676cd13e0f85229c70a133e75ecab539d8e96))

### Composer

- Added `automattic/jetpack-autoloader` `^3.0`.
- Added `woocommerce/action-scheduler` `^3.7`.
- Changed `pronamic/wp-http` from `^1.1` to `v1.2.2`.
	Release notes: https://github.com/pronamic/wp-http/releases/tag/v1.2.2
- Changed `wp-pay/core` from `^4.6` to `v4.16.0`.
	Release notes: https://github.com/pronamic/wp-pay-core/releases/tag/v4.16.0

Full set of changes: [`4.3.4...4.4.0`][4.4.0]

[4.4.0]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.3.4...v4.4.0

## [4.3.4] - 2023-10-13

### Commits

- Removed unused `use Pronamic\WordPress\Pay\Core\Server`. ([068672d](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/068672d12603a0a93f93486d2b11adde25886d5e))
- No longer user `Server::get` method, will be removed. ([55879af](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/55879af793cb18e0763caa54376f42832806a379))
- It is recommended not to use reserved keyword "default". ([e2543fa](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/e2543fa1810e5d18e0fa7b54a87fde08a098476f))
- All output should be run through an escaping function. ([73632a1](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/73632a1c1b31bfa53465b9ff65bda12d04c6fd18))
- It is recommended not to use reserved keyword "class". ([e14f177](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/e14f1770b34d9806edeb497b5727e916f5163b16))

Full set of changes: [`4.3.3...4.3.4`][4.3.4]

[4.3.4]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.3.3...v4.3.4

## [4.3.3] - 2023-06-01

### Commits

- Switch from `pronamic/wp-deployer` to `pronamic/pronamic-cli`. ([4a66e2d](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/4a66e2d2f6fb56281390aba5e4706b0a55a54cc0))
- Updated .gitattributes ([a144daa](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/a144daa78c06226046f633b45eae5f83811b8410))

Full set of changes: [`4.3.2...4.3.3`][4.3.3]

[4.3.3]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.3.2...v4.3.3

## [4.3.2] - 2023-03-27

### Commits

- Updated composer.json ([1537660](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/1537660926de50d10fb9e07fab1d10b361ae1380))
- Updated .gitattributes ([e352e45](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/e352e45da7a176ebe5ce55820a99ef6b68c7a5ce))

Full set of changes: [`4.3.1...4.3.2`][4.3.2]

[4.3.2]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.3.1...v4.3.2

## [4.3.1] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`4.3.0...4.3.1`][4.3.1]

[4.3.1]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.3.0...v4.3.1

## [4.3.0] - 2022-12-22

### Commits

- Use `pronamic/wp-http` for remote request and SimleXML. ([59882c9](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/59882c92776d66b244f67d00d8a719739f9f5e9b))
- Improving PHP 8.0 support. ([2f6be14](https://github.com/pronamic/wp-pronamic-pay-multisafepay/commit/2f6be1429c411b532aa907992329b6b172e4468f))

### Composer

- Added `pronamic/wp-http` `^1.1`.
- Changed `php` from `>=5.6.20` to `>=8.0`.
- Changed `wp-pay/core` from `^4.0` to `v4.6.0`.
	Release notes: https://github.com/pronamic/wp-pay-core/releases/tag/v4.2.0
Full set of changes: [`4.2.0...4.3.0`][4.3.0]

[4.3.0]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/v4.2.0...v4.3.0

## [4.2.0] - 2022-09-26
- Updated payment methods registration.

## [4.1.2] - 2022-08-15
- Fixed parsing gateways response message ([pronamic/wp-pronamic-pay-multisafepay#3](https://github.com/pronamic/wp-pronamic-pay-multisafepay/issues/3)).

## [4.1.1] - 2022-05-30
### Fixed
- Fix possible "Warning: Invalid argument supplied for foreach()" with incomplete config.

## [4.1.0] - 2022-04-11
- No longer use global core mode.
- No longer catch exceptions, should be handled downstream.
- Remove gateway error usage, exception should be handled downstream.

## [4.0.1] - 2022-02-16
- Fixed possible error "Call to a member function get_total() on null".

## [4.0.0] - 2022-01-11
### Changed
- Updated to https://github.com/pronamic/wp-pay-core/releases/tag/4.0.0.
- Improved credit card support.

## [3.0.0] - 2021-08-05
- Updated to `pronamic/wp-pay-core`  version `3.0.0`.
- Updated to `pronamic/wp-money`  version `2.0.0`.
- Changed `TaxedMoney` to `Money`, no tax info.
- Switched to `pronamic/wp-coding-standards`.

## [2.1.3] - 2021-04-26
- Happy 2021.

## [2.1.2] - 2021-01-18
- Added support for In3 payment method.
- Added partial support for Santander 'Betaal per maand' payment method.

## [2.1.1] - 2020-06-02
- Update setting consumer bank details.

## [2.1.0] - 2020-03-19
- Extend from AbstractGatewayIntegration class.

## [2.0.6] - 2020-02-03
- Improved error handling.

## [2.0.5] - 2019-12-22
- Added URL to manual in gateway settings.
- Improved error handling with exceptions.
- Updated payment status class name.

## [2.0.4] - 2019-08-27
- Updated packages.

## [2.0.3] - 2018-12-12
- Use issuer field from core gateway.
- Updated deprecated function calls.

## [2.0.2] - 2018-05-14
- Switched to PHP namespaces.

## [2.0.1] - 2017-12-12
- Added support for first and last name.

## [2.0.0] - 2016-11-02
- Merged in https://github.com/wp-pay-gateways/multisafepay-connect.

## [1.1.4] - 2016-03-22
- Updated gateway settings.

## [1.1.3] - 2016-03-02
- Added get settings function.
- Moving some code the connect library.

## [1.1.2] - 2016-02-01
- Added an gateway settings class.

## [1.1.1] - 2015-03-26
- Updated to WordPress pay core library version 1.2.0.

## [1.1.0] - 2015-02-27
- Updated to WordPress pay core library version 1.1.0.

## 1.0.0 - 2015-01-19
- First release.

[unreleased]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.2.0...HEAD
[4.2.0]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.1.2...4.2.0
[4.1.2]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.1.1...4.1.2
[4.1.1]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.1.0...4.1.1
[4.1.0]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.0.1...4.1.0
[4.0.1]: https://github.com/pronamic/wp-pronamic-pay-multisafepay/compare/4.0.0...4.0.1
[4.0.0]: https://github.com/wp-pay-gateways/multisafepay/compare/3.0.0...4.0.0
[3.0.0]: https://github.com/wp-pay-gateways/multisafepay/compare/2.1.3...3.0.0
[2.1.3]: https://github.com/wp-pay-gateways/multisafepay/compare/2.1.2...2.1.3
[2.1.2]: https://github.com/wp-pay-gateways/multisafepay/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/wp-pay-gateways/multisafepay/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.6...2.1.0
[2.0.6]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.5...2.0.6
[2.0.5]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/wp-pay-gateways/multisafepay/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/wp-pay-gateways/multisafepay/compare/1.1.4...2.0.0
[1.1.4]: https://github.com/wp-pay-gateways/multisafepay/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/wp-pay-gateways/multisafepay/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/wp-pay-gateways/multisafepay/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/wp-pay-gateways/multisafepay/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/wp-pay-gateways/multisafepay/compare/1.0.0...1.1.0
