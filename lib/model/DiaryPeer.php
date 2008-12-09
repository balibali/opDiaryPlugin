<?php

class DiaryPeer extends BaseDiaryPeer
{
  public static function retrieveDiaryPager($page = 1, $size = 20)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(DiaryPeer::CREATED_AT);

    $pager = new sfPropelPager('Diary', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}
