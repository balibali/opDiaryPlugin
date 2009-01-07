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
  public function executeMyDiaryList()
  {
    $this->diaryList = DiaryPeer::getMemberDiaryList($this->getUser()->getMemberId(), 5, $this->getUser()->getMemberId());
  }

  public function executeFriendDiaryList()
  {
    $this->diaryList = DiaryPeer::getFriendDiaryList($this->getUser()->getMemberId(), 5);
  }

  public function executeMemberDiaryList(sfWebRequest $request)
  {
    $this->memberId = $request->getParameter('id', $this->getUser()->getMemberId());
    $this->diaryList = DiaryPeer::getMemberDiaryList($this->memberId, 5, $this->getUser()->getMemberId());
  }
}
