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
