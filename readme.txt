=== Taxonomies Sortable ===
Contributors: enrico.sorcinelli
Tags: taxonomy, admin
Requires at least: 4.4
Requires PHP: 5.2.4
Tested up to: 4.9.6
Stable tag: 1.0.1
License: GPLv2 or later

Allows to sort taxonomy terms associated to objects.

== Description ==

Taxonomies Sortable allow to sort non-hierarchical taxonomy terms associated to objects by drag&drop them on the administration interface.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/taxonomies-sortable` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.

== Usage ==

Once the plugin is installed you can make a taxonomy sortable in the following ways:

* Programmatically by adding `'sortable' => true` argument in `register_taxonomy()`.
* Programmatically by using `taxonomies_sortable` filter below.
* Using the *Settings->Taxonomies Sortable* administration screen by selecting non-hierarchical taxonomies you want to make sortable.

Note that making a taxonomy sortable, implicitly means also setting `sort => true` for that taxonomy.

== Hooks ==

**`taxonomies_sortable`**

Filter allowing to programmatically set sortable taxonomies.

`apply_filters( 'taxonomies_sortable', array $taxonomies )`

**`taxonomies_sortable_admin_settings`**

Filter allowing to display or not the plugin settings page in the administration.

`apply_filters( 'taxonomies_sortable_admin_settings', boolean $display )`

== Frequently Asked Questions ==

= Does it work with Gutenberg? =

Currently no, even if the Gutenberg support is under development.

== Screenshots ==

1. The taxonomy tags metabox drag&drop in action.
2. The setting plugin page.

== Upgrade Notice ==

= 1.0.1 =

This version fixes uninstall plugin hook.

== Changelog ==

For Taxonomies Sortable changelog, please see [the Releases page on GitHub](https://github.com/enrico-sorcinelli/taxonomies-sortable/releases).
