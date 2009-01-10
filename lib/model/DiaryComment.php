<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class DiaryComment extends BaseDiaryComment
{
  public function save(PropelPDO $con = null)
  {
    if ($this->isNew() && !$this->getNumber())
    {
      $this->setNumber(DiaryCommentPeer::getMaxNumber($this->getDiaryId()) + 1);
    }

    parent::save($con);

    if ($this->getMemberId() !== $this->getDiary()->getMemberId())
    {
      DiaryCommentUnreadPeer::register($this->getDiary());
    }
  }
}
