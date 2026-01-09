# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.4] - 2026-01-09

### Fixed

-   Enforced PHP 8.0 platform compatibility in `composer.json` to fix `composer install` on older PHP versions
-   Downgraded dev dependencies in `composer.lock` for broad compatibility

## [1.0.3] - 2026-01-09

### Fixed

-   lowered minimum PHP version requirement to 8.0
-   Removed PHP 8.1+ `readonly` property modifiers for compatibility

## [1.0.2] - 2026-01-09

### Added

-   WhatsApp messaging support via `send_whatsapp()` method
-   Viber messaging support via `send_viber()` method
-   Voice call support via `send_voice()` method
-   MMS messaging support via `send_mms()` method
-   OTP sending support via `send_otp()` method
-   Scheduled messaging with `schedule_time` option
-   Custom Sender ID override via `sender_id` option
-   Contact group management methods
-   Individual contact management methods
-   Exception handling with `SwiftsmsException`
-   Comprehensive README documentation
-   EditorConfig for consistent code style
-   Contributing guidelines

### Changed

-   Renamed `ManagesApps` trait to `ManagesWhatsApp` for clarity

## [1.0.0] - 2026-01-09

### Added

-   Initial release
-   Basic SMS sending functionality
-   Balance checking
-   Profile viewing
-   API token authentication
