<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diaryComment components.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryCommentComponents extends sfComponents
{
  public function executeList(sfWebRequest $request)
  {
    $this->order = sfReversibleDoctrinePager::normalizeOrder($request['order']);

    $this->pager = $this->getPager($request);
    $this->pager->init();
  }

  protected function getPager(sfWebRequest $request)
  {
    $q = Doctrine::getTable('DiaryComment')->createQuery()
      ->where('diary_id = ?', $this->diary->id);

    $pager = new sfReversibleDoctrinePager('DiaryComment');
    $pager->setQuery($q);
    $pager->setPage($request['page']);
    $pager->setSqlOrderColumn('number');
    $pager->setSqlOrder($this->order);
    $pager->setListOrder(sfReversibleDoctrinePager::ASC);
    if ($this->size)
    {
      $pager->setMaxPerPage($this->size);
    }

    return $pager;
  }

  public function executeHistory(sfWebRequest $request)
  {
    $max = ($this->gadget) ? $this->gadget->getConfig('max') : 5;
    $this->list = Doctrine::getTable('DiaryCommentUpdate')->getList($this->getUser()->getMember(), $max);
  }
}
