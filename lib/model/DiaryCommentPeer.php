<?php

class DiaryCommentPeer extends BaseDiaryCommentPeer
{
  public static function getMaxNumber($diaryId)
  {
    $c = new Criteria();
    $c->clearSelectColumns()->addSelectColumn(self::NUMBER);
    $c->add(self::DIARY_ID, $diaryId);
    $c->addDescendingOrderByColumn(self::NUMBER);
    $c->setLimit(1);

    $stmt = self::doSelectStmt($c);
    $row = $stmt->fetch(PDO::FETCH_NUM);

    return (int)$row[0];
  }
}
