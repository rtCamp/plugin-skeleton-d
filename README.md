# Plugin Skeleton D

[![Try in WordPress Playground](https://img.shields.io/badge/Try%20in-WordPress%20Playground-blue?logo=wordpress)](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/rtCamp/plugin-skeleton-d/main/blueprint.json)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](LICENSE.md)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue?logo=php)](composer.json)
[![WordPress](https://img.shields.io/badge/WordPress-6.x%2B-blue?logo=wordpress)](https://wordpress.org)<br>
[![CI](https://github.com/rtCamp/plugin-skeleton-d/actions/workflows/ci.yml/badge.svg)](https://github.com/rtCamp/plugin-skeleton-d/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/rtCamp/plugin-skeleton-d/branch/main/graph/badge.svg)](https://codecov.io/gh/rtCamp/plugin-skeleton-d)
[![GitHub commits since latest release](https://img.shields.io/github/commits-since/rtCamp/plugin-skeleton-d/latest)](https://github.com/rtCamp/plugin-skeleton-d/releases)

---

A WordPress plugin skeleton with modular architecture, first-class tooling, and enterprise-grade best practices - for humans and agentic contributors. Battle-tested and ready to help your team build plugins better, faster, and without compromise.

## Documentation

- **[Development Guide](docs/DEVELOPMENT.md)** - Local setup, commands, testing, and contribution guidelines.
- **[Contributing](docs/CONTRIBUTING.md)** - How to contribute to this project.
- **[Code of Conduct](docs/CODE_OF_CONDUCT.md)** - Community standards.
- **[Security](docs/SECURITY.md)** - Reporting security vulnerabilities.

**Reference:**
[Action Hooks](docs/reference/actions.md) | [Filter Hooks](docs/reference/filters.md) | [Constants](docs/reference/constants.md) | [WP-CLI Commands](docs/reference/cli.md)

## Project Structure

```
├── .github/workflows/      # CI/CD workflows
├── docs/                   # Development guides and references
├── inc/                    # Plugin-specific PHP source
├── framework/              # Reusable framework (shared across plugins)
│   └── README.md
├── src/                    # TypeScript/JS entry points
│   └── README.md
├── templates/              # PHP templates with theme override support
└── tests/                  # PHPUnit, Jest, Playwright tests
```

See [./docs/DEVELOPMENT.md](docs/DEVELOPMENT.md#directory-structure) for a detailed directory tree and descriptions.

## Scaffolding a New Plugin

> [!NOTE]
> We recommend purging the example modules and blocks once you've understood the structure to keep your production codebase lean.

1. Create a new repo from this template.
2. Find and replace the following placeholder strings:
   - `plugin-skeleton-d` (slug)
   - `Plugin Skeleton D` (title)
   - `PLUGIN_SKELETON_D` (constant prefix)
   - `pluginSkeletonD` (camelCase reference)
   - `PluginSkeletonD` (PascalCase reference)
3. Update plugin metadata in these config files:
   - `.phpcs.xml.dist` (`testVersion`, `minimum_wp_version`)
   - `composer.json` (`config.platform.php`, `require.php`)
   - `phpstan.neon.dist` (`phpVersion`)
   - `plugin-skeleton-d.php`
   - `readme.txt`
4. Remove or replace example entrypoints and blocks from `src/`, then update `webpack.config.js` and `inc/Core/Assets.php`.
5. Update CI workflows in `.github/workflows/`.
6. Search for `@todo` comments and resolve them.
7. Remove all remaining example code from `inc/`, `src/`, and their corresponding `tests/`.
8. Update the documentation in `docs/` and **this README** to reflect your plugin's functionality and architecture.

## License

GPL-2.0-or-later. See [LICENSE.md](LICENSE.md).

<a href="https://rtcamp.com/"><img src="https://rtcamp.com/wp-content/uploads/sites/2/2019/04/github-banner@2x.png" alt="Join us at rtCamp, we specialize in providing high performance enterprise WordPress solutions"></a>
