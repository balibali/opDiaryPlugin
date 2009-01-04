<?php

/**
 * diaryComment actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryCommentActions extends opDiaryPluginActions
{
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

  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->forward404Unless(
         $this->isAuthor()
      || $this->diaryComment->getMemberId() === $this->getUser()->getMemberId()
    );
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless(
         $this->isAuthor()
      || $this->diaryComment->getMemberId() === $this->getUser()->getMemberId()
    );

    $this->diaryComment->delete();

    $this->getUser()->setFlash('notice', 'The comment was deleted successfully.');

    $this->redirect($this->generateUrl('diary_show', $this->diary));
  }
}
