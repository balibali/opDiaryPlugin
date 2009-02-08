<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class DiaryPeer extends BaseDiaryPeer
{
  const PUBLIC_FLAG_OPEN    = 4;
  const PUBLIC_FLAG_SNS     = 1;
  const PUBLIC_FLAG_FRIEND  = 2;
  const PUBLIC_FLAG_PRIVATE = 3;

  protected static $publicFlags = array(
    self::PUBLIC_FLAG_OPEN    => 'All Users on the Web',
    self::PUBLIC_FLAG_SNS     => 'All Members',
    self::PUBLIC_FLAG_FRIEND  => 'My Friends',
    self::PUBLIC_FLAG_PRIVATE => 'Private',
  );

  public static function getPublicFlags()
  {
    if (!sfConfig::get('app_op_diary_plugin_is_open', false))
    {
      unset(self::$publicFlags[self::PUBLIC_FLAG_OPEN]);
    }

    return array_map(array(sfContext::getInstance()->getI18N(), '__'), self::$publicFlags);
  }

  public static function getDiaryList($limit = 5, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $criteria = self::getOrderdCriteria();
    self::addPublicFlagCriteria($criteria, $publicFlag);
    $criteria->setLimit($limit);

    return self::doSelect($criteria);
  }

  public static function getDiaryPager($page = 1, $size = 20, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $criteria = self::getOrderdCriteria();
    self::addPublicFlagCriteria($criteria, $publicFlag);

    return self::getPager($criteria, $page, $size);
  }

  public static function getMemberDiaryList($memberId, $limit = 5, $myMemberId = null)
  {
    $criteria = self::getOrderdCriteria();
    self::addMemberCriteria($criteria, $memberId, $myMemberId);
    $criteria->setLimit($limit);

    return self::doSelect($criteria);
  }

  public static function getMemberDiaryPager($memberId, $page = 1, $size = 20, $myMemberId = null, $year = null, $month = null, $day = null)
  {
    $criteria = self::getOrderdCriteria();
    self::addMemberCriteria($criteria, $memberId, $myMemberId);

    if ($year && $month)
    {
      self::addDateCriteria($criteria, $year, $month, $day);
    }

    return self::getPager($criteria, $page, $size);
  }

  public static function getMemberDiaryDays($memberId, $myMemberId, $year, $month)
  {
    $days = array();

    $criteria = new Criteria();
    self::addMemberCriteria($criteria, $memberId, $myMemberId);
    self::addDateCriteria($criteria, $year, $month);
    $criteria->clearSelectColumns()->addSelectColumn(self::CREATED_AT);

    $stmt = self::doSelectStmt($criteria);
    while ($row = $stmt->fetch(PDO::FETCH_NUM))
    {
      $day = date('j', strtotime($row[0]));
      $days[$day] = true;
    }
    return $days;
  }

  public static function getFriendDiaryList($memberId, $limit = 5)
  {
    $criteria = self::getOrderdCriteria();
    self::addFriendCriteria($criteria, $memberId);
    $criteria->setLimit($limit);

    return self::doSelect($criteria);
  }

  public static function getFriendDiaryPager($memberId, $page = 1, $size = 20)
  {
    $criteria = self::getOrderdCriteria();
    self::addFriendCriteria($criteria, $memberId);

    return self::getPager($criteria, $page, $size);
  }

  protected static function getPager(Criteria $criteria, $page, $size)
  {
    $pager = new sfPropelPager('Diary', $size);
    $pager->setCriteria($criteria);
    $pager->setPage($page);

    return $pager;
  }

  protected static function getOrderdCriteria()
  {
    $criteria = new Criteria();
    $criteria->addDescendingOrderByColumn(self::CREATED_AT);

    return $criteria;
  }

  protected static function addMemberCriteria(Criteria $criteria, $memberId, $myMemberId)
  {
    $criteria->add(self::MEMBER_ID, $memberId);
    self::addPublicFlagCriteria($criteria, self::getPublicFlagByMemberId($memberId, $myMemberId));
  }

  protected static function addFriendCriteria(Criteria $criteria, $memberId)
  {
    $friendIds = MemberRelationshipPeer::getFriendMemberIds($memberId, 5);

    $criteria->add(self::MEMBER_ID, $friendIds, Criteria::IN);
    self::addPublicFlagCriteria($criteria, self::PUBLIC_FLAG_FRIEND);
  }

  public static function addPublicFlagCriteria(Criteria $criteria, $flag)
  {
    if ($flag === self::PUBLIC_FLAG_PRIVATE)
    {
      return;
    }

    $flags = self::getViewablePublicFlags($flag);
    if (1 === count($flags))
    {
      $criteria->add(self::PUBLIC_FLAG, array_shift($flags));
    }
    else
    {
      $criteria->add(self::PUBLIC_FLAG, $flags, Criteria::IN);
    }
  }

  protected static function addDateCriteria(Criteria $criteria, $year, $month, $day = null)
  {
    if ($day)
    {
      $begin = mktime(0, 0, 0, $month, $day, $year);
      $end   = mktime(0, 0, 0, $month, $day+1, $year);
    }
    else
    {
      $begin = mktime(0, 0, 0, $month, 1, $year);
      $end   = mktime(0, 0, 0, $month+1, 1, $year);
    }

    $criteria->add(self::CREATED_AT, $begin, Criteria::GREATER_EQUAL);
    $criteria->addAnd(self::CREATED_AT, $end, Criteria::LESS_THAN);
  }

  public static function getPublicFlagByMemberId($memberId, $myMemberId, $forceFlag = null)
  {
    if ($forceFlag)
    {
      return $forceFlag;
    }

    if ($memberId == $myMemberId)
    {
      return self::PUBLIC_FLAG_PRIVATE;
    }

    $relation = MemberRelationshipPeer::retrieveByFromAndTo($myMemberId, $memberId);
    if ($relation && $relation->isFriend())
    {
      return self::PUBLIC_FLAG_FRIEND;
    }
    else
    {
      return self::PUBLIC_FLAG_SNS;
    }
  }

  public static function getViewablePublicFlags($flag)
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
}
