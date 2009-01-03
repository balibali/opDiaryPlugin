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
  public function preExecute()
  {
    if (is_callable(array($this->getRoute(), 'getObject')))
    {
      $object = $this->getRoute()->getObject();
      if ($object instanceof Diary)
      {
        $this->diary = $object;
        $this->setNavigation($this->diary->getMemberId());
      }
      elseif ($object instanceof Member)
      {
        $this->member = $object;
        $this->setNavigation($this->member->getId());
      }
    }
  }

  protected function setNavigation($memberId)
  {
    if ($memberId !== $this->getUser()->getMemberId())
    {
      sfConfig::set('sf_navi_type', 'friend');
      sfConfig::set('sf_navi_id', $memberId);
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('diary', 'list');
  }

  public function executeList(sfWebRequest $request)
  {
    $this->pager = DiaryPeer::getDiaryPager($request->getParameter('page'), 20);
  }

  public function executeListMember(sfWebRequest $request)
  {
    $this->pager = DiaryPeer::getMemberDiaryPager($this->member->getId(), $request->getParameter('page'), 20, $this->getUser()->getMemberId());
  }

  public function executeListFriend(sfWebRequest $request)
  {
    $this->pager = DiaryPeer::getFriendDiaryPager($this->getUser()->getMemberId(), $request->getParameter('page'), 20);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->isViewable());

    $this->form = new DiaryCommentForm();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DiaryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new DiaryForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->isAuthor());

    $this->form = new DiaryForm($this->diary);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($this->isAuthor());

    $this->form = new DiaryForm($this->diary);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($this->isAuthor());

    $this->diary->delete();

    $this->redirect('diary/list');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      $diary = $form->save();

      $this->redirect($this->generateUrl('diary_show', $diary));
    }
  }

  protected function isAuthor()
  {
    if ($this->diary->getMemberId() === $this->getUser()->getMemberId())
    {
      return true;
    }

    return false;
  }

  protected function isViewable()
  {
    return DiaryPeer::isViewable($this->diary, $this->getUser()->getMemberId());
  }
}
