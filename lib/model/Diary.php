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
}
