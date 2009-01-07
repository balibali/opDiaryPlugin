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
  public function getTitleAndCount($space = true)
  {
    return sprintf('%s%s(%d)',
             $this->getTitle(),
             $space ? ' ' : '',
             $this->countDiaryComments()
           );
  }

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
}
