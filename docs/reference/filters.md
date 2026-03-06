# Filter Hooks

## TOC

- [Filter Hooks](#filter-hooks)
  - [TOC](#toc)
  - [`plugin_skeleton_d/template_args`](#plugin_skeleton_dtemplate_args)
- [`plugin_skeleton_d/template_file_names`](#plugin_skeleton_dtemplate_file_names)
  - [`plugin_skeleton_d/located_template`](#plugin_skeleton_dlocated_template)
  - [`plugin_skeleton_d/template_paths`](#plugin_skeleton_dtemplate_paths)

## `plugin_skeleton_d/template_args`

Filters the arguments passed to a template part.

```php
apply_filters( 'plugin_skeleton_d/template_args', array $args, string $slug, ?string $name );
```

### Parameters

- `$args (array<string, mixed>)`: Data passed to the template.
- `$slug (string)`: Template slug.
- `$name (string|null)`: Optional. Template variation name.

## `plugin_skeleton_d/template_file_names`

Filters the list of template file names to locate.

```php
apply_filters( 'plugin_skeleton_d/template_file_names', array $templates, string $slug, ?string $name );
```

### Parameters

- `$templates (array<int, string>)`: List of template file names to locate.
- `$slug (string)`: Template slug.
- `$name (string|null)`: Optional. Template variation name.

## `plugin_skeleton_d/located_template`

Filters the located template path.

```php
apply_filters( 'plugin_skeleton_d/located_template', string|false $template, string[] $templates );
```

### Parameters

- `$template (string|false)`: Full path to the located template, or false if not found.
- `$templates (string[])`: Template files that were searched for.

## `plugin_skeleton_d/template_paths`

Filters the list of paths to search for templates.

```php
apply_filters( 'plugin_skeleton_d/template_paths', array $paths );
```

### Parameters

- `$paths (array<int, string>)`: List of paths to search for templates, keyed by their priority (lower number = higher priority).
