<?php namespace Craft;

class UtilsTwigExtension extends \Twig_Extension
{
  public function getName()
  {
    return 'Craft Utilities Twig Extension';
  }

  public function getFilters()
  {
    $filters = [];
    $methods = [
      'mdline' => 'markdownSingleLine',
      'truncate' => 'truncate',
      'unique' => 'unique',
      'classNames' => 'classNames',
      'toList' => 'toList',
      'pluck' => 'pluck',
      'unescape' => 'unescape',
      'intoGroups' => 'intoGroups'
    ];

    foreach ($methods as $key => $method) {
      $filters[$key] = new \Twig_Filter_Method($this, $method);
    }

    return $filters;
  }

  public function getTests()
  {
    return [
      new \Twig_SimpleTest('sequentialArray', function ($value) {
        // If the array's values make up an object identical to the original array, it's probably sequential.
        return is_array($value) && array_values($value) === $value;
      })
    ];
  }

  /*
   * Twig proxy for Craft's built-in single-line markdown parsing function
   */
  public function markdownSingleLine($md)
  {
    return StringHelper::parseMarkdownLine($md);
  }

  /*
   * Coarse plain-text truncation. Strips HTML.
   */
  public function truncate($text, $limit = 160)
  {
    if (is_null($text)) return null;

    $text = strip_tags($text);
    $words = preg_split("/\s+/", $text);
    $safeWords = [];
    $length = 0;
    $currentWord = 0;

    if (count($words))
    {
      while (($length < $limit) && ($currentWord < count($words)))
      {
        $word = $words[$currentWord];
        $length = $length + strlen($word);
        array_push($safeWords, $word);

        $currentWord++;
      }

      if ($length >= $limit) {
        return join($safeWords, ' ') . '…';
      } else {
        return join($safeWords, ' ');
      }
    } else {
      return null;
    }
  }

  /*
    Twig proxy for PHP's `array_unique`
  */
  public function unique($array)
  {
    if ( is_array($array) ) {
      return array_unique($array);
    } else {
      return $array;
    }
  }

  /*
    Convenience method for using an array in an HTML
  */
  public function classNames($array)
  {
    return join(array_filter($this->unique($array)), ' ');
  }

  /*
    Converts an array-like object into a delimited list of the provided property.
  */
  public function toList($array, $prop = null, $separator = ', ', $separatorLast = null)
  {
    if (is_null($prop)) {
      // If the passed argument isn't array-like, this may not be very predictable:
      $segments = (array)$array;
    } else {
      $segments = [];

      foreach ($array as $item) {
        if (is_object($item)) {
          // Access as object property:
          $segments[] = $item->$prop;
        } elseif (is_array($item)) {
          // Access as associative array:
          $segments[] = $item[$prop];
        } else {
          // Just attempt string coercion:
          $segments[] = (string)$item;
        }
      }
    }

    if ($separatorLast) {
      return join(array_slice($segments, 0, -1), $separator) . $separatorLast . end($segments);
    } else {
      return join($segments, $separator);
    }
  }

  /*
   * Pluck an attribute off an array of objects
   */
  public function pluck($list, $key)
  {
    return array_map(function ($el) use ($key) {
      if (is_array($el))
      {
        return isset($el[$key]) ? $el[$key] : null;
      }
      elseif (is_object($el))
      {
        return isset($el->$key) ? $el->$key : null;
      }
      else
      {
        return null;
      }
    }, is_a($list, 'Craft\ElementCriteriaModel') ? $list->find() : (array)$list);
  }

  /*
   * Unescape HTML with encoded entities
   */
  public function unescape($html)
  {
    return html_entity_decode($html);
  }

  /*
   * Split an array into $n groups
   */
  public function intoGroups($array, $n)
  {
    # Prep $n for division and use as array accessor/offset:
    $n = (int)$n;

    # Make a single group and bail, if $n is invalid:
    if (!$n > 0) return [$array];

    $groups = [];
    $groupSize = round(count($array) / $n);

    # For as many groups as were requested, take chunks of $groupSize from the original array and add them to $groups:
    for ($g = 0; $g < $n; $g++) {
      $groups[$g] = array_slice($array, $g * $groupSize, $groupSize);
    }

    return $groups;
  }
}
