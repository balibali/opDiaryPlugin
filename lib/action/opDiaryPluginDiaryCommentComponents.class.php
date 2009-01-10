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
    $this->order = sfReversiblePropelPager::normalizeOrder($request->getParameter('order', Criteria::DESC));

    $this->pager = $this->getPager($request);
    $this->pager->init();
  }

  protected function getPager(sfWebRequest $request)
  {
    $pager = new sfReversiblePropelPager('DiaryComment');
    $pager->setCriteria($this->diary->getDiaryCommentsCriteria());
    $pager->setPage($request->getParameter('page', 1));
    $pager->setSqlOrderColumn(DiaryCommentPeer::ID);
    $pager->setSqlOrder($this->order);
    $pager->setListOrder(Criteria::ASC);
    if ($this->size)
    {
      $pager->setMaxPerPage($this->size);
    }

    return $pager;
  }
}
