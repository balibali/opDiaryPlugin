<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiary
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiary extends BaseDiary
{
  protected $previous, $next;
  protected $countDiaryComments;

  public function getPublicFlagLabel()
  {
    $publicFlag = $this->public_flag;
    if ($this->is_open)
    {
      $publicFlag = DiaryTable::PUBLIC_FLAG_OPEN;
    }

    $publicFlags = $this->getTable()->getPublicFlags();

    return $publicFlags[$publicFlag];
  }

  public function getPrevious($myMemberId = null)
  {
    if (is_null($this->previous))
    {
      $this->previous = $this->getTable()->getPreviousDiary($this, $myMemberId);
    }

    return $this->previous;
  }

  public function getNext($myMemberId = null)
  {
    if (is_null($this->next))
    {
      $this->next = $this->getTable()->getNextDiary($this, $myMemberId);
    }

    return $this->next;
  }

  public function getDiaryImages()
  {
    $images = Doctrine::getTable('DiaryImage')->findByDiaryId($this->id);
    
    $result = array();
    foreach ($images as $image)
    {
      $result[$image->number] = $image;
    }

    return $result;
  }

  public function updateHasImages()
  {
    $hasImages = (bool)Doctrine::getTable('DiaryImage')->createQuery()
      ->where('diary_id = ?', $this->id)
      ->count();

    if ($hasImages != $this->has_images)
    {
      $this->has_images = $hasImages;
      $this->save();
    }
  }

  public function isAuthor($memberId)
  {
    return (string)$this->member_id === (string)$memberId;
  }

  public function isViewable($memberId)
  {
    if ($this->is_open) return true;

    $flags = $this->getTable()->getViewablePublicFlags($this->getTable()->getPublicFlagByMemberId($this->member_id, $memberId));

    return in_array($this->public_flag, $flags);
  }

  public function getDiaryImagesJoinFile()
  {
    $q = Doctrine::getTable('DiaryImage')->createQuery()
      ->leftJoin('DiaryImage.File')
      ->where('diary_id = ?', $this->id);

    return $q->execute();
  }

  public function countDiaryComments($noCache = false)
  {
    if ($noCache || is_null($this->countDiaryComments))
    {
      $this->countDiaryComments = Doctrine::getTable('DiaryComment')->getCount($this->id);
    }

    return $this->countDiaryComments;
  }

  public function preSave($event)
  {
    if (DiaryTable::PUBLIC_FLAG_OPEN == $this->public_flag)
    {
      $this->public_flag = DiaryTable::PUBLIC_FLAG_SNS;
      $this->is_open = true;
    }
  }

  public function preDelete($event)
  {
    $images = $this->getDiaryImages();
    foreach ($images as $image)
    {
      $image->delete();
    }
  }

  public function postInsert($event)
  {
    if (Doctrine::getTable('SnsConfig')->get('op_diary_plugin_update_activity', false))
    {
      $body = '[Diary] '.$this->title;
      $options = array(
        'public_flag' => sfConfig::get('op_activity_is_open', false) && $this->is_open ? 0 : $this->public_flag,
        'uri' => '@diary_show?id='.$this->id,
        'source' => 'Diary',
        'template' => 'diary',
        'template_param' => array('%1%' => $this->title),
      );
      Doctrine::getTable('ActivityData')->updateActivity($this->member_id, $body, $options);
    }
  }
}
