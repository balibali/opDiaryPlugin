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
    $criteria = new Criteria();
    $criteria->clearSelectColumns()->addSelectColumn(self::NUMBER);
    $criteria->add(self::DIARY_ID, $diaryId);
    $criteria->addDescendingOrderByColumn(self::NUMBER);
    $criteria->setLimit(1);

    $stmt = self::doSelectStmt($criteria);
    $row = $stmt->fetch(PDO::FETCH_NUM);

    return (int)$row[0];
  }
}
