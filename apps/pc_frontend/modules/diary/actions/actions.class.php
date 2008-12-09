<?php

/**
 * diary actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $this->forward('diary', 'list');
  }

 /**
  * Executes list action
  *
  * @param sfRequest $request A request object
  */
  public function executeList($request)
  {
    $this->pager = DiaryPeer::retrieveDiaryPager($request->getParameter('page'), 20);
  }

 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow($request)
  {
    $this->diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->diary);
  }

 /**
  * Executes edit action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit($request)
  {
    $this->diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    $this->form = new DiaryForm($this->diary);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter('diary');
      $params['member_id'] = $this->getUser()->getMemberId();
      $this->form->bind($params);

      if ($this->form->isValid())
      {
        $diary = $this->form->save();
        $this->redirect('diary/show?id='.$diary->getId());
      }
    }
  }

 /**
  * Executes delete action
  *
  * @param sfRequest $request A request object
  */
  public function executeDelete($request)
  {
    $diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($diary);
    $this->redirectUnless($diary->getMemberId() === $this->getUser()->getMemberId(), '@homepage');

    $diary->delete();
    $this->redirect('diary/list');
  }
}
