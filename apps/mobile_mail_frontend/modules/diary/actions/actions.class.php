<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryActions extends opDiaryPluginMailActions
{
  public function executeCreate(opMailRequest $request)
  {
    if (!Doctrine::getTable('SnsConfig')->get('op_diary_plugin_use_email_post', true))
    {
      return sfView::NONE;
    }

    $member = $this->getRoute()->getMember();
    if (!$member)
    {
      return sfView::NONE;
    }

    $mailMessage = $request->getMailMessage();

    $title = $this->getSubject($mailMessage, '(no title)');

    $validator = new opValidatorString(array('rtrim' => true));
    try
    {
      $body = $validator->clean($mailMessage->getContent());
    }
    catch (Exception $e)
    {
      return sfView::ERROR;
    }

    $diary = new Diary();
    $diary->setMember($member);
    $diary->setTitle($title);
    $diary->setBody($body);
    $diary->setPublicFlag($this->getDefaultPublicFlag($member));

    $diaryImages = array();
    if (sfConfig::get('app_diary_is_upload_images', true))
    {
      $num = (int)sfConfig::get('app_diary_max_image_file_num', 3);
      $files = $this->getImageFiles($mailMessage, $num);

      $i = 1;
      foreach ($files as $file)
      {
        $diaryImage = new DiaryImage();
        $diaryImage->setDiary($diary);
        $diaryImage->setFile($file);
        $diaryImage->setNumber($i++);

        $diaryImages[] = $diaryImage;
        $diary->setHasImages(true);
      }
    }

    $diary->save();

    foreach ($diaryImages as $diaryImage)
    {
      $diaryImage->save();
    }

    return sfView::NONE;
  }

  protected function getDefaultPublicFlag(Member $member)
  {
    $config = $member->getConfig(MemberConfigDiaryForm::PUBLIC_FLAG);

    return $config ? $config : DiaryTable::PUBLIC_FLAG_SNS;
  }
}
