# Action Hooks

## TOC

- [Action Hooks](#action-hooks)
  - [TOC](#toc)
  - [`plugin_skeleton_d/get_template_part_$slug`](#plugin_skeleton_dget_template_part_slug)

## `plugin_skeleton_d/get_template_part_$slug`

Fires when a template part is requested.

```php
do_action( 'plugin_skeleton_d/get_template_part_' . $slug, string $slug, ?string $name, array $args );
```

### Parameters

- `$slug (string)`: Template slug.
- `$name (string|null)`: Optional. Template variation name.
- `$args (array<string, mixed>)`: Optional. Data to pass to the template.
