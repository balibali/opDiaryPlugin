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
    if ($this->find($diary->id))
    {
      return true;
    }

    $object = new DiaryCommentUnread();
    $object->setDiaryId($diary->id);
    $object->setMemberId($diary->member_id);

    return $object->save();
  }

  public function unregister(Diary $diary)
  {
    if ($object = $this->find($diary->id))
    {
      $object->delete();
    }
  }

  public function countUnreadDiary($memberId)
  {
    return $this->createQuery()->where('member_id = ?', $memberId)->count();
  }

  public function getOneDiaryIdByMemberId($memberId)
  {
    return $this->createQuery()
      ->select('diary_id')
      ->where('member_id = ?', $memberId)
      ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
  }
}
