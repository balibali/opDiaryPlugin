<?php

class Diary extends BaseDiary
{
  public function getPublicFlagLabel()
  {
    $publicFlags = DiaryPeer::getPublicFlags();
    return $publicFlags[$this->getPublicFlag()];
  }
}
