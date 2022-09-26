# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

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
