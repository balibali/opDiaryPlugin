<?php

/**
 * diary components.
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginDiaryComponents extends sfComponents
{
  public function executeMyDiaryList()
  {
    $this->diaryList = DiaryPeer::getMemberDiaryList($this->getUser()->getMemberId(), 5, $this->getUser()->getMemberId());
  }

  public function executeFriendDiaryList()
  {
    $this->diaryList = DiaryPeer::getFriendDiaryList($this->getUser()->getMemberId(), 5);
  }

  public function executeMemberDiaryList($request)
  {
    $this->memberId = $request->getParameter('id', $this->getUser()->getMemberId());
    $this->diaryList = DiaryPeer::getMemberDiaryList($this->memberId, 5, $this->getUser()->getMemberId());
  }
}
