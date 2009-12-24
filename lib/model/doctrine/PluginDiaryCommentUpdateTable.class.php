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
class PluginDiaryCommentUpdateTable extends Doctrine_Table
{
  public function update(Diary $diary, Member $member)
  {
    $object = $this->find(array($diary->id, $member->id));

    if (!$object)
    {
      $object = new DiaryCommentUpdate();
      $object->setDiary($diary);
      $object->setMember($member);
    }

    $object->setMyLastCommentTime(date('Y-m-d H:i:s'));
    $object->save();

    $this->createQuery()->update()
      ->set('last_comment_time', '?', date('Y-m-d H:i:s'))
      ->where('diary_id = ?', $diary->id)
      ->execute();
  }

  public function getList(Member $member, $limit = 5)
  {
    $q = $this->getQuery($member);

    return $q->limit($limit)->execute();
  }

  public function getPager(Member $member, $page = 1, $size = 20)
  {
    $q = $this->getQuery($member);

    $pager = new sfDoctrinePager('DiaryCommentUpdate', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  protected function getQuery(Member $member)
  {
    return $this->createQuery()
      ->select('diary_id, last_comment_time')
      ->where('member_id = ?', $member->id)
      ->orderBy('last_comment_time DESC');
  }
}
