<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary actions.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class diaryActions extends sfActions
{
  public function preExecute()
  {
    if (is_callable(array($this->getRoute(), 'getObject')))
    {
      $object = $this->getRoute()->getObject();
      if ($object instanceof Diary)
      {
        $this->diary = $object;
      }
      elseif ($object instanceof DiaryComment)
      {
        $this->diaryComment = $object;
        $this->diary = $this->diaryComment->getDiary();
      }
    }
  }

  public function executeList(sfWebRequest $request)
  {
    $this->pager = Doctrine::getTable('Diary')->getDiaryPager($request->getParameter('page'), 20, DiaryTable::PUBLIC_FLAG_PRIVATE);
    $this->pager->init();
  }

  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->form = new sfForm();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->diary->delete();

    $this->getUser()->setFlash('notice', 'The diary was deleted successfully.');

    $this->redirect('diary/list');
  }
}
