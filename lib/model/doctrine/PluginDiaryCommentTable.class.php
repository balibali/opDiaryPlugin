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
    $q = $this->getOrderdQuery();

    return $this->getPager($q, $page, $size);
  }

  public function getDiaryCommentPagerForDiary($diaryId, $page = 1, $size = 20)
  {
    $q = $this->createQuery()->where('diary_id = ?', $diaryId)->orderBy('number DESC');

    return $this->getPager($q, $page, $size);
  }

  public function getDiaryCommentSearchPager($keywords, $page = 1, $size = 20)
  {
    $q = $this->getOrderdQuery();
    $this->addSearchKeywordQuery($q, $keywords);

    return $this->getPager($q, $page, $size);
  }

  protected function getOrderdQuery()
  {
    return $this->createQuery()->orderBy('id DESC');
  }

  protected function getPager(Doctrine_Query $q, $page, $size)
  {
    $pager = new sfDoctrinePager('DiaryComment', $size);
    $pager->setQuery($q);
    $pager->setPage($page);

    return $pager;
  }

  protected function addSearchKeywordQuery(Doctrine_Query $q, $keywords)
  {
    foreach ($keywords as $keyword)
    {
      $q->andWhere('body LIKE ?', array('%'.$keyword.'%'));
    }
  }
}
