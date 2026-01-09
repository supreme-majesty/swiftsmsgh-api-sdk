# Contributing to Swiftsms-GH PHP SDK

Thank you for considering contributing to the Swiftsms-GH PHP SDK! We welcome all contributions.

## How to Contribute

### Reporting Bugs

1. Check the [existing issues](https://github.com/supreme-majesty/swiftsmsgh-api-sdk/issues) to avoid duplicates
2. Create a new issue with a clear title and detailed description
3. Include steps to reproduce the bug and your environment details

### Suggesting Features

1. Open an issue describing the feature and its use case
2. Wait for discussion before starting implementation

### Pull Requests

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Make your changes following our coding standards
4. Run tests: `composer test`
5. Run static analysis: `composer analyse`
6. Run code style fixer: `composer cs-fix`
7. Commit your changes with a descriptive message
8. Push to your fork and submit a pull request

## Coding Standards

-   Follow PSR-12 coding style
-   Add PHPDoc blocks to all public methods
-   Write tests for new features
-   Keep methods focused and small

## Running Tests

```bash
# Install dependencies
composer install

# Run tests
composer test

# Run static analysis
composer analyse

# Fix code style
composer cs-fix
```

## Questions?

Feel free to open an issue for any questions or concerns.
