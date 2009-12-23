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
    $images = Doctrine::getTable('DiaryImage')->findByDiaryId($this->getId());
    
    $result = array();
    foreach ($images as $image)
    {
      $result[$image->getNumber()] = $image;
    }

    return $result;
  }

  public function hasImages()
  {
    return (bool)$this->getHasImages();
  }

  public function updateHasImages()
  {
    $this->clearRelated();
    $hasImages = (bool)$this->getDiaryImages();

    if ($hasImages != $this->getHasImages())
    {
      $this->setHasImages($hasImages);
      $this->save();
    }
  }

  public function isAuthor($memberId)
  {
    return ($this->getMemberId() === $memberId);
  }

  public function isViewable($memberId)
  {
    if ($this->is_open) return true;

    $flags = $this->getTable()->getViewablePublicFlags($this->getTable()->getPublicFlagByMemberId($this->getMemberId(), $memberId));

    return in_array($this->getPublicFlag(), $flags);
  }

  public function getDiaryImagesJoinFile()
  {
    $q = Doctrine::getTable('DiaryImage')->createQuery()
      ->leftJoin('DiaryImage.File')
      ->where('diary_id = ?', $this->getId());

    return $q->execute();
  }

  public function countDiaryComments($noCache = false)
  {
    if ($noCache || is_null($this->countDiaryComments))
    {
      $this->countDiaryComments = Doctrine::getTable('DiaryComment')->getCount($this->getId());
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
}
