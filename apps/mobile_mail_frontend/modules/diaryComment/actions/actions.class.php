<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diaryComment actions.
 *
 * @package    OpenPNE
 * @subpackage diaryComment
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryCommentActions extends opDiaryPluginMailActions
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

    $diary = Doctrine::getTable('Diary')->find($request['id']);
    if (!$diary || !$diary->isViewable($member->id))
    {
      return sfView::NONE;
    }

    if ($diary->member_id !== $member->id)
    {
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($diary->member_id, $member->id);
      if ($relation && $relation->getIsAccessBlock())
      {
        return sfView::NONE;
      }
    }

    $mailMessage = $request->getMailMessage();

    $validator = new opValidatorString(array('rtrim' => true));
    try
    {
      $body = $validator->clean($mailMessage->getContent());
    }
    catch (Exception $e)
    {
      return sfView::ERROR;
    }

    $diaryComment = new DiaryComment();
    $diaryComment->setDiary($diary);
    $diaryComment->setMember($member);
    $diaryComment->setBody($body);

    $diaryComment->save();

    if (sfConfig::get('app_diary_comment_is_upload_images', true))
    {
      $num = (int)sfConfig::get('app_diary_comment_max_image_file_num', 3);
      $files = $this->getImageFiles($mailMessage, $num);

      foreach ($files as $file)
      {
        $image = new DiaryCommentImage();
        $image->setDiaryComment($diaryComment);
        $image->setFile($file);

        $image->save();
      }
    }

    return sfView::NONE;
  }
}
