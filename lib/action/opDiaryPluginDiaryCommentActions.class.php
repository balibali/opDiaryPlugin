<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diaryComment actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryCommentActions extends opDiaryPluginActions
{
  public function executeHistory(sfWebRequest $request)
  {
    $this->pager = Doctrine::getTable('DiaryCommentUpdate')->getPager($this->member, $request['page'], 20);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->isDiaryViewable());

    $this->form = new DiaryCommentForm();
    $this->form->getObject()->Diary = $this->diary;
    $this->form->getObject()->member_id = $this->getUser()->getMemberId();

    $this->form->bind(
      $request->getParameter($this->form->getName()),
      $request->getFiles($this->form->getName())
    );

    if ($this->form->isValid())
    {
      $this->form->save();

      $this->redirectToDiaryShow();
    }

    $this->setTemplate('../../diary/templates/show');
  }

  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->forward404Unless($this->isDiaryCommentDeletable());

    $this->form = new BaseForm();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($this->isDiaryCommentDeletable());
    $request->checkCSRFProtection();

    $this->diaryComment->delete();

    $this->getUser()->setFlash('notice', 'The comment was deleted successfully.');

    $this->redirectToDiaryShow();
  }

  protected function redirectToDiaryShow()
  {
    $this->redirect('@diary_show?id='.$this->diary->id.'&comment_count='.$this->diary->countDiaryComments(true));
  }

  protected function isDiaryCommentDeletable()
  {
    return $this->diaryComment->isDeletable($this->getUser()->getMemberId());
  }
}
