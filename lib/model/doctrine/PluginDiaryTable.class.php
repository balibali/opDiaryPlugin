<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryTable
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryTable extends Doctrine_Table
{
  const PUBLIC_FLAG_OPEN    = 4;
  const PUBLIC_FLAG_SNS     = 1;
  const PUBLIC_FLAG_FRIEND  = 2;
  const PUBLIC_FLAG_PRIVATE = 3;

  protected static $publicFlags = array(
    self::PUBLIC_FLAG_OPEN    => 'All Users on the Web',
    self::PUBLIC_FLAG_SNS     => 'All Members',
    self::PUBLIC_FLAG_FRIEND  => '%my_friend%',
    self::PUBLIC_FLAG_PRIVATE => 'Private',
  );

  public function getPublicFlags()
  {
    if (!sfConfig::get('app_op_diary_plugin_is_open', true))
    {
      unset(self::$publicFlags[self::PUBLIC_FLAG_OPEN]);
    }

    $publicFlags = array();

    $i18n = sfContext::getInstance()->getI18N();
    $termMyFriend = Doctrine::getTable('SnsTerm')->get('my_friend');

    foreach (self::$publicFlags as $key => $publicFlag)
    {
      $terms = array('%my_friend%' => $termMyFriend->pluralize()->titleize());
      $publicFlags[$key] = $i18n->__($publicFlag, $terms, 'publicFlags');
    }

    return $publicFlags;
  }

  public function getDiaryList($limit = 5, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $q = $this->getOrderdQuery();
    $this->addPublicFlagQuery($q, $publicFlag);
    $q->limit($limit);

    return $q->execute();
  }

  public function getDiaryPager($page = 1, $size = 20, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $q = $this->getOrderdQuery();
    $this->addPublicFlagQuery($q, $publicFlag);

    return $this->getPager($q, $page, $size);
  }

  /**
   * Search keywords for diaries in the title and body
   */
  public function getDiarySearchPager($keywords, $page = 1, $size = 20, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $q = $this->getOrderdQuery();
    $this->addPublicFlagQuery($q, $publicFlag);
    $this->addSearchKeywordQuery($q, $keywords);

    $pager = new opNonCountQueryPager('Diary', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  public function getMemberDiaryList($memberId, $limit = 5, $myMemberId = null)
  {
    $q = $this->getOrderdQuery();
    $this->addMemberQuery($q, $memberId, $myMemberId);
    $q->limit($limit);

    return $q->execute();
  }

  public function getMemberDiaryPager($memberId, $page = 1, $size = 20, $myMemberId = null, $year = null, $month = null, $day = null)
  {
    $q = $this->getOrderdQuery();
    $this->addMemberQuery($q, $memberId, $myMemberId);

    if ($year && $month)
    {
      $this->addDateQuery($q, $year, $month, $day);
    }

    return $this->getPager($q, $page, $size);
  }

  public function getMemberDiaryDays($memberId, $myMemberId, $year, $month)
  {
    $days = array();

    $q = $this->createQuery()->select('created_at');
    $this->addMemberQuery($q, $memberId, $myMemberId);
    $this->addDateQuery($q, $year, $month);

    $result = $q->execute();
    foreach ($result as $row)
    {
      $day = date('j', strtotime($row['created_at']));
      $days[$day] = true;
    }

    return $days;
  }

  public function getFriendDiaryList($memberId, $limit = 5)
  {
    $q = $this->getOrderdQuery();
    $this->addFriendQuery($q, $memberId);
    $q->limit($limit);

    return $q->execute();
  }

  public function getFriendDiaryPager($memberId, $page = 1, $size = 20)
  {
    $q = $this->getOrderdQuery();
    $this->addFriendQuery($q, $memberId);

    return $this->getPager($q, $page, $size);
  }

  protected function getPager(Doctrine_Query $q, $page, $size)
  {
    $pager = new sfDoctrinePager('Diary', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  protected function getOrderdQuery()
  {
    return $this->createQuery()->orderBy('created_at DESC');
  }

  protected function addMemberQuery(Doctrine_Query $q, $memberId, $myMemberId)
  {
    $q->andWhere('member_id = ?', $memberId);
    $this->addPublicFlagQuery($q, self::getPublicFlagByMemberId($memberId, $myMemberId));
  }

  protected function addFriendQuery(Doctrine_Query $q, $memberId)
  {
    $friendIds = Doctrine::getTable('MemberRelationship')->getFriendMemberIds($memberId);
    if (!$friendIds)
    {
      $q->andWhere('1 = 0');

      return;
    }

    $q->andWhereIn('member_id', $friendIds);
    $this->addPublicFlagQuery($q, self::PUBLIC_FLAG_FRIEND);
  }

  public function addPublicFlagQuery(Doctrine_Query $q, $flag)
  {
    switch ($flag)
    {
      case self::PUBLIC_FLAG_OPEN:
        $q->andWhere('is_open = 1');
        break;

      case self::PUBLIC_FLAG_SNS:
        $q->andWhere('public_flag = ?', self::PUBLIC_FLAG_SNS);
        break;

      case self::PUBLIC_FLAG_FRIEND:
        $q->andWhereIn('public_flag', array(self::PUBLIC_FLAG_SNS, self::PUBLIC_FLAG_FRIEND));
        break;
    }
  }

  protected function addDateQuery(Doctrine_Query $q, $year, $month, $day = null)
  {
    if ($day)
    {
      $begin = sprintf('%4d-%02d-%02d 00:00:00', $year, $month, $day);
      $end   = sprintf('%4d-%02d-%02d 00:00:00', $year, $month, $day+1);
    }
    else
    {
      $begin = sprintf('%4d-%02d-01 00:00:00', $year, $month);
      $end   = sprintf('%4d-%02d-01 00:00:00', $year, $month+1);
    }

    $q->andWhere('created_at >= ?', $begin);
    $q->andWhere('created_at < ?', $end);
  }

  public function getPublicFlagByMemberId($memberId, $myMemberId, $forceFlag = null)
  {
    if ($forceFlag)
    {
      return $forceFlag;
    }

    if (null === $myMemberId)
    {
      return self::PUBLIC_FLAG_OPEN;
    }

    if ($memberId == $myMemberId)
    {
      return self::PUBLIC_FLAG_PRIVATE;
    }

    $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($myMemberId, $memberId);
    if ($relation && $relation->isFriend())
    {
      return self::PUBLIC_FLAG_FRIEND;
    }
    else
    {
      return self::PUBLIC_FLAG_SNS;
    }
  }

  public function getViewablePublicFlags($flag)
  {
    $flags = array();
    switch ($flag)
    {
      case self::PUBLIC_FLAG_PRIVATE:
        $flags[] = self::PUBLIC_FLAG_PRIVATE;
      case self::PUBLIC_FLAG_FRIEND:
        $flags[] = self::PUBLIC_FLAG_FRIEND;
      case self::PUBLIC_FLAG_SNS:
        $flags[] = self::PUBLIC_FLAG_SNS;
      case self::PUBLIC_FLAG_OPEN:
        $flags[] = self::PUBLIC_FLAG_OPEN;
        break;
    }

    return $flags;
  }

  public function getPreviousDiary(Diary $diary, $myMemberId)
  {
    $q = $this->createQuery()
      ->andWhere('member_id = ?', $diary->member_id)
      ->andWhere('id < ?', $diary->id)
      ->orderBy('id DESC');
    $this->addPublicFlagQuery($q, $this->getPublicFlagByMemberId($diary->member_id, $myMemberId));

    return $q->fetchOne();
  }

  public function getNextDiary(Diary $diary, $myMemberId)
  {
    $q = $this->createQuery()
      ->andWhere('member_id = ?', $diary->member_id)
      ->andWhere('id > ?', $diary->id)
      ->orderBy('id ASC');
    $this->addPublicFlagQuery($q, $this->getPublicFlagByMemberId($diary->member_id, $myMemberId));

    return $q->fetchOne();
  }

  protected function addSearchKeywordQuery(Doctrine_Query $q, $keywords)
  {
    foreach ($keywords as $keyword)
    {
      $q->andWhere('title LIKE ? OR body LIKE ?', array('%'.$keyword.'%', '%'.$keyword.'%'));
    }
  }
}
