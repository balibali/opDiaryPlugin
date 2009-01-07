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

  public static function getDiaryPager($page = 1, $size = 20, $publicFlag = self::PUBLIC_FLAG_SNS)
  {
    $c = self::getOrderdCriteria();
    self::addPublicFlagCriteria($c, $publicFlag);

    return self::getPager($c, $page, $size);
  }

  public static function getMemberDiaryList($memberId, $limit = 5, $myMemberId = null, $publicFlag = null)
  {
    $c = self::getOrderdCriteria();
    $c->add(self::MEMBER_ID, $memberId);
    self::addPublicFlagCriteria($c, self::getPublicFlagByMemberId($memberId, $myMemberId, $publicFlag));
    $c->setLimit($limit);

    return self::doSelect($c);
  }

  public static function getMemberDiaryPager($memberId, $page = 1, $size = 20, $myMemberId = null, $publicFlag = null)
  {
    $c = self::getOrderdCriteria();
    $c->add(self::MEMBER_ID, $memberId);
    self::addPublicFlagCriteria($c, self::getPublicFlagByMemberId($memberId, $myMemberId, $publicFlag));

    return self::getPager($c, $page, $size);
  }

  public static function getFriendDiaryList($memberId, $limit = 5)
  {
    $c = self::getOrderdCriteria();
    self::addFriendCriteria($c, $memberId);
    $c->setLimit($limit);

    return self::doSelect($c);
  }

  public static function getFriendDiaryPager($memberId, $page = 1, $size = 20)
  {
    $c = self::getOrderdCriteria();
    self::addFriendCriteria($c, $memberId);

    return self::getPager($c, $page, $size);
  }

  protected static function getPager(Criteria $c, $page, $size)
  {
    $pager = new sfPropelPager('Diary', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  protected static function getOrderdCriteria()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    
    return $c;
  }

  protected static function addFriendCriteria(Criteria $c, $memberId)
  {
    $friendIds = MemberRelationshipPeer::getFriendMemberIds($memberId, 5);

    $c->add(self::MEMBER_ID, $friendIds, Criteria::IN);
    self::addPublicFlagCriteria($c, self::PUBLIC_FLAG_FRIEND);

    return $c;
  }

  protected static function addPublicFlagCriteria(Criteria $c, $flag)
  {
    if ($flag === self::PUBLIC_FLAG_PRIVATE)
    {
      return $c;
    }

    $flags = self::getViewablePublicFlags($flag);
    if (1 === count($flags))
    {
      $c->add(self::PUBLIC_FLAG, array_shift($flags));
    }
    else
    {
      $c->add(self::PUBLIC_FLAG, $flags, Criteria::IN);
    }

    return $c;
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
