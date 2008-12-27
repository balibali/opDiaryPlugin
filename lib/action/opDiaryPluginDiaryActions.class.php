<?php

/**
 * diary actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryActions extends sfActions
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
    $this->pager = DiaryPeer::getDiaryPager($request->getParameter('page'), 20);
  }

 /**
  * Executes listMember action
  *
  * @param sfRequest $request A request object
  */
  public function executeListMember($request)
  {
    $memberId = $request->getParameter('id', $this->getUser()->getMemberId());
    $this->member = MemberPeer::retrieveByPk($memberId);
    $this->forward404unless($this->member);

    $this->pager = DiaryPeer::getMemberDiaryPager($memberId, $request->getParameter('page'), 20);

    if ($memberId !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_navi_type', 'friend');
      sfConfig::set('sf_navi_id', $memberId);
    }
  }

 /**
  * Executes listFriend action
  *
  * @param sfRequest $request A request object
  */
  public function executeListFriend($request)
  {
    $this->pager = DiaryPeer::getFriendDiaryPager($this->getUser()->getMemberId(), $request->getParameter('page'), 20);
  }

 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow($request)
  {
    $this->diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404unless($this->diary);
    if ($this->diary->getMemberId() !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_navi_type', 'friend');
      sfConfig::set('sf_navi_id', $this->diary->getMemberId());
    }
    $this->form = new DiaryCommentForm();
  }

 /**
  * Executes postComment action
  *
  * @param sfRequest $request A request object
  */
  public function executePostComment($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->diary);

    $comment = new DiaryComment();
    $comment->setDiary($this->diary);
    $comment->setMemberId($this->getUser()->getMemberId());
    $this->form = new DiaryCommentForm($comment);

    $this->form->bind($request->getParameter('diary_comment'));

    if ($this->form->isValid())
    {
      $this->form->save();
      $this->redirect('diary/show?id='.$this->diary->getId());
    }

    $this->setTemplate('show');
  }

 /**
  * Executes edit action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit($request)
  {
    $this->diary = DiaryPeer::retrieveByPk($request->getParameter('id'));
    if ($this->diary)
    {
      $this->forward404Unless($this->diary->getMemberId() === $this->getUser()->getMemberId());
    }
    $this->form = new DiaryForm($this->diary);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter('diary');
      $params['member_id'] = $this->getUser()->getMemberId();
      $this->form->bind($params, $request->getFiles('diary'));

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
    $this->forward404Unless($diary->getMemberId() === $this->getUser()->getMemberId());

    $diary->delete();
    $this->redirect('diary/list');
  }
}
