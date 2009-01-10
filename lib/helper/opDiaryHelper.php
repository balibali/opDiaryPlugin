<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

use_helper('Date');

function op_diary_format_date($date, $format = 'd', $culture = null, $charset = null)
{
  if (!$culture)
  {
    $culture = sfContext::getInstance()->getUser()->getCulture();
  }

  switch ($format)
  {
    case 'XShortDate':
      switch ($culture)
      {
        case 'ja_JP':
          $format = 'MM/dd';
          break;
        default:
          $format = 'd';
          break;
      }
      break;
    case 'XShortDateJa':
      switch ($culture)
      {
        case 'ja_JP':
          $format = 'MM月dd日';
          break;
        default:
          $format = 'd';
          break;
      }
      break;
    case 'XDateTime':
      switch ($culture)
      {
        case 'ja_JP':
          $format = "yyyy/MM/dd HH:mm";
          break;
        default:
          $format = 'f';
          break;
      }
      break;
    case 'XDateTimeJa':
      switch ($culture)
      {
        case 'ja_JP':
          $format = "yyyy年MM月dd日 HH:mm";
          break;
        default:
          $format = 'f';
          break;
      }
      break;
    case 'XDateTimeJaBr':
      switch ($culture)
      {
        case 'ja_JP':
          $format = "yyyy年\nMM月dd日\nHH:mm";
          break;
        default:
          $format = 'f';
          break;
      }
      break;
  }

  return format_date($date, $format, $culture, $charset);
}

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
