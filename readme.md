# Craft Utilities

An evolving toolkit for Craft CMS. Rather than building basic feature shims, shortcuts, and customizations into each project, we've decided to extract them into a discrete bundle and make them available publicly.

Documentation will be broken down into each plugin component, as they're implemented.

## Resources

One stylesheet exists, currently with a single rule. We disable the site's name in the Control Panel when an icon is added.

## Twig Extensions

A few proxies for buried or inaccessible Craft methods, and useful PHP methods.

### `mdline`
A shortcut for Craft's built-in single-line Markdown parser.

### `unique`
Quick access to `array_unique` for filtering out duplicates in an array.

### `truncate`
Crude text truncation

### `classNames`
A clean way of adding a list of classes to an HTML element, from Twig.

## Variables

A few bits are exposed to Twig templates, via `craft.utils.methodName`. Check out `variables/UtilsVariable.php` for the full list of methods.

:deciduous_tree:
