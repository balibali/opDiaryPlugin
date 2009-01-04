<?php

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
