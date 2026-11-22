# Plugin Skeleton D - Framework

This directory holds what the plugin still needs on top of [`rtcamp/wp-primitives`](https://github.com/rtCamp/wp-primitives). Anything `wp-primitives` already provides is imported directly, from its prefixed namespace (`rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives`).

## Principles

- **Import first**: if a primitive does the same job, use it directly and don't keep a copy here.
- **Shim differences**: if the plugin needs something a primitive doesn't do, a class here extends the primitive and `inc/` uses that class. Keep the shim as thin as possible.

> [!IMPORTANT]
> Before adding to the framework, ask yourself if the change would be useful to other plugins.
> If _yes_, consider contributing it to `wp-primitives`, so that all plugins can benefit from it.
> If _no_, consider how to best implement the change inside your `inc/` directory.

## Contents

```bash
framework/
├── README.md # 🎯 You are here.
│
├── Contracts/
│   └── Abstracts/
│       ├── Abstract_Post_Type.php
│       ├── Abstract_REST_Controller.php # AbstractRESTController with the plugin's route namespace.
│       └── Abstract_Taxonomy.php
│
├── AssetLoaderTrait.php # Trait for loading assets (scripts/styles/blocks).
├── AutoloaderTrait.php  # Trait for Composer autoloader.
└── Encryptor.php        # Simple encryption/decryption utility class.
```

## Testing

Tests for the framework are located in [`tests/phpunit/Framework`](../tests/phpunit/Framework). They should not contain any plugin-specific tests or dependencies.

```bash
# Optional: restart wp-env with coverage enabled
npm run wp-env:test start -- --xdebug=coverage

# Run tests
npm run test:php
npm run test:php -- tests/phpunit/Framework
```
