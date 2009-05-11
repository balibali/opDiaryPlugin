<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryComment
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryComment extends BaseDiaryComment
{
  public function save(Doctrine_Connection $conn = null)
  {
    if ($this->isNew() && !$this->getNumber())
    {
      $this->setNumber($this->getTable()->getMaxNumber($this->getDiaryId()) + 1);
    }

    parent::save($conn);

    if ($this->getMemberId() !== $this->getDiary()->getMemberId())
    {
      Doctrine::getTable('DiaryCommentUnread')->register($this->getDiary());
    }
  }

  public function isDeletable($memberId)
  {
    return ($this->getMemberId() === $memberId || $this->getDiary()->isAuthor($memberId));
  }

  public function getDiaryCommentImagesJoinFile()
  {
    $q = Doctrine::getTable('DiaryCommentImage')->createQuery()
      ->leftJoin('File')
      ->where('diary_comment_id = ?', $this->getId());

    return $q->execute();
  }
}
