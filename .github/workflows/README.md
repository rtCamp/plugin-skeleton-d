# GitHub Workflows

The `reusable-*.yml` workflows are meant to be called from other repositories, not copied. The top-level workflows below call them locally, so this repository tests its own changes, and double as templates for consuming repositories.

## Using these workflows in another repository

Copy the top-level workflows you need, and point each `uses:` at this repository, pinned to the commit SHA of a release:

```yaml
uses: rtCamp/plugin-skeleton-d/.github/workflows/reusable-build<-public>.yml@<commit-sha> # vX.Y.Z
```

- Use the `*-public.yml` variants for public repositories on GitHub-hosted runners, and the un-suffixed variants for private repositories on self-hosted runners. Both variants of a pair accept the same inputs, so switching only changes the `uses:` line.
- Pass your plugin's slug (directory name and text domain) as `plugin-slug` to the build, PHPUnit, E2E and Playground workflows. The repository name must match it, since wp-env and the `package.json` scripts name the plugin directory after the checkout.
- Secrets are not inherited, so pass them explicitly with `secrets:`. See [Secrets](#secrets).

### Versioning

Workflow changes ship in this repository's releases, under the changelog's "Continuous Integration" section (`ci:` commits). Renaming or removing an input, or making one required, breaks callers: mark those commits as breaking with `ci!:` or a `BREAKING CHANGE:` footer.

## Workflows

### Code Review: [`ci.yml`](ci.yml)

Main CI pipeline used to validate code. Based on file changes it calls the following reusable workflows:

| Reusable Workflow                                                                                                                  | What                                        |
| ---------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------- |
| [`reusable-actionlint.yml`](reusable-actionlint.yml)                                                                               | actionlint + shellcheck on GitHub workflows |
| [`reusable-phpcs.yml`](reusable-phpcs.yml) <br /> [`reusable-phpcs-public.yml`](reusable-phpcs-public.yml)                         | PHPCS linting                               |
| [`reusable-phpstan.yml`](reusable-phpstan.yml) <br /> [`reusable-phpstan-public.yml`](reusable-phpstan-public.yml)                 | PHPStan static analysis                     |
| [`reusable-phpunit.yml`](reusable-phpunit.yml) <br /> [`reusable-phpunit-public.yml`](reusable-phpunit-public.yml)                 | PHPUnit tests                               |
| [`reusable-lint-css-js.yml`](reusable-lint-css-js.yml) <br /> [`reusable-lint-css-js-public.yml`](reusable-lint-css-js-public.yml) | ESLint, Stylelint, Prettier, tsc linting    |
| [`reusable-jest.yml`](reusable-jest.yml) <br /> [`reusable-jest-public.yml`](reusable-jest-public.yml)                             | Jest tests                                  |
| [`reusable-e2e.yml`](reusable-e2e.yml) <br /> [`reusable-e2e-public.yml`](reusable-e2e-public.yml)                                 | Playwright end-to-end tests                 |
| [`reusable-build.yml`](reusable-build.yml) <br /> [`reusable-build-public.yml`](reusable-build-public.yml)                         | Creates a build zip (used by playground)    |

Reusable workflows have a `*-public.yml` variant which is used for public GitHub runners and should be used for public repositories. The non-public `*.yml` are meant for private repositories using private runners.

If you are using `ci.yml` in a private repository with rtCamp runners and later steps in the same job need authenticated Git operations, set `persist-credentials: true` in the `actions/checkout` step of `ci.yml`.

### Playground PR Preview: [`wp-playground-pr-preview.yml`](wp-playground-pr-preview.yml)

Triggers when `ci.yml` completes successfully on a PR, and calls:

| Reusable Workflow                                                                              | What                                                         |
| ---------------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| [`reusable-wp-playground-pr-preview-public.yml`](reusable-wp-playground-pr-preview-public.yml) | Publishes the PR build and posts a Playground preview button |

There is no private variant. See [PR Previews](#pr-previews).

### PR Cleanup: [`pr-cleanup.yml`](pr-cleanup.yml)

Triggers when a PR is closed or merged, and calls:

| Reusable Workflow                                                                                                              | What                                                                                                                                    |
| ------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------- |
| [`reusable-pr-cleanup.yml`](reusable-pr-cleanup.yml) <br /> [`reusable-pr-cleanup-public.yml`](reusable-pr-cleanup-public.yml) | Cancels the PR's in-progress runs and deletes the Actions artifacts from all of them. The public variant also deletes its preview zips. |

It uses `pull_request_target` so that PRs from forks get a token that can delete artifacts, so it must never check out or run PR code. Like `workflow_run`, it runs from the default branch, so changes only take effect once merged.

### [`test-private-workflows.yml`](test-private-workflows.yml)

Skeleton-only. Exercises the private (self-hosted runner) reusable workflows, since `ci.yml` only covers the `*-public.yml` variants. Skips PRs from forks so untrusted code never runs on self-hosted runners. Projects using the skeleton should delete it.

### [`copilot-setup-steps.yml`](copilot-setup-steps.yml)

Sets up dev environment for GitHub Copilot coding agent.

### [`pr-title.yml`](pr-title.yml)

Triggers on PRs. Validates [Conventional Commit](https://www.conventionalcommits.org/en/v1.0.0/) format, required for release-please automation.

### [`release.yml`](release.yml)

Triggers on push to `main`. Uses [release-please](https://github.com/googleapis/release-please) to automate releases based on conventional commits.

When a release is created, it builds the plugin at the release tag via `reusable-build-public.yml` (switch to `reusable-build.yml` for private runners) and uploads the zip artifact to the GitHub release.

## Configuration

`reusable-actionlint.yml` downloads a pinned actionlint release and verifies its SHA-256. Dependabot can't update it, so bump `ACTIONLINT_VERSION` and `ACTIONLINT_SHA256` together by hand.

1. `php-version`
2. `ci.yml:phpunit` matrix.

### Secrets

| Secret          | Required By                                                                                                           | Notes                                                |
| --------------- | --------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| `CODECOV_TOKEN` | `reusable-phpunit.yml` <br />`reusable-phpunit-public.yml` <br />`reusable-jest.yml` <br />`reusable-jest-public.yml` | Optional - coverage uploads fail silently without it |

### PR Previews

PR previews are split in two, so that untrusted PR code never runs with write permissions:

1. **Build:** `build-plugin-zip` in `ci.yml` sets `playground-preview: true`, which uploads the plugin zip as a `wp-playground-preview-pr<N>-<SHA>` artifact.
2. **Publish:** once `ci.yml` succeeds, `wp-playground-pr-preview.yml` uploads the zip to the `ci-artifacts` prerelease, points [`blueprint.json`](../../blueprint.json) at it, and posts the button.

`wp-playground-pr-preview.yml` always runs from the default branch, so changes to it only take effect once merged. If the `ci.yml` workflow `name` changes, update its `workflows:` too.

If an older `ci-artifacts` **draft** release exists, delete it or convert it to a prerelease. Playground cannot download draft assets.

#### Private repositories

Playground downloads the zip in the reviewer's browser without authentication, so it can't use release assets from a private repository. Delete `wp-playground-pr-preview.yml` and add your own publisher that:

1. Downloads the PR build, either the `artifact-name` artifact or the `playground-preview: true` bundle.
2. Uploads the zip somewhere Playground can reach, e.g. an S3 bucket or a temporary server.
3. Posts the button with [`WordPress/action-wp-playground-pr-preview`](https://github.com/WordPress/action-wp-playground-pr-preview), passing `blueprint.json` with the zip's URL as `blueprint`.

Anyone with the URL can download the build, so prefer unguessable or short-lived URLs, and delete them when the PR closes, e.g. with a job in `pr-cleanup.yml`.

### Testing Workflows Locally

You can use [act](https://github.com/nektos/act) to test GitHub workflows locally. The examples below use inline inputs and inline secrets only (no external JSON or .env files).

```bash
# List workflows available in this repo
act -l

# Run the full CI as a push event (map ubuntu-24.04 to an act-compatible image)
act push -P ubuntu-24.04=catthehacker/ubuntu:act-latest

# Run the `detect` job for a pull request event
act pull_request -j detect -P ubuntu-24.04=catthehacker/ubuntu:act-latest

# Trigger `ci.yml` via workflow_dispatch and run the `phpunit` job with specific inputs and secrets
act workflow_dispatch \
	--input php-version=8.2 \
	--input wp-version=latest \
	--input coverage=true \
	-j phpunit \
	-s CODECOV_TOKEN=your_codecov_token_here \
	-s GITHUB_TOKEN=your_github_token_here \
	-P ubuntu-24.04=catthehacker/ubuntu:act-latest
```
