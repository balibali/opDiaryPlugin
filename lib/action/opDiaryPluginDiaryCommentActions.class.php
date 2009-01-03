<?php

/**
 * diaryComment actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryCommentActions extends sfActions
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
      elseif ($object instanceof DiaryComment)
      {
        $this->diaryComment = $object;
        $this->diary = $this->diaryComment->getDiary();
        $this->setNavigation($this->diary->getMemberId());
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

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->isViewable());

    $this->form = new DiaryCommentForm();
    $this->form->getObject()->setDiary($this->diary);
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());

    $this->form->bind(
      $request->getParameter($this->form->getName()),
      $request->getFiles($this->form->getName())
    );

    if ($this->form->isValid())
    {
      $this->form->save();

      $this->redirect($this->generateUrl('diary_show', $this->diary));
    }

    $this->setTemplate('diary/show');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless(
         $this->isAuthor()
      || $this->diaryComment->getMemberId() === $this->getUser()->getMemberId()
    );

    $this->diaryComment->delete();

    $this->redirect($this->generateUrl('diary_show', $this->diary));
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
