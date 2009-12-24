<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryComment
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryComment extends BaseDiaryComment
{
  public function preSave($event)
  {
    if ($this->isNew() && !$this->number)
    {
      $this->setNumber($this->getTable()->getMaxNumber($this->diary_id) + 1);
    }
  }

  public function postSave($event)
  {
    if ($this->member_id !== $this->Diary->member_id)
    {
      Doctrine::getTable('DiaryCommentUnread')->register($this->Diary);
      Doctrine::getTable('DiaryCommentUpdate')->update($this->Diary, $this->Member);
    }
  }

  public function isDeletable($memberId)
  {
    return (string)$this->member_id === (string)$memberId || $this->Diary->isAuthor($memberId);
  }

  public function getDiaryCommentImagesJoinFile()
  {
    $q = Doctrine::getTable('DiaryCommentImage')->createQuery()
      ->leftJoin('DiaryCommentImage.File')
      ->where('diary_comment_id = ?', $this->id);

    return $q->execute();
  }

  public function preDelete($event)
  {
    foreach ($this->DiaryCommentImages as $image)
    {
      $image->delete();
    }
  }
}
