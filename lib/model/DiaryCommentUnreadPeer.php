<?php

class DiaryCommentUnreadPeer extends BaseDiaryCommentUnreadPeer
{
  public static function retrieveByDiary(Diary $diary)
  {
    $criteria = new Criteria();
    $criteria->add(self::DIARY_ID, $diary->getId());

    return self::doSelectOne($criteria);
  }

  public static function register(Diary $diary)
  {
    if (self::retrieveByDiary($diary))
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
    if ($object = self::retrieveByDiary($diary))
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

  public static function getOneDiaryByMemberId($memberId)
  {
    $criteria = new Criteria();
    $criteria->add(self::MEMBER_ID, $memberId);
    $one = self::doSelectOne($criteria);

    return $one->getDiary();
  }
}
