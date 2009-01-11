<?php

class DiaryCommentUnreadPeer extends BaseDiaryCommentUnreadPeer
{
  public static function register(Diary $diary)
  {
    if (self::retrieveByPK($diary->getId()))
    {
      return true;
    }

    $object = new DiaryCommentUnread();
    $object->setDiary($diary);
    $object->setMemberId($diary->getMemberId());

    return $object->save();
  }

  public static function unregister(Diary $diary)
  {
    if ($object = self::retrieveByPK($diary->getId()))
    {
      $object->delete();
    }
  }

  public static function countUnreadDiary($memberId)
  {
    $criteria = new Criteria();
    $criteria->add(self::MEMBER_ID, $memberId);

    return self::doCount($criteria);
  }

  public static function getOneDiaryIdByMemberId($memberId)
  {
    $criteria = new Criteria();
    $criteria->add(self::MEMBER_ID, $memberId);
    $one = self::doSelectOne($criteria);

    return $one->getDiaryId();
  }
}
