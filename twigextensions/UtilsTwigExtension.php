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
      'classNames' => 'classNames'
    ];

    foreach ($methods as $key => $method) {
      $filters[$key] = new \Twig_Filter_Method($this, $method);
    }

    return $filters;
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
}
