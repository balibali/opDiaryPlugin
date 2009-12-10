<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryCommentTable
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentTable extends Doctrine_Table
{
  public function getMaxNumber($diaryId)
  {
    return (int)$this->createQuery()
      ->select('MAX(number)')
      ->where('diary_id = ?', $diaryId)
      ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
  }

  public function getCount($diaryId)
  {
    return $this->createQuery()->where('diary_id = ?', $diaryId)->count();
  }

  public function getDiaryCommentPager($page = 1, $size = 20)
  {
    $q = $this->createQuery()->orderBy('created_at DESC');

    $pager = new sfDoctrinePager('DiaryComment', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }
}
