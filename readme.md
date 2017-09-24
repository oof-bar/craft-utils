# Craft Utilities

An evolving toolkit for Craft CMS. Rather than building basic feature shims, shortcuts, and customizations into each project, we've decided to extract them into a discrete bundle and make them available publicly.

Documentation will be broken down into each plugin component, as they're implemented.

## Resources

One stylesheet exists, currently with a single rule. We disable the site's name in the Control Panel when an icon is added.

## Twig Extensions

### Filters
A few proxies for buried or inaccessible Craft methods, and useful PHP methods.

#### `mdline`
A shortcut for Craft's built-in single-line Markdown parser.

#### `unique`
Quick access to `array_unique` for filtering out duplicates in an array.

#### `truncate($limit = 160)`
Crude text truncation, based on the provided character limit . If a sentence is cut off, an ellipses is added. Words are never broken.

#### `classNames`
A clean way of adding a list of classes to an HTML element, from Twig.

#### `toList($prop = null, $separator = ', ', $separatorLast = null)`
Creates a delimited list from the provided array. Accepts a nested property to pull from the constituent objects or arrays.

#### `pluck($prop)`
Pluck a property from an array of arrays or objects. Subject to failure if you have a mixed dataset, but it will gracefully handle instances of `ElementCriteriaModel`. Useful for situations where you want grab the same value from a number of objects and output them in a terse way:

```twig
<button data-related-ids="{{ entry.relationField | pluck('id') | json_encode }}">Activate Many Items</button>
```

#### `unescape`
Unescapes text with encoded HTML entities. Useful in combination with Twig's built-in `raw` filter to output HTML from a trusted third party's API that is double-escaped in a JSON response.

### Tests

#### `sequentialArray`
Unfortunately, PHP makes no fundamental distinction between associative and sequential arrays. This attempts to determine if an array is associative or not, by checking whether a new array of only the original's values is identical…

```twig
{% if ['A', 'B', 'C'] is sequentialArray %}
  Yep!
{% endif %}

{% if { one: 'Do', two: 'Re', three: 'Mi' } is sequentialArray %}
  Nope!
{% endif %}
```

## Variables

A few bits are exposed to Twig templates, via `craft.utils.methodName`. Check out `variables/UtilsVariable.php` for the full list of methods.

:deciduous_tree:
