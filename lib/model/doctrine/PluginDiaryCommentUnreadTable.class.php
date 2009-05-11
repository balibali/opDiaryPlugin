<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryCommentUnreadTable
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentUnreadTable extends Doctrine_Table
{
  public function register(Diary $diary)
  {
    if ($this->find($diary->getId()))
    {
      return true;
    }

    $object = new DiaryCommentUnread();
    $object->setDiary($diary);
    $object->setMemberId($diary->getMemberId());

    return $object->save();
  }

  public function unregister(Diary $diary)
  {
    if ($object = $this->find($diary->getId()))
    {
      $object->delete();
    }
  }

  public function countUnreadDiary($memberId)
  {
    return $this->createQuery()
      ->select('COUNT(member_id)')
      ->where('member_id = ?', $memberId)
      ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
  }

  public function getOneDiaryIdByMemberId($memberId)
  {
    return $this->createQuery()
      ->select('diary_id')
      ->where('member_id = ?', $memberId)
      ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
  }
}
