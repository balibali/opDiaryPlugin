<?php

class DiaryComment extends BaseDiaryComment
{
  public function save(PropelPDO $con = null)
  {
    if ($this->isNew() && !$this->getNumber())
    {
      $this->setNumber(DiaryCommentPeer::getMaxNumber($this->getDiaryId()) + 1);
    }

    parent::save($con);
  }
}
