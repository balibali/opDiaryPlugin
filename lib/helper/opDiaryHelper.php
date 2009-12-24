<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

function op_diary_link_to_show($diary, $withName = true, $withIcon = true)
{
  $html = '';

  $html .= link_to(op_diary_get_title_and_count($diary), op_diary_url_for_show($diary));

  if ($withName)
  {
    $html .= ' ('.$diary->getMember()->getName().')';
  }

  if ($withIcon)
  {
    $html .= op_diary_image_icon($diary);
  }

  return $html;

}

function op_diary_get_title_and_count($diary, $space = true, $width = 36)
{
  return sprintf('%s%s(%d)',
           op_truncate($diary->getTitle(), $width),
           $space ? ' ' : '',
           $diary->countDiaryComments());
}

function op_diary_image_icon($diary)
{
  $html = '';
  if ($diary->has_images)
  {
    $html = ' '.image_tag('icon_camera.gif', array('alt' => 'photo'));
  }

  return $html;
}

function op_diary_url_for_show($diary)
{
  $internalUri = '@diary_show?id='.$diary->getId();

  if ($count = $diary->countDiaryComments())
  {
    $internalUri .= '&comment_count='.$count;
  }

  return $internalUri;
}
