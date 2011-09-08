<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary components.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryComponents extends sfComponents
{
  public function executeDiaryList()
  {
    $max = ($this->gadget) ? $this->gadget->getConfig('max') : 5;
    $this->diaryList = Doctrine::getTable('Diary')->getDiaryList($max);
  }

  public function executeMyDiaryList()
  {
    $max = ($this->gadget) ? $this->gadget->getConfig('max') : 5;
    $this->diaryList = Doctrine::getTable('Diary')->getMemberDiaryList($this->getUser()->getMemberId(), $max, $this->getUser()->getMemberId());
  }

  public function executeFriendDiaryList()
  {
    $max = ($this->gadget) ? $this->gadget->getConfig('max') : 5;
    $this->diaryList = Doctrine::getTable('Diary')->getFriendDiaryList($this->getUser()->getMemberId(), $max);
  }

  public function executeMemberDiaryList(sfWebRequest $request)
  {
    $this->memberId = $request->getParameter('id', $this->getUser()->getMemberId());
    $this->diaryList = Doctrine::getTable('Diary')->getMemberDiaryList($this->memberId, 5, $this->getUser()->getMemberId());
  }

  public function executeCautionUnreadDiaryComment(sfWebRequest $request)
  {
    $memberId = $this->getUser()->getMemberId();
    if ($this->count = Doctrine::getTable('DiaryCommentUnread')->countUnreadDiary($memberId))
    {
      $this->diary = Doctrine::getTable('DiaryCommentUnread')->findOneByMemberId($memberId)->Diary;
    }
  }

  protected function getSnsMemberId()
  {
    return $this->getUser()->isSNSMember() ? $this->getUser()->getMemberId() : null;
  }
}
