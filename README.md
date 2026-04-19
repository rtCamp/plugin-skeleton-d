# Plugin Skeleton D

[![Try in WordPress Playground](https://img.shields.io/badge/Try%20in-WordPress%20Playground-blue?logo=wordpress)](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/rtCamp/plugin-skeleton-d/main/blueprint.json)

## What's included

- Automation:
  - Sensible [dependabot.yml](.github/dependabot.yml) for automated dependency updates.
  - Reusable GitHub workflows for CI ([README.md](.github/workflows/README.md))
- Tooling & Testing:
  - [ESlint](eslint.config.mjs)
  - [PHP_CodeSniffer](.phpcs.xml.dist)
  - [PHPStan](phpstan.neon.dist)
  - [Prettier](.prettierrc)
  - [Stylelint](stylelint.config.js)
  - [Typescript](tsconfig.json)
  - Enforcement with [lefthook](.lefthook.yml) and [lint-staged](.lintstagedrc.mjs)
- Testing:
  - [PHPUnit](phpunit.xml.dist)
  - [Jest](jest.config.js)
  - [Playwright](playwright.config.ts)
  - Coverage reports with [codecov](.github/.codecov.yml)
- Environment & Build:
  - [@wordpress/env](https://github.com/WordPress/gutenberg/tree/trunk/packages/env) support with a pre-configured [wp-env.json](wp-env.json)
  - Release demos and PR previews with [WP Playground](https://playground.wordpress.net/) using the included [blueprint.json](blueprint.json)
  - [@wordpress/scripts](https://github.com/WordPress/gutenberg/tree/trunk/packages/scripts) for build and dev tooling.
  - Automated release PRs with [release-please](https://github.com/googleapis/release-please) using the included [release-please-config.json](release-please-config.json)

## Docs

### Getting Started

- [Scaffolding Steps](#scaffold-steps)

### Contributing

- [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) for development and contribution guidelines.
- [docs/CONTRIBUTING.md](docs/CONTRIBUTING.md) for contribution guidelines.
- [docs/CODE_OF_CONDUCT.md](docs/CODE_OF_CONDUCT.md) for the code of conduct.
- [docs/SECURITY.md](docs/SECURITY.md) for security policies and reporting.

### References

- [Action Hooks](./docs/reference/actions.md)
- [Filter Hooks](./docs/reference/filters.md)
- [Constants](./docs/reference/constants.md)
- [WP-CLI Commands](./docs/reference/cli.md)

## To do

- [ ] GitHub workflows for private runners.
- [ ] docs/ARCHITECTURE.md
- [ ] Scaffold scripts (search/replace strings, delete examples and unused deps etc)

## Scaffold Steps

1. Create a new project from this repo.
2. Do a `find and replace` for the skeleton placeholder strings:
   - `plugin-skeleton-d` (slug)
   - `Plugin Skeleton D` (title)
   - `PLUGIN_SKELETON_D` (constant prefix)
   - `pluginSkeletonD` (camelCase reference)
   - `PluginSkeletonD` (PascalCase reference)
3. Update the plugin metadata in:
   - `.phpcs.xml.dist` (`testVersion`, `minimum_wp_version`)
   - `composer.json` (`config.platform.php`, `require.php`)
   - `phpstan.neon.dist` (`phpVersion`)
   - `plugin-skeleton-d.php`
   - `readme.txt`
   - `readme.md`
4. Remove and replace example TS entrypoints, and blocks if not needed:
   - `src/`
     Then, update the references to them in:
   - `webpack.config.js` (`entry`)
   - `inc/Core/Assets.php`
5. Update and replace the `.github/workflows` with the relevant CI for your project.
   - PHP Version in `ci.yml` and `release.yml` (latest supported)
   - PHPUnit test matrix in `ci.yml`
6. Search for `@todo` comments and resolve them as needed.
7. **Remove all remaining example code** from `inc` and `src` as needed, along with any relevant tests, unused dependencies, and references.
