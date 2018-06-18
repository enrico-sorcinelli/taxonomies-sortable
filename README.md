# Taxonomies Sortable

Taxonomies Sortable is WordPress plugin that allow to sort non-hierarchical taxonomy terms associated to objects directly by drag&drop them on the tags metaboxes administration interface.

# Installation

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/taxonomies-sortable` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the _Plugins_ screen in WordPress.

# Usage

Once the plugin is installed you can make a taxonomy sortable in the following ways:

* Programmatically, by adding `'sortable' => true` argument in `register_taxonomy()`.
* Programmatically, by using `taxonomies_sortables` filter below.
* Using the _Settings->Taxonomies Sortable_ administration screen by selecting non-hierarchical taxonomies you want to make sortable.

Note that making a taxonomy sortable, implicitly means also setting `sort => true` for that taxonomy.

# Hooks

## `taxonomies_sortables`

Filter allowing to programmatically set sortable taxonomies.

```php
apply_filters( 'taxonomies_sortables', array $taxonomies )
```

## `taxonomies_sortables_admin_settings`

Filter allowing to display or not the plugin settings page in the administration.

```php
apply_filters( 'taxonomies_sortables_admin_settings', boolean $display )
```

# Frequently Asked Questions

## Does it work with Gutenberg?

Currently no, even if the Gutenberg support is under development.

# Screenshots 

### Admin tag metabox ###

The taxonomy terms sorting drag&drop in action.

![Admin metabox](https://raw.githubusercontent.com/enrico-sorcinelli/taxonomies-sortable/master/assets-wp/screenshot-1.png)

### Plugin settings ###

The plugin settings page.

![Plugin settings](https://raw.githubusercontent.com/enrico-sorcinelli/taxonomies-sortable/master/assets-wp/screenshot-2.png)

# License: GPLv2 #

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.