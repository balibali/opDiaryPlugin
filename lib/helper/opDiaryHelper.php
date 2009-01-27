<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

function op_diary_within_page_link($marker = '▼')
{
  static $n = 0;

  $options = array();
  if ($n)
  {
    $options['name'] = sprintf('a%d', $n);
  }
  if ($marker)
  {
    $options['href'] = sprintf('#a%d', $n+1);
  }

  $n++;

  return content_tag('a', $marker, $options);
}

/**
 * truncates a string
 *
 * @param string $string
 * @param int    $width
 * @param string $etc
 * @param int    $rows
 * @param bool   $is_html
 * @return string
 */
function op_diary_truncate($string, $width = 80, $etc = '', $rows = 1, $is_html = true)
{
  $rows = (int)$rows;
  if (!($rows > 0))
  {
    $rows = 1;
  }

  // converts special chars
  $trans = array(
    "\r\n" => ' ',
    "\r"   => ' ',
    "\n"   => ' ',
  );

  // converts special chars (for HTML)
  if ($is_html)
  {
    $trans += array(
      // for htmlspecialchars
      '&amp;'  => '&',
      '&lt;'   => '<',
      '&gt;'   => '>',
      '&quot;' => '"',
      '&#039;' => "'",
      // for IE's bug
      '　'     => ' ',
    );
  }
  $string = strtr($string, $trans);

  $result = array();
  $p_string = $string;
  for ($i = 1; $i <= $rows; $i++)
  {
    if ($i === $rows)
    {
      $p_etc = $etc;
    }
    else
    {
      $p_etc = '';
    }

    if ($i > 0)
    {
      // strips the string of pre-line
      if (isset($result[$i - 1]))
      {
        $p_string = substr($p_string, strlen($result[$i - 1]));
      }
      if (!$p_string)
      {
        break;
      }
    }

    $result[$i] = smarty_modifier_t_truncate_callback($p_string, $width, $p_etc);
  }
  $string = implode("\n", $result);

  if ($is_html)
  {
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }

  return nl2br($string);
}

function smarty_modifier_t_truncate_callback($string, $width, $etc = '')
{
  if (mb_strwidth($string) > $width)
  {
    $width = $width - mb_strwidth($etc);

    // for Emoji
    $offset = 0;
    $tmp_string = $string;
    while (preg_match('/\[[ies]:[0-9]{1,3}\]/', $tmp_string, $matches, PREG_OFFSET_CAPTURE))
    {
      $emoji_str = $matches[0][0];
      $emoji_pos = $matches[0][1] + $offset;
      $emoji_len = strlen($emoji_str);
      $emoji_width = $emoji_len;

      // a width by Emoji
      $substr_width = mb_strwidth(substr($string, 0, $emoji_pos));

      if ($substr_width >= $width)  // Emoji position is after a width
      {
        break;
      }

      if ($substr_width + 2 == $width)  // substr_width + Emoji width is equal to a width
      {
        $width = $substr_width + $emoji_width;
        break;
      }

      if ($substr_width + 2 > $width)  // substr_width + Emoji width is rather than a width
      {
        $width = $substr_width;
        break;
      }

      // less than a width
      $offset = $emoji_pos + $emoji_len;
      $width = $width + $emoji_width - 2;

      $tmp_string = substr($string, $offset);
    }

    $string = mb_strimwidth($string, 0, $width, $etc, 'UTF-8');
  }

  return $string;
}
