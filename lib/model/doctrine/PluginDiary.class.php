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

  public function getPublicFlagLabel()
  {
    $publicFlags = $this->getTable()->getPublicFlags();

    return $publicFlags[$this->getPublicFlag()];
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
    $this->clearDiaryImages();
    $hasImages = (bool)$this->countDiaryImages();

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
    $flags = $this->getTable()->getViewablePublicFlags($this->getTable()->getPublicFlagByMemberId($this->getMemberId(), $memberId));

    return in_array($this->getPublicFlag(), $flags);
  }

  public function getDiaryImagesJoinFile()
  {
    $q = Doctrine::getTable('DiaryImage')->createQuery()
      ->leftJoin('File')
      ->where('diary_id = ?', $this->getId());

    return $q->execute();
  }
}
