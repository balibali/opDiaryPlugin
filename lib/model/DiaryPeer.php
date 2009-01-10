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

  public static function getMemberDiaryList($memberId, $limit = 5, $myMemberId = null, $publicFlag = null)
  {
    $criteria = self::getOrderdCriteria();
    $criteria->add(self::MEMBER_ID, $memberId);
    self::addPublicFlagCriteria($criteria, self::getPublicFlagByMemberId($memberId, $myMemberId, $publicFlag));
    $criteria->setLimit($limit);

    return self::doSelect($criteria);
  }

  public static function getMemberDiaryPager($memberId, $page = 1, $size = 20, $myMemberId = null, $publicFlag = null)
  {
    $criteria = self::getOrderdCriteria();
    $criteria->add(self::MEMBER_ID, $memberId);
    self::addPublicFlagCriteria($criteria, self::getPublicFlagByMemberId($memberId, $myMemberId, $publicFlag));

    return self::getPager($criteria, $page, $size);
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
    $pager->init();

    return $pager;
  }

  protected static function getOrderdCriteria()
  {
    $criteria = new Criteria();
    $criteria->addDescendingOrderByColumn(self::CREATED_AT);
    
    return $criteria;
  }

  protected static function addFriendCriteria(Criteria $criteria, $memberId)
  {
    $friendIds = MemberRelationshipPeer::getFriendMemberIds($memberId, 5);

    $criteria->add(self::MEMBER_ID, $friendIds, Criteria::IN);
    self::addPublicFlagCriteria($criteria, self::PUBLIC_FLAG_FRIEND);

    return $criteria;
  }

  protected static function addPublicFlagCriteria(Criteria $criteria, $flag)
  {
    if ($flag === self::PUBLIC_FLAG_PRIVATE)
    {
      return $criteria;
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

    return $criteria;
  }

  protected static function getPublicFlagByMemberId($memberId, $myMemberId, $forceFlag = null)
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

  protected static function getViewablePublicFlags($flag)
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

  public static function isViewable(Diary $diary, $myMemberId)
  {
    $flags = self::getViewablePublicFlags(self::getPublicFlagByMemberId($diary->getMemberId(), $myMemberId));

    return in_array($diary->getPublicFlag(), $flags);
  }
}
