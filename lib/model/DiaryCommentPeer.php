<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

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
