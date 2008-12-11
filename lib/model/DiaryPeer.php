<?php

class DiaryPeer extends BaseDiaryPeer
{
  public static function retrieveByMemberId($memberId, $limit = 5)
  {
    $c = new Criteria();
    $c->add(self::MEMBER_ID, $memberId);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($limit);
    return self::doSelect($c);
  }

  public static function retrieveDiaryPager($page = 1, $size = 20)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(self::CREATED_AT);

    $pager = new sfPropelPager('Diary', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function getFriendDiaryList($memberId, $limit = 5)
  {
    $friendIds = MemberRelationshipPeer::getFriendMemberIds($memberId, 5);

    $c = new Criteria();
    $c->add(self::MEMBER_ID, $friendIds, Criteria::IN);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $c->setLimit($limit);
    return self::doSelect($c);
  }
}
