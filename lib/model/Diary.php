<?php

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
