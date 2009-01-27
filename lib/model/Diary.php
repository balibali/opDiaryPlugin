<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class Diary extends BaseDiary
{
  protected $previous, $next;

  public function getPublicFlagLabel()
  {
    $publicFlags = DiaryPeer::getPublicFlags();
    return $publicFlags[$this->getPublicFlag()];
  }

  public function getDiaryCommentsCriteria()
  {
    $criteria = new Criteria();
    $criteria->add(DiaryCommentPeer::DIARY_ID, $this->getId());

    return $criteria;
  }

  public function getPrevious()
  {
    if (is_null($this->previous))
    {
      $criteria = new Criteria();
      $criteria->add(DiaryPeer::MEMBER_ID, $this->getMemberId());
      $criteria->add(DiaryPeer::ID, $this->getId(), Criteria::LESS_THAN);
      $criteria->addDescendingOrderByColumn(DiaryPeer::ID);

      $this->previous = DiaryPeer::doSelectOne($criteria);
    }

    return $this->previous;
  }

  public function getNext()
  {
    if (is_null($this->next))
    {
      $criteria = new Criteria();
      $criteria->add(DiaryPeer::MEMBER_ID, $this->getMemberId());
      $criteria->add(DiaryPeer::ID, $this->getId(), Criteria::GREATER_THAN);
      $criteria->addAscendingOrderByColumn(DiaryPeer::ID);

      $this->next = DiaryPeer::doSelectOne($criteria);
    }

    return $this->next;
  }

  public function getDiaryImages($criteria = null, PropelPDO $con = null)
  {
    if (is_null($criteria))
    {
      $criteria = new Criteria();
      $criteria->addAscendingOrderByColumn(DiaryImagePeer::NUMBER);
    }

    $images = parent::getDiaryImages($criteria, $con);

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
    $flags = DiaryPeer::getViewablePublicFlags(DiaryPeer::getPublicFlagByMemberId($this->getMemberId(), $memberId));

    return in_array($this->getPublicFlag(), $flags);
  }
}
