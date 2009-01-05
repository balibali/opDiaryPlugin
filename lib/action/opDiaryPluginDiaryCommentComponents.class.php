<?php

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
    $this->pager = $this->getPager($request);
    $this->pager->init();
  }

  protected function getPager(sfWebRequest $request)
  {
    $pager = new sfReversiblePropelPager('DiaryComment', 20);
    $pager->setCriteria($this->diary->getDiaryCommentsCriteria());
    $pager->setPage($request->getParameter('page', 1));
    $pager->setSqlOrderColumn(DiaryCommentPeer::ID);
    $pager->setSqlOrder(Criteria::DESC);
    $pager->setListOrder(Criteria::ASC);

    return $pager;
  }
}
